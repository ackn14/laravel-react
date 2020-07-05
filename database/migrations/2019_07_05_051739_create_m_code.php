<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_code', function (Blueprint $table) {

            $sql = "
            CREATE TABLE `m_code` (
             `category` VARCHAR(255) NOT NULL,
             `code` VARCHAR(255) NOT NULL,
             `display_order` INT(8) NOT NULL,
             `display_name` VARCHAR(255) NOT NULL,
             `col_1` VARCHAR(255),
             `col_2` VARCHAR(255),
             `col_3` VARCHAR(255),
             `col_4` VARCHAR(255),
             `col_5` VARCHAR(255),
            PRIMARY KEY (`category`, `code`));
            
            ALTER TABLE `m_code` 
            ADD INDEX `col_1_m_code_referenced_idx` (`col_1` ASC);
              
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('item','10001','1','新着求人　延長なし','新着求人　延長なし','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('item','10002','2','通常求人 延長なし','通常求人 延長なし','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('item','10003','3','初回新着求人 延長あり','初回新着求人 延長あり','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('item','10004','4','4週間ごとの新着求人　延長あり','4週間ごとの新着求人　延長あり','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('item','10005','5','通常求人　延長あり','通常求人　延長あり','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('item','10006','6','非公開求人　延長なし','非公開求人　延長なし','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('item','10007','7','非公開求人　延長あり','非公開求人　延長あり','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('commitment','1','1','職種未経験歓迎','職種未経験歓迎','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('commitment','2','2','業種未経験歓迎','業種未経験歓迎','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('commitment','3','3','上場企業','上場企業','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('commitment','4','4','外資系企業','外資系企業','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','1','1','欠員補充の為','欠員補充の為','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','2','2','部門・体制強化の為','部門・体制強化の為','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','3','3','新規募集の為','新規募集の為','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','4','4','業績好調による増員の為','業績好調による増員の為','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','5','5','将来の幹部候補採用の為','将来の幹部候補採用の為','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','6','6','年齢構成比の修復の為','年齢構成比の修復の為','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','7','7','新規事業の立ち上げの為','新規事業の立ち上げの為','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','8','8','事業の建て直しの為','事業の建て直しの為','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','9','9','海外展開の為','海外展開の為','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('background','10','10','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('contract_type','01','1','正社員','正社員','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('contract_type','02','2','契約社員','契約社員','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('contract_type','11','3','紹介予定派遣','紹介予定派遣','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('contract_type','13','4','役員','役員','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('contract_type','1000','5','派遣','派遣','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('contract_type','1001','6','業務委託','業務委託','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('contract_type','1002','7','リモートワーク','リモートワーク','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','01','1','0万円','0万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','02','2','150万円','150万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','03','3','200万円','200万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','04','4','250万円','250万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','05','5','300万円','300万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','06','6','350万円','350万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','07','7','400万円','400万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','08','8','450万円','450万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','09','9','500万円','500万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','10','10','550万円','550万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','11','11','600万円','600万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','12','12','650万円','650万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','13','13','700万円','700万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','14','14','800万円','800万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','15','15','900万円','900万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','16','16','1000万円','1000万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','17','17','1100万円','1100万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','18','18','1200万円','1200万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','19','19','1300万円','1300万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','20','20','1400万円','1400万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_min','21','21','1500万円','1500万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','01','1','150万円','150万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','02','2','200万円','200万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','03','3','250万円','250万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','04','4','300万円','300万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','05','5','350万円','350万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','06','6','400万円','400万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','07','7','450万円','450万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','08','8','500万円','500万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','09','9','550万円','550万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','10','10','600万円','600万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','11','11','650万円','650万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','12','12','700万円','700万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','13','13','800万円','800万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','14','14','900万円','900万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','15','15','1000万円','1000万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','16','16','1100万円','1100万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','17','17','1200万円','1200万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','18','18','1300万円','1300万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','19','19','1400万円','1400万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('annual_income_max','20','20','1500万円','1500万円','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','0','1','0社','0社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','1','2','～1社','～1社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','2','3','～2社','～2社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','3','4','～3社','～3社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','4','5','～4社','～4社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','5','6','～5社','～5社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','6','7','～6社','～6社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','7','8','～7社','～7社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','8','9','～8社','～8社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','9','10','～9社','～9社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','10','11','～10社','～10社','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('ex_company','99','12','11社以上','11社以上','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_management','010','1','マネジメント経験なし','マネジメント経験なし','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_management','020','2','マネジメント9人以下','マネジメント9人以下','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_management','030','3','マネジメント10人以上','マネジメント10人以上','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_management','040','4','マネジメント20人以上','マネジメント20人以上','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_management','050','5','マネジメント50人以上','マネジメント50人以上','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_english','02010201','1','【初級】日常会話ができる','【初級】日常会話ができる','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_english','02010202','2','【準中級】ビジネス上の電話応対に支障がない','【準中級】ビジネス上の電話応対に支障がない','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_english','02010203','3','【中級】ビジネス上の会話に支障がない','【中級】ビジネス上の会話に支障がない','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_english','02010204','4','【準上級】プレゼン・議論が流暢に行える','【準上級】プレゼン・議論が流暢に行える','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('skill_english','02010205','5','【上級】ネイティブレベルの会話ができる','【上級】ネイティブレベルの会話ができる','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('education','001','2','大学院（修士）','大学院（修士）','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('education','002','1','大学','大学','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('education','003','4','短期大学','短期大学','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('education','004','5','高等専門学校','高等専門学校','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('education','005','6','専門学校','専門学校','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('education','006','7','高等学校','高等学校','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('education','007','8','中学校','中学校','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('education','008','9','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('education','009','3','大学院（博士）','大学院（博士）','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01010','1','ソフトウェア・情報処理','ソフトウェア・情報処理','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01020','2','インターネット関連','インターネット関連','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01040','3','ゲーム関連','ゲーム関連','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01030','4','通信関連','通信関連','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02110','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02100','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02340','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02010','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02020','5','コンピューター機器','コンピューター機器','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02030','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02050','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02060','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02070','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02080','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02090','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02040','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02120','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02330','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02140','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02160','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02150','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02320','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02310','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02280','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02170','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02180','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02200','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02210','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02380','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02420','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02360','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02250','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02350','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02370','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02290','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02400','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02410','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05010','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05100','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05190','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05140','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05250','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05030','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05040','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05020','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05270','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05150','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05130','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05120','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05110','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03050','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03010','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02390','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03130','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03140','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03040','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03060','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03070','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03080','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03100','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03110','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03120','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03150','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03160','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05280','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03170','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03090','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05050','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05060','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05070','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05080','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05090','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01050','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01060','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','06010','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02190','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','06020','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04140','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04130','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04110','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04030','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04010','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04020','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04040','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04060','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04050','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04055','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04150','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04160','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04090','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04080','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04070','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04120','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04100','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05160','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05170','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','08010','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02270','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02300','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02260','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02230','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','09010','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05180','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05240','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03020','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02240','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02130','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05200','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05210','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05220','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05260','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03030','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05230','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02220','99999999999','その他','その他','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('age_limit_reason','01','1','若年層の長期キャリア形成を図るため','若年層の長期キャリア形成を図るため','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('age_limit_reason','02','2','特定職種の特定年齢層に限定して募集するため','特定職種の特定年齢層に限定して募集するため','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('age_limit_reason','03','3','芸術・芸能の分野における表現の真実性のため','芸術・芸能の分野における表現の真実性のため','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('age_limit_reason','04','4','労働基準法などの規定により年齢制限が設けられているため','労働基準法などの規定により年齢制限が設けられているため','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('age_limit_reason','05','5','60歳以上の高年齢者などの雇用促進のため','60歳以上の高年齢者などの雇用促進のため','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('age_limit_reason','06','6','定年年齢を上限として募集するため','定年年齢を上限として募集するため','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('\bposition','1','1','指定なし','指定なし','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('\bposition','2','2','経営者・役員クラス','経営者・役員クラス','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('\bposition','3','3','本部長・事業部長クラス','本部長・事業部長クラス','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('\bposition','4','4','部長クラス','部長クラス','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('\bposition','5','5','課長クラス','課長クラス','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('\bposition','6','6','主任クラス','主任クラス','','','','');
            INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('\bposition','7','7','その他','その他','','','','');
                           
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
