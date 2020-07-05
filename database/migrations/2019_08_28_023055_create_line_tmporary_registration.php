<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineTmporaryRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('company', function (Blueprint $table) {

        $sql = "
            
           CREATE TABLE `line_tmporary_registration` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `line_id` varchar(255) NOT NULL COMMENT 'LINEのユーザID',
          `regist_id` varchar(255) NOT NULL DEFAULT '' COMMENT '登録時紐付けID',
          `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          UNIQUE KEY `line_id` (`line_id`)
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
