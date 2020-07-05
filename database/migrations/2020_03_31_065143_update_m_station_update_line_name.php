<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMStationUpdateLineName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('m_station', function(Blueprint $blueprint) {
        $sql = '
            UPDATE `m_station`
            SET `line_name` = "東武伊勢崎線（東武スカイツリーライン）"
            WHERE `line_id` = 21002;
          ';
    
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
