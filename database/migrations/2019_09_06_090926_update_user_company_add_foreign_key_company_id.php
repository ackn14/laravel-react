<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserCompanyAddForeignKeyCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('user_company', function (Blueprint $table) {
        $table->integer('company_id')->unsigned()->nullable($value = true)->after('user_company_id');
         $table->foreign('company_id')->references('company_id')->on('company');
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
