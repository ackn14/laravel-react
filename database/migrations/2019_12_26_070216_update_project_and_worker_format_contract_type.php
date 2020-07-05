<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectAndWorkerFormatContractType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
            UPDATE `project`
            SET contract_type =
            CASE contract_type
              WHEN '01' THEN '1'
              WHEN '02' THEN '2'
              WHEN '11' THEN '3'
              WHEN '13' THEN '4'
              WHEN '1000' THEN '5'
              WHEN '1001' THEN '6'
              WHEN '1002' THEN '7'
              ELSE contract_type
            END;
          ";
      DB::connection()->getPdo()->exec($sql);
  
      $sql = "
            UPDATE `worker`
            SET desired_contract_type =
            CASE desired_contract_type
              WHEN '01' THEN '1'
              WHEN '02' THEN '2'
              WHEN '11' THEN '3'
              WHEN '13' THEN '4'
              WHEN '1000' THEN '5'
              WHEN '1001' THEN '6'
              WHEN '1002' THEN '7'
              ELSE desired_contract_type
            END;
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
