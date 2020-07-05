<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMCodeAddCategoryBusinessTalkStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $sql = "
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) 
            VALUES
             ('business_talk_status', '01', '1', 'なし', NULL, NULL, NULL, NULL, NULL),
             ('business_talk_status', '02', '1', '提案中', NULL, NULL, NULL, NULL, NULL),
             ('business_talk_status', '03', '1', '面談設定中', NULL, NULL, NULL, NULL, NULL),
             ('business_talk_status', '04', '1', '結果待ち', NULL, NULL, NULL, NULL, NULL),
             ('business_talk_status', '05', '1', '合格（確認中）', NULL, NULL, NULL, NULL, NULL),
             ('business_talk_status', '06', '1', '諸条件回収中', NULL, NULL, NULL, NULL, NULL),
             ('business_talk_status', '07', '1', '参画決定', NULL, NULL, NULL, NULL, NULL),
             ('business_talk_status', '08', '1', 'ロスト', NULL, NULL, NULL, NULL, NULL)
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
