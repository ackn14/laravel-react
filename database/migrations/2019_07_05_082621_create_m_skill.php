<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMSkill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_skill', function (Blueprint $table) {

            $sql = "
          CREATE TABLE `m_skill` (
            `skill_id` VARCHAR(11) NOT NULL,
            `skill_category_id` VARCHAR(11),
            `skill_name` VARCHAR(255) NOT NULL,
            `display_order` INT(8) NOT NULL,
            PRIMARY KEY (`skill_id`));
           
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('1','.NetFramework','','1');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('2','3dsMax','','2');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('3','3Dアニメーション制作','','3');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('4','3Dモデル制作','','4');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('5','ABAP','','5');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('6','Access','','6');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('7','ActionScript','','7');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('8','AfterEffect','','8');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('9','Amazon S3','','9');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('10','Amazon Web Service','','10');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('11','Android','','11');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('12','Android Java','','12');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('13','AngularJS','','13');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('14','Apache','','14');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('15','Apex','','15');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('16','ASP.NET','','16');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('17','Backbone.js','','17');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('18','C/C++','','18');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('19','C#/C#.net','','19');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('20','CAD','','20');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('21','CakePHP','','21');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('22','Catalyst','','22');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('23','COBOL','','23');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('24','Cocos2d','','24');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('25','Cocos2d-x','','25');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('26','CoffeeScript','','26');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('27','CreateJS','','27');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('28','CSS','','28');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('29','Delphi','','29');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('30','Docker','','30');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('31','DTP制作','','31');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('32','Flash','','32');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('33','FuelPHP','','33');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('34','Git','','34');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('35','Go','','35');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('36','GoogleAnalytics','','36');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('37','Hadoop','','37');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('38','HTML/XHTML','','38');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('39','HTML5/CSS3','','39');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('40','Illustrator','','40');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('41','iOS','','41');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('42','Java','','42');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('43','JavaScript','','43');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('44','Jenkins','','44');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('45','JIRA','','45');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('46','Jmeter','','46');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('47','jQuery','','47');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('48','JSP','','48');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('49','kotlin','','49');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('50','Kubernetes','','50');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('51','Laravel','','51');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('52','LESS','','52');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('53','Linux','','53');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('54','Mac','','54');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('55','Maya','','55');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('56','Microsoft Azure','','56');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('57','MotionBuilder','','57');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('58','MySQL','','58');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('59','Netbeans','','59');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('60','Node.js','','60');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('61','Objective-C','','61');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('62','OpenShift','','62');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('63','Oracle','','63');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('64','Oracle WebLogic Server','','64');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('65','Padrino','','65');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('66','PCサイトデザイン','','66');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('67','PCセットアップ','','67');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('68','Perl','','68');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('69','Photoshop','','69');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('70','PHP','','70');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('71','PHPUnit','','71');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('72','PL/SQL','','72');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('73','PostgreSQL','','73');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('74','Python','','74');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('75','R','','75');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('76','Rails','','76');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('77','React','','77');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('78','ReactNative','','78');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('79','Red Hat','','79');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('80','Redis','','80');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('81','Redmine','','81');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('82','Redshift','','82');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('83','Ruby','','83');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('84','Sales','','84');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('85','Salesforce CRM','','85');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('86','SAP WAS','','86');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('87','Sass','','87');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('88','Scala','','88');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('89','Seasar2','','89');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('90','Semantic UI','','90');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('91','SEO設計/運用','','91');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('92','SharePoint','','92');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('93','Shell','','93');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('94','Sketch','','94');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('95','Spring','','95');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('96','SQL','','96');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('97','SQL Server','','97');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('98','Subversion','','98');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('99','Swift','','99');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('100','Symfony','','100');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('101','Tomcat','','101');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('102','TypeScript','','102');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('103','UI/UX設計','','103');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('104','Unity','','104');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('105','UNIX','','105');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('106','VB/VB.net','','106');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('107','VBA','','107');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('108','VC++','','108');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('109','Vmware','','109');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('110','Vue.js','','110');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('111','Webディレクション','','111');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('112','Windows','','112');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('113','WindowsServer','','113');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('114','WordPress','','114');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('115','Zend Framework','','115');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('116','アートディレクション','','116');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('117','アクセス解析','','117');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('118','イラスト制作','','118');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('119','インフラ構築','','119');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('120','ゲームディレクション','','120');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('121','ゲームプランニング','','121');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('122','スマートフォンアプリデザイン','','122');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('123','スマートフォンサイトデザイン','','123');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('124','その他','','124');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('125','データ分析','','125');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('126','バナー・ＬＰ制作','','126');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('127','プロジェクトマネジメント','','127');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('128','メインフレーム','','128');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('129','ライティング','','129');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('130','リスティング設計/運用','','130');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('131','校正・編集','','131');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('132','機械学習','','132');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('133','翻訳・通訳','','133');
           INSERT INTO `m_skill` (`skill_id`, `skill_name`, `skill_category_id`, `display_order`) VALUES ('134','開発ディレクション','','134');
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
