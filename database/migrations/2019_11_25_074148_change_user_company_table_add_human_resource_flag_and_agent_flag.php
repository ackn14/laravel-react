<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserCompanyTableAddHumanResourceFlagAndAgentFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
ALTER TABLE `user_company` ADD `human_resource_flag` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0：使用不可\r\n1：使用' AFTER `remember_token`, ADD `agent_flag` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0：使用不可\r\n1：使用' AFTER `human_resource_flag`;        ";
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
