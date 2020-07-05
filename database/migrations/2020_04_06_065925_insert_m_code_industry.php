<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertMCodeIndustry extends Migration
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
                VALUES ('industry','1','1','IT・通信・インターネット','IT・通信・インターネット','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','2','2','メーカー（機械・電気・電子）','メーカー（機械・電気・電子）','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','3','3','メーカー（素材・食品・医薬品他）','メーカー（素材・食品・医薬品他）','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','4','4','商社','商社','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','5','5','サービス','サービス','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','6','6','流通・小売','流通・小売','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','7','7','マスコミ・広告・デザイン','マスコミ・広告・デザイン','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','8','8','金融・保険','金融・保険','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','9','9','コンサルティング','コンサルティング','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','10','10','不動産・建設・設備','不動産・建設・設備','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','11','11','運輸・交通・物流・倉庫','運輸・交通・物流・倉庫','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('industry','99','99','その他','その他','','','','');
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
