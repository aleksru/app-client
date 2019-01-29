<?php

use Illuminate\Database\Seeder;

class InitialSendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderMax = \App\Order::max('order_id');

        if($orderMax) {
            \App\SendOrder::create(['order_id' => $orderMax]);
        }
    }
}
