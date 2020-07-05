<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMCodeAddSettlementTime extends Migration
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
                `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`)
                    VALUES ('settlement_time','1','1','時間指定','時間指定');
              INSERT INTO
                `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`)
                    VALUES ('settlement_time','2','2','固定','固定');
              INSERT INTO
                `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`)
                    VALUES ('settlement_time','3','99','その他','その他');
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
    }
}
