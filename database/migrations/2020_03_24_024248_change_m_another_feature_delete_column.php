<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMAnotherFeatureDeleteColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//      一度外部キーを無視
      DB::statement('SET FOREIGN_KEY_CHECKS = 0');
      
      Schema::table('worker_desired_another_feature', function (Blueprint $table) {
        $sql = "
            DELETE FROM `worker_desired_another_feature`
            WHERE `desired_another_feature_id` = 109;
	
            UPDATE `worker_desired_another_feature`
            SET `desired_another_feature_id` = `desired_another_feature_id`-1
            WHERE `desired_another_feature_id` > 109
            ORDER BY `desired_another_feature_id` ASC;
            ";
        DB::connection()->getPdo()->exec($sql);
      });
  
      Schema::table('project_feature', function (Blueprint $table) {
        $sql = "
            DELETE FROM `project_feature`
            WHERE `project_feature_id` = 109;
	
            UPDATE `project_feature`
            SET `project_feature_id` = `project_feature_id`-1
            WHERE `project_feature_id` > 109
            ORDER BY `project_feature_id` ASC;
            ";
        DB::connection()->getPdo()->exec($sql);
      });
  
      // m_another_featureデータ削除
      Schema::table('m_another_feature', function (Blueprint $table) {
        $sql = "
            DELETE FROM `m_another_feature`
            WHERE `another_feature_id` = 109;
            
            UPDATE `m_another_feature`
            SET `another_feature_id` = `another_feature_id`-1,
                `display_order` = `display_order`-1
            WHERE `another_feature_id` > 109
            ORDER BY `another_feature_id` ASC;
            ";
        DB::connection()->getPdo()->exec($sql);
      });
  
      DB::statement('SET FOREIGN_KEY_CHECKS = 1');
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
