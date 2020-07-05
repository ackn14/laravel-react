<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCompanyAddColumnsLatitudeLongitude extends Migration
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

          ALTER TABLE `company`
          ADD COLUMN `longitude` VARCHAR(15) NULL AFTER `company_caption`,
          ADD COLUMN `latitude` VARCHAR(15) NULL AFTER `company_caption`;

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
