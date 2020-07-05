<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectAddMediaProjectIdDelMynaviColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = 'alter table project modify media_id varchar(50) null comment \'外部メディアID\';

alter table project modify media_company_id varchar(50) null comment \'外部メディア固有企業ID\';

alter table project
	add media_project_id varchar(50) default NULL null comment \'外部メディア固有案件ID\' after media_company_id;

alter table project modify media_url varchar(255) null comment \'外部メディア案件ページURL\';

alter table project drop column project_management_no;

drop index project_mynavi_company_id_project_referenced_idx on project;

create index project_mynavi_company_id_project_referenced_idx
	on project (project_mynavi_company_id);

alter table project drop foreign key project_mynavi_company_id_project_referenced;

alter table project drop column project_mynavi_company_id;

alter table project
	add constraint project_mynavi_company_id_project_referenced
		foreign key (project_mynavi_company_id) references company (company_id);

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
