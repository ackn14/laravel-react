<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectPreviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_previews', function (Blueprint $table) {
            $sql = "

            CREATE TABLE `project_previews` (
                `project_id` INT(11) UNSIGNED NOT NULL,
                `previews` INT(11) UNSIGNED NOT NULL DEFAULT 0,
                `last_viewed_user_type` TINYINT(4) UNSIGNED,
                `last_viewed_user_id` INT(11) UNSIGNED,
                `update_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`project_id`),
                FOREIGN KEY (`project_id`)
                REFERENCES `project` (`project_id`)
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

