<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMCodeExSkill extends Migration
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
                VALUES ('ex_skill','0','1','1年未満','1年未満','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('ex_skill','1','2','2年未満','2年未満','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('ex_skill','2','3','3年未満','3年未満','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('ex_skill','3','4','5年未満','5年未満','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('ex_skill','4','5','5年以上','5年以上','','','','');
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
