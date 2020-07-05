<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMCodeInsertMonthlyIncomeCol2 extends Migration
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
        SET col_2 = '0', col_3 = '29'
        WHERE category = 'monthly_income' AND code = 1;
        
        UPDATE m_code
        SET col_2 = '30', col_3 = '39'
        WHERE category = 'monthly_income' AND code = 2;
        
        UPDATE m_code
        SET col_2 = '40', col_3 = '49'
        WHERE category = 'monthly_income' AND code = 3;
        
        UPDATE m_code
        SET col_2 = '50', col_3 = '59'
        WHERE category = 'monthly_income' AND code = 4;
        
        UPDATE m_code
        SET col_2 = '60', col_3 = '69'
        WHERE category = 'monthly_income' AND code = 5;
        
        UPDATE m_code
        SET col_2 = '70', col_3 = '79'
        WHERE category = 'monthly_income' AND code = 6;
        
        UPDATE m_code
        SET col_2 = '80', col_3 = '89'
        WHERE category = 'monthly_income' AND code = 7;
        
        UPDATE m_code
        SET col_2 = '90', col_3 = '99'
        WHERE category = 'monthly_income' AND code = 8;
        
        UPDATE m_code
        SET col_2 = '100'
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
