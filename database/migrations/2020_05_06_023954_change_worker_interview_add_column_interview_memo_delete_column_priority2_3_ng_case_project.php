<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeWorkerInterviewAddColumnInterviewMemoDeleteColumnPriority23NgCaseProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
alter table worker_interview drop column ng_case_project;

alter table worker_interview change priority_1st priority text null;

alter table worker_interview
	add memo text null after parallel_situation;

alter table worker_interview drop column priority_2nd;

alter table worker_interview drop column priority_3rd;

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
