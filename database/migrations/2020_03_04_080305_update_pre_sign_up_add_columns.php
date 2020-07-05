<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePreSignUpAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_signup', function (Blueprint $table) {
          
          $sql = "
          ALTER TABLE `pre_signup`
          ADD COLUMN `phone_number` VARCHAR(255) NULL COMMENT '電話番号' AFTER `email`,
          ADD COLUMN `last_name` VARCHAR(255) NULL COMMENT '姓' AFTER `phone_number`,
          ADD COLUMN `first_name` VARCHAR(255) NULL COMMENT '名' AFTER `last_name`,
          ADD COLUMN `last_name_ruby` VARCHAR(255) NULL COMMENT '姓（ふりがな）' AFTER `first_name`,
          ADD COLUMN `first_name_ruby` VARCHAR(255) NULL COMMENT '名（ふりがな）' AFTER `last_name_ruby`,
          ADD COLUMN `birthday` DATE NULL AFTER `first_name_ruby`;
          ";
          
          DB::connection()->getpdo()->exec($sql);
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
