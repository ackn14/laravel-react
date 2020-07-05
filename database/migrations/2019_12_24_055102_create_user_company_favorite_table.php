<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCompanyFavoriteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_company_favorite', function (Blueprint $table) {

            $sql = "

            CREATE TABLE `user_company_favorite` (
                `user_company_id` int(11) unsigned NOT NULL COMMENT '担当者ID',
                `target_type` tinyint(4) unsigned NOT NULL COMMENT '対象タイプ 1:人材',
                `target_id` int(11) unsigned NOT NULL COMMENT '対象ID',
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時刻',
                PRIMARY KEY (`user_company_id`,`target_type`,`target_id`),
                KEY `user_company_favorite_user_company_id_referenced` (`user_company_id`),
                CONSTRAINT `user_company_favorite_user_company_id_referenced` FOREIGN KEY (`user_company_id`) REFERENCES `user_company` (`user_company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
              ) ENGINE=InnoDB;

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
