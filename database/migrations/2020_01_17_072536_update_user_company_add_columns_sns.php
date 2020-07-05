<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserCompanyAddColumnsSns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('user_company', function (Blueprint $table) {
    
        $sql = "

          ALTER TABLE `user_company`
            ADD COLUMN `facebook` VARCHAR(255) NULL COMMENT 'フェイスブック' AFTER `graduate_date`,
            ADD COLUMN `twitter` VARCHAR(255) NULL COMMENT 'ツイッター' AFTER `facebook`,
            ADD COLUMN `instagram` VARCHAR(255) NULL COMMENT 'インスタグラム' AFTER `twitter`
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
