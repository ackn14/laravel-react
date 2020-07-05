<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMCodeMonthlyIncomeDaysAWeekContractPeriod extends Migration
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
                VALUES ('monthly_income','1','1','30万以下','30万以下','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('monthly_income','2','2','30万〜','30万〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('monthly_income','3','3','40万〜','40万〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('monthly_income','4','4','50万〜','50万〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('monthly_income','5','5','60万〜','60万〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('monthly_income','6','6','70万〜','70万〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('monthly_income','7','7','80万〜','80万〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('monthly_income','8','8','90万〜','90万〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('monthly_income','9','9','100万以上','100万以上','','','','');
                
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('days_a_week','1','1','週1日〜','週1日〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('days_a_week','2','2','週2日〜','週2日〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('days_a_week','3','3','週3日〜','週3日〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('days_a_week','4','4','週4日〜','週4日〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('days_a_week','5','5','週5日〜','週5日〜','','','','');

          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('contract_period','1','1','1ヶ月〜','1ヶ月〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('contract_period','2','2','2ヶ月〜','2ヶ月〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('contract_period','3','3','3ヶ月〜','3ヶ月〜','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('contract_period','4','4','6ヶ月〜','6ヶ月〜','','','','');

          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('working_system','1','1','フルタイム','フルタイム','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('working_system','2','2','フレックス','フレックス','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('working_system','3','3','時短','時短','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('working_system','4','4','リモート','リモート','','','','');
          INSERT INTO
            `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
                VALUES ('working_system','5','5','時間指定','時間指定','','','','');
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
