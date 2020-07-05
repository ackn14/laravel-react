<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchConditionTables extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('search_project_condition', function (Blueprint $table) {
      $table->unsignedInteger('user_engineer_id')->comment('登録者のユーザID');
      $table->string('category',255)->comment('検索区分');
      $table->string('code',255)->comment('検索値');
      $table->timestamp('create_date')->useCurrent();

      $table->primary(['user_engineer_id', 'category','code']);
      $table->foreign('user_engineer_id')->references('user_engineer_id')->on('user_engineer');
    });

    Schema::create('search_worker_condition', function (Blueprint $table) {
      $table->unsignedInteger('user_company_id')->comment('登録者の企業ユーザID');
      $table->string('category',255)->comment('検索区分');
      $table->string('code',255)->comment('検索値');
      $table->timestamp('create_date')->useCurrent();

      $table->primary(['user_company_id', 'category','code']);
      $table->foreign('user_company_id')->references('user_company_id')->on('user_company');
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
