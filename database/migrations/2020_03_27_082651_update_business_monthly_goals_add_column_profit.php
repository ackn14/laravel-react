<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessMonthlyGoalsAddColumnProfit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_monthly_goals', function (Blueprint $table) {

            $sql = "

              ALTER TABLE `business_monthly_goals`
                ADD COLUMN `profit` INT(11) DEFAULT NULL COMMENT '利益' AFTER `sales`;

              ";

            DB::connection()->getPdo()->exec($sql);

          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
