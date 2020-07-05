<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkerPortfolio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('worker_portfolio', function (Blueprint $table) {
    
        $sql = "

              CREATE TABLE `worker_portfolio` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `worker_id` INT(11) UNSIGNED NOT NULL,
                `portfolio_name` VARCHAR(30) NULL,
                `portfolio_detail` VARCHAR(255) NULL,
                `portfolio_file` VARCHAR(255) NOT NULL,
                `portfolio_thumbnail` VARCHAR(255) NULL,
                `del_flag` TINYINT(4) NULL DEFAULT 0,
                `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
                `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`));
            
              ALTER TABLE `worker_portfolio`
              ADD CONSTRAINT `worker_portfolio_worker_id_referenced`
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
