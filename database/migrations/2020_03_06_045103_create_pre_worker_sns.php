<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreWorkerSns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
create table pre_worker_sns
(
	id int(11) unsigned auto_increment,
	email varchar(255) not null,
	sns_id varchar(11) not null,
	follow_account varchar(255) null,
	follow_user_num int null,
	follower_account varchar(255) null,
	follower_user_num int null,
	del_flag tinyint default 0 null,
	create_date datetime default CURRENT_TIMESTAMP null,
	constraint pre_worker_sns_pk
		primary key (id),
	constraint pre_worker_sns_pre_signup_email_fk
		foreign key (email) references pre_signup (email)
) ENGINE=InnoDB AUTO_INCREMENT=1;




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
        Schema::dropIfExists('pre_worker_sns');
    }
}
