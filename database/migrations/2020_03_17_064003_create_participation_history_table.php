<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipationHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = '
          create table participation_history
          (
            participation_history_id int(11) unsigned auto_increment,
            company_id int(11) unsigned null,
            worker_id int(11) unsigned not null,
            project_id int(11) unsigned not null,
            period_start date null,
            period_end date null,
            note text null,
            del_flag tinyint default 0 null,
            create_date datetime null,
            update_date datetime null,
            constraint participation_history_pk
              primary key (participation_history_id),
            constraint participation_history_company_company_id_fk
              foreign key (company_id) references company (company_id),
            constraint participation_history_project_project_id_fk
              foreign key (project_id) references project (project_id),
            constraint participation_history_worker_worker_id_fk
              foreign key (worker_id) references worker (worker_id)
          );
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
        Schema::dropIfExists('participation_history');
    }
}
