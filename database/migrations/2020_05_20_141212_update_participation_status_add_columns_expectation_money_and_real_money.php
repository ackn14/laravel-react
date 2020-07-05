<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateParticipationStatusAddColumnsExpectationMoneyAndRealMoney extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participation_status', function (Blueprint $table) {
            $table->integer('expectation_money')->nullable()->default(NULL)->unsigned()->after('note')->comment('予定金額');
            $table->integer('real_money')->nullable()->default(NULL)->unsigned()->after('expectation_money')->comment('実金額');
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
