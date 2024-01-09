<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = ['E-cash', 'Cash'];
        foreach ($methods as $key => $method) {
            DB::table('payment_methods')->insert([
                'id'         => $key + 1,
                'name'       => $method,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
