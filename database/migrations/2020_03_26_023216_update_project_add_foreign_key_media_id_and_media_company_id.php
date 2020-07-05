<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectAddForeignKeyMediaIdAndMediaCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = '
alter table company
	add constraint company_pk
		unique (media_id, media_company_id);


alter table company alter column media_id set default null;

alter table company alter column media_company_id set default null;
          alter table project
            add constraint project_company_media_id_media_company_id_fk
              foreign key (media_id, media_company_id) references company (media_id, media_company_id);
              
alter table company
	add constraint company_m_media_media_id_fk
		foreign key (media_id) references m_media (media_id);


          ';
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
