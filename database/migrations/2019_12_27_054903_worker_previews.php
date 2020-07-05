<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkerPreviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_previews', function (Blueprint $table) {
            $sql = "
            CREATE TABLE `worker_previews` (
                `worker_id` INT(11) UNSIGNED NOT NULL,
                `previews` INT(11) UNSIGNED NOT NULL DEFAULT 0,
                `last_viewed_user_type` TINYINT(4) UNSIGNED,
                `last_viewed_user_id` INT(11) UNSIGNED,
                `update_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`worker_id`),
                FOREIGN KEY (`worker_id`)
                REFERENCES `worker` (`worker_id`)
            );
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

