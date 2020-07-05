<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreWorkerSkill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
        create table pre_worker_skill
        (
          id int unsigned auto_increment	primary key,
          email varchar(255) not null,
          skill_id varchar(11) not null,
          experience_id varchar(11) null,
          del_flag tinyint default 0 null,
          create_date datetime default CURRENT_TIMESTAMP null,
          update_date datetime default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP,
          constraint email
            unique (email, skill_id),
	        constraint pre_worker_skill_sns_pre_signup_email_fk
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
        Schema::dropIfExists('pre_worker_skill');
    }
}
