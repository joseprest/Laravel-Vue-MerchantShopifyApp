<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {

            $table->string('slug')->unique();
            $table->string('stripe_plan')->unique()->nullable();
            $table->string('yearly_stripe_plan')->unique()->nullable();
            $table->float('yearly_price');
            $table->integer('growth_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('stripe_plan');
            $table->dropColumn('yearly_stripe_plan');
            $table->dropColumn('yearly_price');
            $table->dropColumn('growth_order');
        });
    }
}
