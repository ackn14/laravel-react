<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerDesiredAnotherFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('worker_desired_another_feature', function (Blueprint $table) {
    
        $sql = "
          CREATE TABLE `worker_desired_another_feature` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `worker_id` INT(11) UNSIGNED NOT NULL,
            `desired_another_feature_id` VARCHAR(11) NOT NULL,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE (`worker_id`, `desired_another_feature_id`));
            
            ALTER TABLE `worker_desired_another_feature`
            ADD CONSTRAINT `worker_id_worker_desired_another_feature_referenced`
              FOREIGN KEY (`worker_id`)
              REFERENCES `worker` (`worker_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `desired_another_feature_id_worker_desired_another_feature_referenced`
              FOREIGN KEY (`desired_another_feature_id`)
              REFERENCES `m_another_feature` (`another_feature_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION;
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
