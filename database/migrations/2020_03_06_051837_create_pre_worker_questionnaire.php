<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreWorkerQuestionnaire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
create table pre_worker_questionnaire
(
	id int(11) unsigned null,
	email VARCHAR(255) null,
	ans1 VARCHAR(11) null,
	ans2 VARCHAR(11) null,
	ans3 VARCHAR(11) null,
	del_flag tinyint default 0 null,
	create_date datetime default current_timestamp null,
	constraint pre_worker_questionnaire_pre_signup_email_fk
		foreign key (email) references pre_signup (email)
);
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
        Schema::dropIfExists('pre_worker_questionnaire');
    }
}
