<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalWorkerDesiredWorkingplace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposal_worker_desired_workingplace', function (Blueprint $table) {
            $sql = "
            CREATE TABLE `proposal_worker_desired_workingplace` (
                `business_talk_status_id` int(11) unsigned NOT NULL,
                `worker_id` int(11) unsigned NOT NULL,
                `prefecture_id` varchar(11) NOT NULL,
                `priority` tinyint(4) DEFAULT NULL COMMENT '0:第1希望 1:第2希望',
                `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`business_talk_status_id`,`worker_id`,`prefecture_id`),
                KEY `prefecture_id_worker_desired_workingplace_referenced` (`prefecture_id`),
                CONSTRAINT `prefecture_id_proposal_worker_desired_workingplace_referenced` FOREIGN KEY (`prefecture_id`) REFERENCES `m_prefecture` (`prefecture_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                CONSTRAINT `worker_id_proposal_worker_desired_workingplace_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                CONSTRAINT `business_talk_status_id_pwdw_referenced` FOREIGN KEY (`business_talk_status_id`) REFERENCES `business_talk_status` (`business_talk_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
        Schema::dropIfExists('proposal_worker_desired_workingplace');
    }
}
