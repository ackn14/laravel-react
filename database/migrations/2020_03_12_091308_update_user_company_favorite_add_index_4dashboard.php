<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserCompanyFavoriteAddIndex4dashboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_company_favorite', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `user_company_favorite` 
            DROP INDEX `id_type_update_idx`,
            ADD INDEX `id_type_update_idx`(`user_company_id`, `target_type`, `update_date`);
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
        Schema::table('user_company_favorite', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `user_company_favorite`
            DROP INDEX `id_type_update_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
