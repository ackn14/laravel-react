<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReinsertMJobCategoryAndMJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = '
        UPDATE project SET job_id = NULL;
      ';
      DB::connection()->getPdo()->exec($sql);
      $sql = '
        DELETE FROM worker_desired_job;
      ';
      DB::connection()->getPdo()->exec($sql);
      $sql = '
        DELETE FROM m_job;
      ';
      DB::connection()->getPdo()->exec($sql);
      $sql = '
        DELETE FROM m_job_category;
      ';
      DB::connection()->getPdo()->exec($sql);

      $sql = "
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('100','PG・SE','1');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('200','PM・PL','2');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('300','コンサル','3');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('400','ディレクター','4');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('500','マーケティング','5');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('600','事務','6');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('700','事業責任者','7');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('800','オープンポジション','8');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('900','プランナー','9');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('110','プロデューサー','10');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('120','デザイナー','11');
INSERT INTO `m_job_category` (`job_category_id`, `job_category_name`, `display_order`) VALUES ('999','その他','12');
        
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100001','100','ゲームエンジンプログラマー','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100002','100','ゲームプログラマー','20');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100003','100','ネットワークエンジニア','30');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100004','100','インフラエンジニア','40');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100005','100','フロントエンドエンジニア','50');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100006','100','アプリケーションエンジニア','60');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100007','100','ブリッジSE','70');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100008','100','サーバーエンジニア','80');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100009','100','セキュリティエンジニア','90');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100010','100','データベースエンジニア','100');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100011','100','テストエンジニア','110');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100012','100','組み込み・制御エンジニア','120');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100013','100','セールスエンジニア','130');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100014','100','QAエンジニア','140');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100015','100','社内SE','150');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100016','100','マークアップエンジニア','160');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100017','100','サーバーサイドエンジニア','170');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('100018','100','プログラマー','180');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('200001','200','プロジェクトマネージャー(PM)','140');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('200002','200','プロジェクトリーダー(PL)','150');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('300001','300','ITコンサルタント','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('300002','300','SAPコンサルタント','20');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('300003','300','ITアーキテクト','30');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('400001','400','Webディレクター','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('400002','400','アートディレクター','20');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('500001','500','データサイエンティスト','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('500002','500','マーケティング','20');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('600001','600','テクニカルサポート','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('600002','600','ヘルプデスク','20');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('700001','700','CTO候補','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('700002','700','幹部候補','20');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('800001','800','オープンポジション','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('900001','900','ゲームプランナー','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('110001','110','Webプロデューサー','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('120001','120','UI・UXデザイナー','10');
INSERT INTO `m_job` (`job_id`, `job_category_id`, `job_name`, `display_order`) VALUES ('999999','999','その他','900');
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
