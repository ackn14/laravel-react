<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePreSignupCompanyAddColumnsProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_signup_company', function (Blueprint $table) {
            $table->integer('company_id')->unsigned()->length(11)->nullable()->after('one_time_token');
            $table->string('last_name', 255)->nullable()->after('company_id');
            $table->string('first_name', 255)->nullable()->after('last_name');
            $table->string('last_name_ruby', 255)->nullable()->after('first_name');
            $table->string('first_name_ruby', 255)->nullable()->after('last_name_ruby');
            $table->tinyInteger('age')->nullable()->after('first_name_ruby');
            $table->tinyInteger('sex')->nullable()->after('age');
            $table->tinyInteger('admin_flag')->unsigned()->default(0)->after('sex')->comment('管理者フラグ');

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
        
    }
}
