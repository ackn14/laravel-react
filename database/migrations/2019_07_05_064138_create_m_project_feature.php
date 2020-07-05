<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMProjectFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_project_feature', function (Blueprint $table) {

            $sql = "

          CREATE TABLE `m_project_feature` (
          `project_feature_id` VARCHAR(11) NOT NULL,
          `project_feature_name` VARCHAR(255) NOT NULL,
          `display_order` INT(8) NOT NULL,
          PRIMARY KEY (`project_feature_id`));
          
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('11','3年以上連続成長企業','1');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('12','平均残業月30時間以内','2');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('13','中途入社5割以上','3');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('14','女性社員5割以上','4');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('15','20代の管理職登用実績あり','5');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('16','女性管理職登用実績あり','6');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('17','障がい者積極採用','7');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('18','第二新卒歓迎','8');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('19','U・Iターン歓迎','9');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('21','転勤無し','10');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('22','海外勤務有','11');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('23','英語を使う仕事','12');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('24','中国語を使う仕事','13');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('25','その他の言語を使う仕事','14');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('31','完全週休二日制','15');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('32','年間休日120日以上','16');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('33','交通費全額支給','17');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('34','育児支援制度あり','18');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('35','介護支援制度あり','19');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('36','社宅・家賃補助制度','20');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('37','資格取得支援制度','21');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('38','マイカー通勤可','22');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('39','フレックス勤務','23');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('71','女性のおしごと','24');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1000','ベンチャー企業','25');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1001','外資系企業','26');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1002','上場企業','27');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1003','グローバル展開','28');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1004','研修・勉強会充実','29');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1005','副業OK','30');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1006','書籍代補助','31');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1007','イヤホンOK','32');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1008','インセンティブあり','33');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1009','外国籍OK','34');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1010','新技術に積極的','35');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1011','20代が活躍','36');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1012','服装自由','37');
          INSERT INTO `m_project_feature` (`project_feature_id`, `project_feature_name`, `display_order`) VALUES ('1013','裁量労働制あり','38');

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
