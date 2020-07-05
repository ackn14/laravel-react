<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMCodeBusinessTalkStatusCodeRename extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = '
        alter table business_talk_status modify phase int(11) unsigned null;
        UPDATE m_code SET code = "1" WHERE category = "business_talk_status" AND code = "01";
        UPDATE m_code SET code = "2" WHERE category = "business_talk_status" AND code = "02";
        UPDATE m_code SET code = "3" WHERE category = "business_talk_status" AND code = "03";
        UPDATE m_code SET code = "4" WHERE category = "business_talk_status" AND code = "04";
        UPDATE m_code SET code = "5" WHERE category = "business_talk_status" AND code = "05";
        UPDATE m_code SET code = "6" WHERE category = "business_talk_status" AND code = "06";
        UPDATE m_code SET code = "7" WHERE category = "business_talk_status" AND code = "07";
        UPDATE m_code SET code = "8" WHERE category = "business_talk_status" AND code = "08";
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
