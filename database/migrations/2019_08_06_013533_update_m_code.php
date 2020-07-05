<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMCode1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_code', function (Blueprint $table) {

            $sql = "

          DELETE FROM `m_code` 
          WHERE `category` = 'annual_income_min'; 

          DELETE FROM `m_code` 
          WHERE `category` = 'annual_income_max';
          
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','01','1','0万円','0','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','02','2','150万円','150','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','03','3','200万円','200','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','04','4','250万円','250','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','05','5','300万円','300','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','06','6','350万円','350','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','07','7','400万円','400','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','08','8','450万円','450','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','09','9','500万円','500','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','10','10','550万円','550','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','11','11','600万円','600','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','12','12','650万円','650','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','13','13','700万円','700','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','14','14','800万円','800','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','15','15','900万円','900','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','16','16','1000万円','1000','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','17','17','1100万円','1100','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','18','18','1200万円','1200','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','19','19','1300万円','1300','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','20','20','1400万円','1400','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','21','21','1500万円','1500','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','01','1','150万円','150','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','02','2','200万円','200','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','03','3','250万円','250','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','04','4','300万円','300','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','05','5','350万円','350','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','06','6','400万円','400','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','07','7','450万円','450','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','08','8','500万円','500','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','09','9','550万円','550','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','10','10','600万円','600','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','11','11','650万円','650','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','12','12','700万円','700','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','13','13','800万円','800','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','14','14','900万円','900','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','15','15','1000万円','1000','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','16','16','1100万円','1100','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','17','17','1200万円','1200','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','18','18','1300万円','1300','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','19','19','1400万円','1400','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','20','20','1500万円','1500','','','','');

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
