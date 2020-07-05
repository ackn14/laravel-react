<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateParticipationHistoryChangeTableNameParticipationStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = '
            rename table participation_history to participation_status;
            alter table participation_status change participation_history_id participation_status_id int unsigned auto_increment;

            alter table participation_status drop foreign key participation_history_company_company_id_fk;
            
            alter table participation_status drop foreign key participation_history_project_project_id_fk;
            
            alter table participation_status drop foreign key participation_history_worker_worker_id_fk;
            
            alter table participation_status
              add constraint participation_status_company_company_id_fk
                foreign key (company_id) references company (company_id);
            
            alter table participation_status
              add constraint participation_status_project_project_id_fk
                foreign key (project_id) references project (project_id);
            
            alter table participation_status
              add constraint participation_status_worker_worker_id_fk
                foreign key (worker_id) references worker (worker_id);


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
