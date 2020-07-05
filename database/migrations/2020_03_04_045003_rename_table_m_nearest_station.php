<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableMNearestStation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
  
      Schema::table('m_nearest_station', function (Blueprint $table) {
        $sql = "
            ALTER TABLE `m_nearest_station`
            CHANGE COLUMN `nearest_station_id` `station_id` int(11) unsigned NOT NULL,
            CHANGE COLUMN `nearest_station_name` `station_name` varchar(255) NOT NULL DEFAULT '';

            RENAME TABLE `m_nearest_station`
            TO `m_station`;
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
