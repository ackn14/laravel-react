<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectAddColumnProjectRequirements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('project', function (Blueprint $table) {
  
        $sql = "

          ALTER TABLE `project`
             ADD COLUMN `project_requirements` TEXT COMMENT '募集要項' AFTER `contract_type`
            ;

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
