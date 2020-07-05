<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessTalkStatusAddAcolumnCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = '
            alter table business_talk_status
              add company_id int(11) unsigned not null after business_talk_status_id;
            
            alter table business_talk_status
              add constraint business_talk_status_company_company_id_fk
                foreign key (company_id) references company (company_id);
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
