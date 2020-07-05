<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquiry', function (Blueprint $table) {

            $sql = "
          CREATE TABLE `inquiry` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `customer_name` VARCHAR(255) NOT NULL,
            `company_name` VARCHAR(255),
            `email` VARCHAR(255) NOT NULL,
            `phone_number` VARCHAR(255),
            `inquiry_item` VARCHAR(128) NOT NULL,
            `inquiry_message` TEXT NOT NULL,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`));

          ALTER TABLE `inquiry`
          ADD INDEX `inquiry_item_inquiry_referenced_idx` (`inquiry_item` ASC);

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
