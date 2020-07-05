<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpudateMCodeAddSelectionStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
DELETE FROM m_code WHERE category = 'selection_status';     
      
INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`)
VALUES
  ('selection_status', '001', 0, '書類選考', '書類選考', NULL, NULL, NULL, NULL),
  ('selection_status', '101', 0, '1次面接日程調整中', '1次面接日程調整中', NULL, NULL, NULL, NULL),
  ('selection_status', '102', 0, '1次面接日程確定', '1次面接日程確定', NULL, NULL, NULL, NULL),
  ('selection_status', '103', 0, '1次面接実施済', '1次面接実施済', NULL, NULL, NULL, NULL),
  ('selection_status', '201', 0, '2次面接日程調整中', '2次面接日程調整中', NULL, NULL, NULL, NULL),
  ('selection_status', '202', 0, '2次面接日程確定', '2次面接日程確定', NULL, NULL, NULL, NULL),
  ('selection_status', '203', 0, '2次面接実施済', '2次面接実施済', NULL, NULL, NULL, NULL),
  ('selection_status', '701', 0, '最終面接日程調整中', '最終面接日程調整中', NULL, NULL, NULL, NULL),
  ('selection_status', '702', 0, '最終面接日程確定', '最終面接日程確定', NULL, NULL, NULL, NULL),
  ('selection_status', '703', 0, '最終面接実施済', '最終面接実施済', NULL, NULL, NULL, NULL),
  ('selection_status', '801', 0, '内定', '内定', NULL, NULL, NULL, NULL),
  ('selection_status', '802', 0, '内定承諾', '内定承諾', NULL, NULL, NULL, NULL),
  ('selection_status', '803', 0, '入社', '入社', NULL, NULL, NULL, NULL)
  ;        
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
