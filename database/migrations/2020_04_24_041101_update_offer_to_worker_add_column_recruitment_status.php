<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferToWorkerAddColumnRecruitmentStatus extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('offer_to_worker', function (Blueprint $table) {
      $table->unsignedTinyInteger('recruitment_status')->default(0)->comment('採用ステータス')->after('worker_id');
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
