<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePreWorkerQuestionnaireAddColumnCapital extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
        alter table pre_worker_questionnaire
          add capital varchar(11) null after ans3;

          ";

      DB::connection()->getPdo()->exec($sql);

      $sql = "
        alter table pre_worker_questionnaire
          add `working_experience` varchar(11) null after capital;
          ";

      DB::connection()->getPdo()->exec($sql);
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
