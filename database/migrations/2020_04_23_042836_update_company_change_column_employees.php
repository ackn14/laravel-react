<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompanyChangeColumnEmployees extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('company', function (Blueprint $table) {
      $sql = "
        ALTER TABLE `company`
        ADD COLUMN `employees_number_desc` VARCHAR(255) DEFAULT NULL AFTER `employees_number`;

        UPDATE `company`
        SET `employees_number_desc` = `employees_number`;

        UPDATE `company`
        SET `employees_number` = NULL;

        ALTER TABLE `company`
        MODIFY COLUMN `employees_number` INT(11) DEFAULT NULL;
      ";

      DB::connection()->getPdo()->exec($sql);
    });

    $c = DB::table('company')->select('company_id', 'employees_number_desc')->get();
    foreach ($c as $key => $val) {
      if(!$val->employees_number_desc) continue;
      $str = str_replace(',', '', $val->employees_number_desc);
      $arr = preg_split('/[^0-9]+/u', $str);
      if(is_numeric($arr[0])) {
        DB::table('company')->where('company_id', $val->company_id)->update(['employees_number' => (int)$arr[0]]);
      }
    }
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
