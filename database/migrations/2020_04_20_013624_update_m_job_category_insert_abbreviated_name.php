<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class UpdateMJobCategoryInsertAbbreviatedName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
      Schema::table('m_job_category', function (Blueprint $table) {
        if(Schema::hasColumn('m_job_category', 'abbreviated_name')) {
          $table->dropColumn('abbreviated_name');
        }
        $table->string('abbreviated_name', 255)->default(NULL)->after('job_category_name');
      });
      
      DB::table('m_job_category')->where('job_category_id', 100)->update(['abbreviated_name' => 'PG/SE']);
      DB::table('m_job_category')->where('job_category_id', 110)->update(['abbreviated_name' => 'PR']);
      DB::table('m_job_category')->where('job_category_id', 120)->update(['abbreviated_name' => 'De']);
      DB::table('m_job_category')->where('job_category_id', 200)->update(['abbreviated_name' => 'PM/PL']);
      DB::table('m_job_category')->where('job_category_id', 300)->update(['abbreviated_name' => 'CO']);
      DB::table('m_job_category')->where('job_category_id', 400)->update(['abbreviated_name' => 'DR']);
      DB::table('m_job_category')->where('job_category_id', 500)->update(['abbreviated_name' => 'MKT']);
      DB::table('m_job_category')->where('job_category_id', 600)->update(['abbreviated_name' => 'Office']);
      DB::table('m_job_category')->where('job_category_id', 700)->update(['abbreviated_name' => 'OM']);
      DB::table('m_job_category')->where('job_category_id', 800)->update(['abbreviated_name' => 'OPP']);
      DB::table('m_job_category')->where('job_category_id', 900)->update(['abbreviated_name' => 'PL']);
      DB::table('m_job_category')->where('job_category_id', 999)->update(['abbreviated_name' => 'Other']);
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
