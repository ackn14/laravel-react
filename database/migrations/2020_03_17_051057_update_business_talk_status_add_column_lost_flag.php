<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessTalkStatusAddColumnLostFlag extends Migration
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
        alter table business_talk_status
            	add lost_flag tinyint default 0 null;
            	
       	alter table business_talk_status modify lost_flag tinyint default 0 null after note;
        alter table business_talk_status modify del_flag tinyint default 0 null after lost_flag;
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
