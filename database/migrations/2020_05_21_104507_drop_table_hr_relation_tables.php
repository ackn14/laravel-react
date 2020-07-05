<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableHrRelationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
      DROP TABLE IF EXISTS `hr_applicant_question`;
      DROP TABLE IF EXISTS `hr_human_resources`;
      DROP TABLE IF EXISTS `hr_selection_result`;
      DROP TABLE IF EXISTS `hr_worker_history`;
      DROP TABLE IF EXISTS `hr_applicant`;
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
