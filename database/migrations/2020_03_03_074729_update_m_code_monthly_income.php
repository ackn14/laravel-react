<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMCodeMonthlyIncome extends Migration
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
        UPDATE m_code
        SET display_order = 99, display_name = 'その他', col_1 = 'その他'
        WHERE category = 'monthly_income' AND code = 1;
        
        UPDATE m_code
        SET display_name = '30万〜39万', col_1 = '30万〜39万'
        WHERE category = 'monthly_income' AND code = 2;
        
        UPDATE m_code
        SET display_name = '40万〜49万', col_1 = '40万〜49万'
        WHERE category = 'monthly_income' AND code = 3;
        
        UPDATE m_code
        SET display_name = '50万〜59万', col_1 = '50万〜59万'
        WHERE category = 'monthly_income' AND code = 4;
        
        UPDATE m_code
        SET display_name = '60万〜69万', col_1 = '60万〜69万'
        WHERE category = 'monthly_income' AND code = 5;
        
        UPDATE m_code
        SET display_name = '70万〜79万', col_1 = '70万〜79万'
        WHERE category = 'monthly_income' AND code = 6;
        
        UPDATE m_code
        SET display_name = '80万〜89万', col_1 = '80万〜89万'
        WHERE category = 'monthly_income' AND code = 7;
        
        UPDATE m_code
        SET display_name = '90万〜99万', col_1 = '90万〜99万'
        WHERE category = 'monthly_income' AND code = 8;
        
        UPDATE m_code
        SET display_name = '100万以上', col_1 = '100万以上'
        WHERE category = 'monthly_income' AND code = 9;
        
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
