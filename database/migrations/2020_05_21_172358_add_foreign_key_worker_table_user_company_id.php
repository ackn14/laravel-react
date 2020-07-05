<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyWorkerTableUserCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
ALTER TABLE `worker` CHANGE `user_engineer_id` `user_engineer_id` INT UNSIGNED NULL DEFAULT NULL;
alter table worker
	add constraint worker_user_engineer_user_engineer_id_fk
		foreign key (user_engineer_id) references user_engineer (user_engineer_id);

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
