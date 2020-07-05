<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerSns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_sns', function (Blueprint $table) {

            $sql = "
            CREATE TABLE `worker_sns` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `worker_id` int(11) unsigned NOT NULL,
                `sns_id` varchar(11) NOT NULL DEFAULT '',
                `sns_account` varchar(255) DEFAULT NULL,
                `follow_user_num` int(11) unsigned DEFAULT NULL,
                `follower_user_num` int(11) unsigned DEFAULT NULL,
                `published_flag` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0：非公開,1：公開',
                `del_flag` tinyint(4) unsigned NOT NULL DEFAULT '0',
                `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `worker_sns_worker_id_referenced` (`worker_id`),
                CONSTRAINT `worker_sns_worker_id_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
        Schema::dropIfExists('worker_sns');
    }
}
