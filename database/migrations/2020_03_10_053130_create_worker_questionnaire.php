<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerQuestionnaire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_questionnaire', function (Blueprint $table) {

            $sql = "
            CREATE TABLE `worker_questionnaire` (
                `worker_id` int(11) unsigned NOT NULL,
                `ans_capital` varchar(11) DEFAULT NULL,
                `ans_experience` varchar(11) DEFAULT NULL,
                `ans1` varchar(11) DEFAULT NULL,
                `ans2` varchar(11) DEFAULT NULL,
                `ans3` varchar(11) DEFAULT NULL,
                `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`worker_id`),
                KEY `worker_questionnaire_worker_id_referenced` (`worker_id`),
                CONSTRAINT `worker_questionnaire_worker_id_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
              ) ENGINE=InnoDB;
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
        Schema::dropIfExists('worker_questionnaire');
    }
}
