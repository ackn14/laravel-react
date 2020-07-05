<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateaOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer', function (Blueprint $table) {

            $sql = "
          CREATE TABLE `offer` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `worker_id` INT(11) UNSIGNED NOT NULL,
            `project_id` INT(11) UNSIGNED NOT NULL,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`));
            
            ALTER TABLE `offer`
            ADD CONSTRAINT `worker_id_offer_referenced`
              FOREIGN KEY (`worker_id`)
              REFERENCES `worker` (`worker_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `project_id_offer_referenced`
              FOREIGN KEY (`project_id`)
              REFERENCES `project` (`project_id`)
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
