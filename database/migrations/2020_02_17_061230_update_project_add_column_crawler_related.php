<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectAddColumnCrawlerRelated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
            ALTER TABLE `project` ADD `media_id` VARCHAR(50) NULL DEFAULT NULL AFTER `company_id`, ADD `media_project_id` VARCHAR(50) NULL DEFAULT NULL AFTER `media_id`;
          ";
      DB::connection()->getPdo()->exec($sql);

      $sql = "
            ALTER TABLE `project` ADD `recruitment_end_date` DATE NULL DEFAULT NULL AFTER `recruitment_end_flag`;
          ";
      DB::connection()->getPdo()->exec($sql);

      Schema::table('project', function (Blueprint $table) {
        $table->foreign('media_id')->references('media_id')->on('m_media');
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
