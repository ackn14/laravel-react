<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTalkStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = 'create table business_talk_status
(
	business_talk_status_id int unsigned auto_increment
		primary key,
	project_id int unsigned not null,
	worker_id int unsigned not null,
	phase varchar(4) null,
	accuracy int unsigned null,
	money int unsigned null,
	proposal_date date null comment \'提案日\',
	completion_date date null comment \'完了予定日\',
	create_date datetime default CURRENT_TIMESTAMP not null,
	update_date datetime default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
	del_flag tinyint default 0 null,
	constraint business_talk_status_project_project_id_fk
		foreign key (project_id) references project (project_id),
	constraint business_talk_status_worker_worker_id_fk
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
        Schema::dropIfExists('business_talk_status');
    }
}
