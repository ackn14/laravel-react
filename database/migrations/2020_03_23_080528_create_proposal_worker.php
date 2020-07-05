<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalWorker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposal_worker', function (Blueprint $table) {
            $sql = "
            CREATE TABLE `proposal_worker` (
                `business_talk_status_id` int(11) unsigned NOT NULL,
                `worker_id` int(11) unsigned NOT NULL,
                `prefecture_id` varchar(11) DEFAULT NULL,
                `city_id` varchar(11) DEFAULT NULL,
                `desired_contract_type` varchar(11) DEFAULT NULL,
                `self_introduction` text,
                `nearest_station` varchar(255) DEFAULT NULL,
                `current_monthly_income` varchar(255) DEFAULT NULL,
                `desired_monthly_income` varchar(255) DEFAULT NULL,
                `operation_date` date DEFAULT NULL,
                `agent_comment` text COMMENT 'エージェントコメント',
                `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`business_talk_status_id`,`worker_id`),
                KEY `business_talk_status_id_proposal_worker_referenced` (`business_talk_status_id`),
                CONSTRAINT `business_talk_status_id_proposal_worker_referenced` FOREIGN KEY (`business_talk_status_id`) REFERENCES `business_talk_status` (`business_talk_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
              ) ENGINE=InnoDB AUTO_INCREMENT=18;
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
        Schema::dropIfExists('proposal_worker');
    }
}
