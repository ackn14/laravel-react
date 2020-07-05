<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMCodeInsertBusinessTalkStatus extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    //
    $sql = "
      UPDATE m_code SET code = code+2
      WHERE category = 'business_talk_status' AND code > 3
      ORDER BY code DESC;

      INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`)
      VALUES
        ('business_talk_status', '4', 1, '面談済み'),
        ('business_talk_status', '5', 1, '書類選考');

      
      UPDATE business_talk_status SET phase = phase+2
      WHERE phase > 3;
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
