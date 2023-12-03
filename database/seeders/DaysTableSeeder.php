<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = [
            [
                'id'    => 1,
                'name' => ['en' => 'Sunday', 'ar' => 'الأحد']
            ],
            [
                'id'    => 2,
                'name' => ['en' => 'Monday', 'ar' => 'الاثنين']
            ],
            [
                'id'    => 3,
                'name' => ['en' => 'Tuesday', 'ar' => 'الثلاثاء']
            ],
            [
                'id'    => 4,
                'name' => ['en' => 'Wednesday', 'ar' => 'الأربعاء']
            ],
            [
                'id'    => 5,
                'name' => ['en' => 'Thursday', 'ar' => 'الخميس']
            ],
            [
                'id'    => 6,
                'name' => ['en' => 'Friday', 'ar' => 'الجمعة']
            ],
            [
                'id'    => 7,
                'name' => ['en' => 'Saturday', 'ar' => 'السبت']
            ],
        ];

        foreach ($days as $day) {
            Day::create($day);
        }
    }
}
