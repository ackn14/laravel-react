<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPrincipalStations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_principal_stations', function (Blueprint $table) {
          $sql = "
              CREATE TABLE `t_principal_stations` (
                `station_id` INT(11) UNSIGNED NOT NULL,
                `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`station_id`),
                CONSTRAINT `station_id_t_principal_stations_referenced`
                FOREIGN KEY (`station_id`)
                REFERENCES `m_station` (`station_id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION
              );
              
              INSERT INTO `t_principal_stations`(
                station_id
              )
              SELECT station_id
              FROM `m_station`
              WHERE line_id = 11302;
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
