<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMPrefecture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_prefecture', function (Blueprint $table) {

            $sql = "
            CREATE TABLE `m_prefecture` (
             `prefecture_id` VARCHAR(11) NOT NULL,
             `region_id` VARCHAR(11) NOT NULL,
             `prefecture_name` VARCHAR(255) NOT NULL,
             `display_order` INT(8) NOT NULL,
            PRIMARY KEY (prefecture_id));
            
            ALTER TABLE `m_prefecture` 
            ADD INDEX `region_id_m_prefecture_referenced_idx` (`region_id` ASC);
          
            ALTER TABLE `m_prefecture` 
            ADD CONSTRAINT `region_id_m_prefecture_referenced`
              FOREIGN KEY (`region_id`)
              REFERENCES `m_region` (`region_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION;
              
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('00','0','未選択','1');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('02','2','青森県','3');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('03','2','岩手県','4');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('04','2','宮城県','5');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('05','2','秋田県','6');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('06','2','山形県','7');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('07','2','福島県','8');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('08','3','茨城県','9');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('09','3','栃木県','10');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('01','1','北海道','2');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('10','3','群馬県','11');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('11','3','埼玉県','12');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('12','3','千葉県','13');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('13','3','東京都','14');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('14','3','神奈川県','15');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('15','4','新潟県','16');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('16','4','富山県','17');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('17','4','石川県','18');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('18','4','福井県','19');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('19','4','山梨県','20');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('20','4','長野県','21');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('21','4','岐阜県','22');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('22','4','静岡県','23');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('23','4','愛知県','24');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('24','5','三重県','25');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('25','5','滋賀県','26');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('26','5','京都府','27');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('27','5','大阪府','28');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('28','5','兵庫県','29');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('29','5','奈良県','30');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('30','5','和歌山県','31');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('31','6','鳥取県','32');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('32','6','島根県','33');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('33','6','岡山県','34');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('34','6','広島県','35');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('35','6','山口県','36');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('36','7','徳島県','37');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('37','7','香川県','38');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('38','7','愛媛県','39');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('39','7','高知県','40');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('40','8','福岡県','41');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('41','8','佐賀県','42');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('42','8','長崎県','43');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('43','8','熊本県','44');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('44','8','大分県','45');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('45','8','宮崎県','46');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('46','8','鹿児島県','47');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('47','8','沖縄県','48');
              INSERT INTO `m_prefecture` (`prefecture_id`, `region_id`, `prefecture_name`, `display_order`) VALUES ('48','9','海外','49');
              
              
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
