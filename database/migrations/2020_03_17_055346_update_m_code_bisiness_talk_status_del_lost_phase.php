<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMCodeBisinessTalkStatusDelLostPhase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = '
        UPDATE business_talk_status SET lost_flag = 1 WHERE phase = 8;
        DELETE FROM m_code  WHERE category = "business_talk_status" AND code = 8;
      ';

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
