<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMStationAddErecord113023011302302900301 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
            DELETE FROM `m_station` WHERE `m_station`.`station_id` = 1133236;
            INSERT INTO `m_station` 
            (`station_id`, `station_name`, `prefecture_id`, `city_id`, `postal_code`, `address`, `line_id`, `line_name`) VALUES
             ('1130230', '高輪ゲートウェイ', '13', '13103', '108-0075', '港区港南二丁目10-145', '11302', 'JR山手線'),
             ('1133236', '高輪ゲートウェイ', '13', '13103', '108-0075', '港区港南二丁目10-145', '11332', 'JR京浜東北線'),
             ('2900301', '羽沢横浜国大', '14', '14102', '221-0866', '横浜市神奈川区羽沢南二丁目471', '29003', '相鉄・JR直通線')
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
