<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMCodeNumberOfInterviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('m_code', function (Blueprint $table) {
        $sql = "
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('number_of_interviews','0','1','その他','その他','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('number_of_interviews','1','2','1回','1回','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('number_of_interviews','2','3','2回','2回','','','','');
        ";
    
        DB::connection()->getPdo()->exec($sql);
      });
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
