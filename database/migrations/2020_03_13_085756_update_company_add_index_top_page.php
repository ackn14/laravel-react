<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompanyAddIndexTopPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `company` 
            ADD INDEX `del_release_create_idx`(`del_flag`, `release_flag`, `create_date`),
            ADD INDEX `pre_bt_del_release_idx`(`prefecture_id`, `business_type`, `del_flag`, `release_flag`);
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `company` 
            DROP INDEX `del_release_create_idx`,
            DROP INDEX `pre_bt_del_release_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
