<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWorkerWorkHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_work_history', function (Blueprint $table) {

          $sql = '
            CREATE TABLE `worker_work_history` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `worker_id` int unsigned NOT NULL,
              `company_name` varchar(50) NOT NULL COMMENT "企業名",
              `contract_type` varchar(50) DEFAULT NULL COMMENT "雇用形態",
              `business_type` varchar(50) DEFAULT NULL COMMENT "業種",
              `job_id` varchar(50) DEFAULT NULL COMMENT "職種",
              `monthly_income` varchar(50) DEFAULT NULL COMMENT "月収",
              `management_experience` tinyint(4) DEFAULT 0 COMMENT "マネジメント経験有無",
              `work_content` text COMMENT "仕事内容",
              `achievement` text COMMENT "実績",
              `start_date` date DEFAULT NULL COMMENT "就業年月日",
              `end_date` date DEFAULT NULL COMMENT "退職年月日",
              `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `worker_id_worker_work_history_referenced` (`worker_id`),
              CONSTRAINT `user_company_id_worker_work_history_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`),
              CONSTRAINT `job_id_m_job_referenced` FOREIGN KEY (`job_id`) REFERENCES `m_job` (`job_id`)
            ) ENGINE=InnoDB;
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
    }
}
