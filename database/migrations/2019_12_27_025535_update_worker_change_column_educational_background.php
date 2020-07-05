<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWorkerChangeColumnEducationalBackground extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('worker', function (Blueprint $table) {
        $sql = "
          ALTER TABLE `worker`
          ADD COLUMN `final_education` TINYINT(4) DEFAULT NULL AFTER `educational_background`;
          
          ALTER TABLE `worker`
          CHANGE COLUMN `educational_background` `school_name` VARCHAR(255) DEFAULT NULL;
          
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
