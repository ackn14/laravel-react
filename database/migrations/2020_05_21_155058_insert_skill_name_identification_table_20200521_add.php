<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertSkillNameIdentificationTable20200521Add extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
TRUNCATE TABLE skill_name_identification;
INSERT INTO `skill_name_identification` (`skill_id`, `skill_name`)
VALUES
	('10','AWS'),
	('135','Office'),
	('19','C#'),
	('19','C#.NET'),
	('106','VB'),
	('106','VB.NET'),
	('1','.NET'),
	('18','C++'),
	('18','C言語'),
	('56','Azure'),
	('39','CSS3'),
	('39','HTML5');
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
