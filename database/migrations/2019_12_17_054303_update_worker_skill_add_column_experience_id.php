<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWorkerSkillAddColumnExperienceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('worker_skill', function (Blueprint $table) {
        $sql = "
          ALTER TABLE `worker_skill`
          ADD COLUMN `experience_id` VARCHAR(11) DEFAULT NULL AFTER `skill_id`;
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
