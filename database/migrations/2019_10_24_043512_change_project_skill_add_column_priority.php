<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProjectSkillAddColumnPriority extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
            ALTER TABLE `project_skill` ADD `priority` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0:必須スキル 1:尚可スキル' AFTER `project_id`;
        ";
      DB::connection()->getPdo()->exec($sql);
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
