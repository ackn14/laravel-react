<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferToWorker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('offer_to_worker', function (Blueprint $table) {

        $sql = "
          CREATE TABLE `offer_to_worker` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_company_id` INT(11) UNSIGNED NOT NULL,
            `worker_id` INT(11) UNSIGNED NOT NULL,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`));
            
            ALTER TABLE `offer_to_worker`
            ADD CONSTRAINT `user_company_id_offer_referenced`
              FOREIGN KEY (`user_company_id`)
              REFERENCES `user_company` (`user_company_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `worker_id_offer_referenced`
              FOREIGN KEY (`worker_id`)
              REFERENCES `worker` (`worker_id`)
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
