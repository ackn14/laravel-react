<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWorkerAddAgentComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // supervisor_id supervisor_commentカラム削除
        Schema::table('worker', function (Blueprint $table) {
            $sql = "
            ALTER TABLE `worker` DROP COLUMN `supervisor_id`;
            ALTER TABLE `worker` DROP COLUMN `supervisor_comment`;
            ";
            DB::connection()->getPdo()->exec($sql);
        });
    
        // 担当者コメントカラム追加
        Schema::table('worker', function (Blueprint $table) {
            $sql = "
            ALTER TABLE `worker`
            ADD COLUMN `agent_comment` TEXT NULL COMMENT 'エージェントコメント' AFTER `operation_date`;
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
