<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResetEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reset_email', function (Blueprint $table) {
            $sql = "
                    CREATE TABLE `reset_email` (
                        `email` VARCHAR(255) NOT NULL,
                        `new_email` VARCHAR(255) NOT NULL,
                        `user_type` TINYINT NOT NULL,
                        `one_time_token` VARCHAR(255) NOT NULL,
                        `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
                         PRIMARY KEY (`email`),
                         UNIQUE (`email`, `one_time_token`, `user_type`)
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
        Schema::dropIfExists('reset_email');
    }
}
