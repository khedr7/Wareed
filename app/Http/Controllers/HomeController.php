<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::with(['services' => function ($query) {
            $query->withCount(['orders' => function ($query) {
                $query->where('status', 'Confirmed');
            },]);
        },])->get();
        // Sort categories based on the count of confirmed orders
        $categories = $categories->sortByDesc(function ($category) {
            $category->sum_orders_count = $category->services->sum('orders_count');
            return $category;
        });
        // Take the top five categories
        $topFiveCategories = $categories->take(5);

        $topFiveservices  = Service::withCount(['orders' => function ($query) {
            $query->where('status', 'Confirmed');
        },])->orderByDesc('orders_count')->take(5)->get();

        $counts['users']     = User::where('role', 'user')->where('status', 1)->count();
        $counts['providers'] = User::where('role', 'provider')->where('status', 1)->count();
        $counts['categoris'] = count($categories);
        $counts['services']  = Service::where('status', 1)->count();


        // orders yearly
        $currentYear = now()->year;
        $annual_orders_count = array_fill(0, 11, 0);

        $ordersByMonth = Order::where('status', 'Confirmed')
            ->whereYear('date', $currentYear)
            ->groupByRaw('MONTH(date)')
            ->orderByRaw('MONTH(date)')
            ->selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->pluck('count', 'month')
            ->toArray();

        foreach ($ordersByMonth as $month => $count) {
            $annual_orders_count[$month] = (int)$count;
        }

        //  top countris
        $states = State::with(['cities' => function ($query) {
            $query->withCount(['users']);
        },])->get();
        // Sort states based on the count of confirmed users
        $states = $states->sortByDesc(function ($state) {
            $state->users_count = $state->cities->sum('users_count');
            return $state;
        });

        $topCountries = $states->filter(function ($model) {
            return $model->users_count != 0;
        });

        $topCountriesCount = $topCountries->count();

        $country_names = [];
        $country_counts = [];
        foreach ($topCountries as $value) {
            array_push($country_names, $value->name);
            array_push($country_counts, $value->users_count);
        }

        return view('home', compact(
            "counts",
            'topFiveCategories',
            'topFiveservices',
            'annual_orders_count',
            'country_names',
            'country_counts'
        ));
    }
}
