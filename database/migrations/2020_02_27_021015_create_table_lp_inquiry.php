<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLpInquiry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
DROP TABLE IF EXISTS `lp_inquiry`;
CREATE TABLE `lp_inquiry` (
  `inquiry_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entry_service_id` int(11) DEFAULT NULL,
  `name1` varchar(255) NOT NULL DEFAULT '',
  `name2` varchar(255) NOT NULL DEFAULT '',
  `birth_y` varchar(4) NOT NULL DEFAULT '',
  `birth_m` varchar(2) NOT NULL DEFAULT '',
  `birth_d` varchar(2) NOT NULL DEFAULT '',
  `sex` varchar(2) NOT NULL DEFAULT '',
  `tel` varchar(16) NOT NULL DEFAULT '',
  `mail` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(8) NOT NULL DEFAULT '',
  `address1` varchar(255) NOT NULL DEFAULT '',
  `address2` varchar(255) NOT NULL DEFAULT '',
  `address3` varchar(255) NOT NULL DEFAULT '',
  `skill` varchar(255) DEFAULT NULL,
  `doc1` varchar(255) DEFAULT NULL,
  `doc2` varchar(255) DEFAULT NULL,
  `education1` varchar(8) DEFAULT NULL,
  `education_y` varchar(4) DEFAULT NULL,
  `education_name` varchar(255) DEFAULT NULL,
  `education_txt` text,
  `lang_jp` varchar(8) DEFAULT NULL,
  `lang_en` varchar(8) DEFAULT NULL,
  `toeic` int(11) DEFAULT NULL,
  `lang_other` varchar(255) DEFAULT NULL,
  `capacity` text,
  `company_name` varchar(255) DEFAULT NULL,
  `company_y_a` varchar(4) DEFAULT NULL,
  `company_m_a` varchar(2) DEFAULT NULL,
  `company_y_b` varchar(4) DEFAULT NULL,
  `company_m_b` varchar(2) DEFAULT NULL,
  `company_type` varchar(8) DEFAULT NULL,
  `company_text` text,
  `other` text,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`inquiry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;          
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
        Schema::dropIfExists('table_lp_inquiry');
    }
}
