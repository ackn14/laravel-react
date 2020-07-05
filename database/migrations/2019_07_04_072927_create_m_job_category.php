<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMJobCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_job_category', function (Blueprint $table) {

            $sql = "
          CREATE TABLE `m_job_category` (
            `job_category_id` VARCHAR(11) NOT NULL,
            `job_category_name` VARCHAR(255) NOT NULL,
            `display_order` INT(8) NOT NULL,
            PRIMARY KEY (`job_category_id`));
            
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('100','セールス','1');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('200','バックオフィス','2');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('300','事業責任者','3');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('400','コンサル','4');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('500','PM・PL','5');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('600','PG・SE','6');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('700','運用・保守','7');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('800','ディレクター','8');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('900','ライター','9');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('1000','デザイナー','10');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('1100','Eコマース','11');
          INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('99999999999','その他','12');
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
