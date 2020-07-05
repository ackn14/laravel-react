<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertMMediaFreelanceStart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      $sql = "
      INSERT INTO `m_media` (`media_id`, `media_name`, `url`, `del_flag`) VALUES ('freelance-start','フリーランススタート','https://freelance-start.com/','0');
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
