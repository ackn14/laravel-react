<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerDesiredWorkingplace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_desired_workingplace', function (Blueprint $table) {

            $sql = "
          CREATE TABLE `worker_desired_workingplace` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `worker_id` INT(11) UNSIGNED NOT NULL,
            `prefecture_id` VARCHAR(11) NOT NULL,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE (`worker_id`, `prefecture_id`));
            
            ALTER TABLE `worker_desired_workingplace`
            ADD CONSTRAINT `worker_id_worker_desired_workingplace_referenced`
              FOREIGN KEY (`worker_id`)
              REFERENCES `worker` (`worker_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `prefecture_id_worker_desired_workingplace_referenced`
              FOREIGN KEY (`prefecture_id`)
              REFERENCES `m_prefecture` (`prefecture_id`)
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
