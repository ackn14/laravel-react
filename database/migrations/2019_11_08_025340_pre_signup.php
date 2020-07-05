<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PreSignup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('pre_signup', function (Blueprint $table) {

				$sql = "
				CREATE TABLE `pre_signup` (
					`email` VARCHAR(255) NOT NULL,
					`one_time_token` VARCHAR(255),
					`create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
					 PRIMARY KEY (`email`, `one_time_token`),
					 UNIQUE (`email`)
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
