<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMAnotherFeatureTableColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // m_another_featureの外部キー制約テーブルフィールド削除
        Schema::table('worker_desired_another_feature', function (Blueprint $table) {
            $sql = "
            TRUNCATE TABLE worker_desired_another_feature;
            ";
            DB::connection()->getPdo()->exec($sql);
        });

        Schema::table('project_feature', function (Blueprint $table) {
            $sql = "
            TRUNCATE TABLE project_feature;
            ";
            DB::connection()->getPdo()->exec($sql);
        });

        // m_another_featureデータ削除
        Schema::table('m_another_feature', function (Blueprint $table) {
            $sql = "
            DELETE FROM m_another_feature;
            ";
            DB::connection()->getPdo()->exec($sql);
        });

        // データ更新
        Schema::table('m_another_feature', function (Blueprint $table) {
            $sql = "
            INSERT INTO `m_another_feature` (`another_feature_id`, `another_feature_name`, `display_order`)
            VALUES ('101','即日可能','1'),
            ('102','長期','2'),
            ('103','フルタイム','3'),
            ('104','時短勤務制度あり','4'),
            ('105','フレックスあり','5'),
            ('106','リモートワーク可','6'),
            ('107','残業少なめ','7'),
            ('108','副業OK','8'),
            ('109','勉強会が多い','9'),
            ('110','社内勉強会あり','10'),
            ('111','書籍購入の補助','11'),
            ('112','端末購入の補助','12'),
            ('113','パソコンが選べる','13'),
            ('114','食堂あり','14'),
            ('115','スポット','15'),
            ('116','未経験歓迎','16'),
            ('117','住宅補助あり','17'),
            ('118','海外勤務可能','18'),
            ('119','大手企業','19');
            ";
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
        //
    }
}




