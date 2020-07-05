<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertMCodeSkillClass extends Migration
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
                  VALUES ('skill_class','1','1','デザイナー','デザイナー','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('skill_class','2','2','エンジニア','エンジニア','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('skill_class','3','3','マネジメント','マネジメント','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('skill_class','4','4','バックオフィス','バックオフィス','','','','');
            INSERT INTO
              `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                  VALUES ('skill_class','5','5','インフラ','インフラ','','','','');
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
