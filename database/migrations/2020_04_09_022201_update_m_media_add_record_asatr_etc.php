<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMMediaAddRecordAsatrEtc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
      $sql ="
      INSERT INTO `m_media` (`media_id`, `media_name`, `url`, `del_flag`)
VALUES
	('agency-star','A-STAR','https://agency-star.com/categories/engineer/',0),
	('changeup','CHANGEUP!','https://changeup.tech/',0),
	('foster','FOSTER FREELANCE','https://freelance.fosternet.jp/projects/list/',0),
	('geechs','geechs job','https://geechs-job.com/project',0),
	('high','High Performer','https://www.high-performer.jp/engineer/',0),
	('horno','HORNO','https://horno.jp/',0),
	('humalance','Humalance','https://humalance.com/',0),
	('levtech','レバテック フリーランス','https://freelance.levtech.jp/project/search/',0),
	('mid','Midworks','https://mid-works.com/',0),
	('techcareer','テクフリ','https://freelance.techcareer.jp/jobs',0);
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
