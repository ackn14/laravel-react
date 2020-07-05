<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkerReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('worker_reviews', function (Blueprint $table) {
    
        $sql = "
        
              CREATE TABLE `worker_reviews` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `worker_id` int(11) unsigned NOT NULL COMMENT '求職者ID',
                `user_company_id` int(11) unsigned NOT NULL COMMENT '担当者ID',
                `review_rating` tinyint(4) unsigned NOT NULL COMMENT '評価レート',
                `review_title` varchar(255) NULL COMMENT 'レビュータイトル',
                `review_text` text COMMENT 'レビュー本文',
                `release_flag` tinyint(4) NOT NULL DEFAULT '0',
                `del_flag` tinyint(4) NOT NULL DEFAULT '0',
                `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY (`worker_id`,`user_company_id`),
                CONSTRAINT `worker_reviews_user_company_id_foreign` FOREIGN KEY (`user_company_id`) REFERENCES `user_company` (`user_company_id`),
                CONSTRAINT `worker_reviews_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`)
              );

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
