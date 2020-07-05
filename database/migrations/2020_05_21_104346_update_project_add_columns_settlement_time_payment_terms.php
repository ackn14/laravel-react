<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectAddColumnsSettlementTimePaymentTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->integer('settlement_time_min')->length(11)->nullable()->after('settlement_time')->comment('精算幅下限');
            $table->integer('settlement_time_max')->length(11)->nullable()->after('settlement_time_min')->comment('精算幅上限');
            $table->integer('payment_terms')->length(11)->nullable()->after('settlement_time_max')->comment('支払いサイト');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
