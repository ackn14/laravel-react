<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameMProjectFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // 外部キー削除
      Schema::table('project_feature', function (Blueprint $table) {

        $sql = "
          ALTER TABLE `project_feature`
          DROP FOREIGN KEY `project_feature_id_project_feature_referenced`;
          ";

        DB::connection()->getPdo()->exec($sql);
      });
      
      // m_project_featureリネーム
      Schema::rename('m_project_feature', 'm_another_feature');
  
      // カラム名変更
      Schema::table('m_another_feature', function (Blueprint $table) {

        $sql = "
          ALTER TABLE `m_another_feature`
          CHANGE `project_feature_id` `another_feature_id` varchar(11) NOT NULL,
          CHANGE `project_feature_name` `another_feature_name` varchar(255) NOT NULL;
          ";

        DB::connection()->getPdo()->exec($sql);
      });
      
      // 外部キー作り直し
      Schema::table('project_feature', function (Blueprint $table) {

        $sql = "
          ALTER TABLE `project_feature`
          ADD CONSTRAINT `project_feature_id_project_feature_referenced`
          FOREIGN KEY (`project_feature_id`)
          REFERENCES `m_another_feature` (`another_feature_id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION;
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
