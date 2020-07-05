<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMAnotherFeatureInsert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_another_feature', function (Blueprint $table) {

          $sql = "
            UPDATE m_another_feature
            SET another_feature_name = '食事補助あり'
            WHERE another_feature_id = '113';

            UPDATE m_another_feature
            SET display_order = display_order+2
            WHERE display_order > 2;

            INSERT INTO `m_another_feature` (`another_feature_id`, `another_feature_name`, `display_order`)
            VALUES ('119','短期案件',3),
            ('120','週２～３勤務',4);
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
