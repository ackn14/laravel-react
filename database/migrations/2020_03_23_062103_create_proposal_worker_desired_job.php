<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalWorkerDesiredJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposal_worker_desired_job', function (Blueprint $table) {

            $sql = "
            CREATE TABLE `proposal_worker_desired_job` (
                `business_talk_status_id` int(11) unsigned NOT NULL,
                `worker_id` int(11) unsigned NOT NULL,
                `desired_job_id` varchar(11) NOT NULL,
                `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`business_talk_status_id`,`worker_id`,`desired_job_id`),
                KEY `desired_job_id_worker_desired_job_referenced` (`desired_job_id`),
                CONSTRAINT `desired_job_id_proposal_worker_desired_job_referenced` FOREIGN KEY (`desired_job_id`) REFERENCES `m_job` (`job_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                CONSTRAINT `worker_id_proposal_worker_desired_job_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                CONSTRAINT `business_talk_status_id_proposal_worker_desired_job_referenced` FOREIGN KEY (`business_talk_status_id`) REFERENCES `business_talk_status` (`business_talk_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
        Schema::dropIfExists('proposal_worker_desired_job');
    }
}
