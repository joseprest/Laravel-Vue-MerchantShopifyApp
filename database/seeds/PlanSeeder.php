<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'id' => 1,
                'name' => 'Free',
                'slug' => 'free',
                'stripe_plan' => null,
                'yearly_stripe_plan' => null,
                'price' => 0,
                'yearly_price' => 0,
                'growth_order' => 0,
            ],
            [
                'id' => 2,
                'name' => 'Growth',
                'slug' => 'growth',
                'stripe_plan' => 'price_1Gzkt5HGCU1196cHUbjCLr2z',
                'yearly_stripe_plan' => 'price_1HG7tPHGCU1196cHelSD1vtG',
                'price' => 49,
                'yearly_price' => 490,
                'growth_order' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Ultimate',
                'slug' => 'ultimate',
                'stripe_plan' => 'price_1HGApwHGCU1196cHVGX7gFUP',
                'yearly_stripe_plan' => 'price_1HGAmfHGCU1196cHjX4nnKo3',
                'price' => 249,
                'yearly_price' => 2490,
                'growth_order' => 2,
            ],
            [
                'id' => 4,
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'stripe_plan' => 'price_1HGAs2HGCU1196cHYjoNwvxL',
                'yearly_stripe_plan' => 'price_1HGAsJHGCU1196cHhluR5Om0',
                'price' => 599,
                'yearly_price' => 5990,
                'growth_order' => 3
            ],
        ];

        DB::table('plans')->delete();
        DB::query("DBCC CHECKIDENT('plans', RESEED, 0)"); // reset table id counter
        DB::table('plans')->insert($plans);
    }
}
