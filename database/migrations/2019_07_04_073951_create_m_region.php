<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMRegion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_region', function (Blueprint $table) {
            $sql = "

          CREATE TABLE `m_region` (
          `region_id` VARCHAR(11) NOT NULL,
          `region_name` VARCHAR(255) NOT NULL,
          `display_order` INT(8) NOT NULL,
          PRIMARY KEY (`region_id`));
          
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('0', '未選択', '1');
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('1', '北海道', '2');
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('2', '東北', '3');
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('3', '関東', '4');
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('4', '中部', '5');
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('5', '近畿', '6');
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('6', '中国', '7');
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('7', '四国', '8');
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('8', '九州', '9');
          INSERT INTO `m_region` (`region_id`, `region_name`, `display_order`) VALUES ('9', '海外', '10');
          
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
