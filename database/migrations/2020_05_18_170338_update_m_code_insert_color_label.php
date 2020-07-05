<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMCodeInsertColorLabel extends Migration
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
                  VALUES ('color_label','1','1','緑','3eb370','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','2','2','黄緑','98d98e','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','3','3','黄色','f7b52b','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','4','4','オレンジ','ef6443','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','5','5','ピンク','f09199','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','6','6','赤','e60033','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','7','7','紫','5b5a86','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','8','8','青','1f5abc','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','9','9','水色','2ac1df','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','10','10','黒','333333','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('color_label','11','11','グレー','707070','','','','');
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
