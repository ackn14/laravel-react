<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalWorkerDesiredAnotherFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposal_worker_desired_another_feature', function (Blueprint $table) {
            $sql = "
            CREATE TABLE `proposal_worker_desired_another_feature` (
                `business_talk_status_id` int(11) unsigned NOT NULL,
                `worker_id` int(11) unsigned NOT NULL,
                `desired_another_feature_id` varchar(11) NOT NULL,
                `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`business_talk_status_id`,`worker_id`,`desired_another_feature_id`),
                KEY `desired_another_feature_id_referenced` (`desired_another_feature_id`),
                CONSTRAINT `desired_another_feature_id_pwdaf_referenced` FOREIGN KEY (`desired_another_feature_id`) REFERENCES `m_another_feature` (`another_feature_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                CONSTRAINT `worker_id_proposal_worker_desired_another_feature_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                CONSTRAINT `business_talk_status_id_pwdaf_referenced` FOREIGN KEY (`business_talk_status_id`) REFERENCES `business_talk_status` (`business_talk_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
        Schema::dropIfExists('proposal_worker_desired_another_feature');
    }
}
