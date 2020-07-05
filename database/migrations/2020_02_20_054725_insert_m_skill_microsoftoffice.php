<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertMSkillMicrosoftoffice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
INSERT INTO `m_skill` (`skill_id`, `skill_category_id`, `skill_name`, `display_order`) VALUES ('135', NULL, 'Microsoft Office', '135')
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
