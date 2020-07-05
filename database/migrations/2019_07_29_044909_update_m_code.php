<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMCode extends Migration
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

          DELETE FROM `m_code` 
          WHERE `category` = 'business_type'; 
          
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01010','1','ソフトウェア・情報処理','ソフトウェア・情報処理','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01020','2','インターネット関連','インターネット関連','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01040','3','ゲーム関連','ゲーム関連','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01030','4','通信関連','通信関連','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02110','5','輸送用機器（自動車含む）','輸送用機器（自動車含む）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02100','6','重電・産業用電気機器','重電・産業用電気機器','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02340','7','プラント・エンジニアリング','プラント・エンジニアリング','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02010','8','総合電機','総合電機','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02020','9','コンピューター機器','コンピューター機器','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02030','10','家電・AV機器','家電・AV機器','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02050','11','ゲーム・アミューズメント製品','ゲーム・アミューズメント製品','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02060','12','精密機器','精密機器','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02070','13','通信機器','通信機器','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02080','14','半導体・電子・電気機器','半導体・電子・電気機器','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02090','15','医療用機器・医療関連','医療用機器・医療関連','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02040','16','その他電気・電子関連','その他電気・電子関連','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02120','17','鉱業・金属製品・鉄鋼','鉱業・金属製品・鉄鋼','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02330','18','非鉄金属','非鉄金属','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02140','19','ガラス・化学・石油','ガラス・化学・石油','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02160','20','紙・パルプ','紙・パルプ','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02150','21','繊維','繊維','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02320','22','窯業・セラミック','窯業・セラミック','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02310','23','ゴム','ゴム','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02280','24','セメント','セメント','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02170','25','住宅・建材・エクステリア','住宅・建材・エクステリア','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02180','26','インテリア・住宅関連','インテリア・住宅関連','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02200','27','食品','食品','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02210','28','化粧品・医薬品','化粧品・医薬品','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02380','29','日用品・雑貨','日用品・雑貨','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02420','30','玩具','玩具','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02360','31','繊維・アパレル','繊維・アパレル','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02250','32','スポーツ・レジャー用品（メーカー）','スポーツ・レジャー用品（メーカー）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02350','33','文具・事務機器関連','文具・事務機器関連','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02370','34','宝飾品・貴金属','宝飾品・貴金属','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02290','35','その他メーカー','その他メーカー','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02400','36','総合商社','総合商社','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02410','37','専門商社','専門商社','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05010','38','人材派遣・人材紹介','人材派遣・人材紹介','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05100','39','アウトソーシング','アウトソーシング','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05190','40','教育','教育','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05140','41','医療・福祉・介護サービス','医療・福祉・介護サービス','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05250','42','冠婚葬祭','冠婚葬祭','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05030','43','セキュリティ','セキュリティ','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05040','44','ビル管理・メンテナンス','ビル管理・メンテナンス','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05020','45','エステティック・美容・理容','エステティック・美容・理容','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05270','46','フィットネスクラブ','フィットネスクラブ','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05150','47','サービス（その他）','サービス（その他）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05130','48','レジャーサービス・アミューズメント','レジャーサービス・アミューズメント','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05120','49','ホテル・旅館','ホテル・旅館','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05110','50','旅行・観光','旅行・観光','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03050','51','百貨店','百貨店','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03010','52','流通・チェーンストア','流通・チェーンストア','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02390','53','通信販売・ネット販売','通信販売・ネット販売','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03130','54','コンビニエンスストア','コンビニエンスストア','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03140','55','ドラッグストア・調剤薬局','ドラッグストア・調剤薬局','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03040','56','ホームセンター','ホームセンター','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03060','57','専門店（総合）','専門店（総合）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03070','58','専門店（食品関連）','専門店（食品関連）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03080','59','専門店（自動車関連）','専門店（自動車関連）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03100','60','専門店（カメラ・OA関連）','専門店（カメラ・OA関連）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03110','61','専門店（電気機器関連）','専門店（電気機器関連）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03120','62','専門店（書籍・音楽関連）','専門店（書籍・音楽関連）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03150','63','専門店（メガネ・貴金属）','専門店（メガネ・貴金属）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03160','64','専門店（ファッション・服飾関連）','専門店（ファッション・服飾関連）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05280','65','専門店（スポーツ用品）','専門店（スポーツ用品）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03170','66','専門店（インテリア関連）','専門店（インテリア関連）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03090','67','専門店（その他小売）','専門店（その他小売）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05050','68','フードビジネス（総合）','フードビジネス（総合）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05060','69','フードビジネス（洋食）','フードビジネス（洋食）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05070','70','フードビジネス（ファストフード）','フードビジネス（ファストフード）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05080','71','フードビジネス（アジア系）','フードビジネス（アジア系）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05090','72','フードビジネス（和食）','フードビジネス（和食）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01050','73','放送・映像・音響','放送・映像・音響','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','01060','74','新聞・出版・印刷','新聞・出版・印刷','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','06010','75','広告','広告','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02190','76','ディスプレイ・空間デザイン・イベント','ディスプレイ・空間デザイン・イベント','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','06020','77','アート・芸能関連','アート・芸能関連','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04140','78','金融総合グループ','金融総合グループ','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04130','79','外資系金融','外資系金融','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04110','80','政府系・系統金融機関','政府系・系統金融機関','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04030','81','銀行','銀行','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04010','82','外資系銀行','外資系銀行','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04020','83','信用組合・信用金庫・労働金庫','信用組合・信用金庫・労働金庫','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04040','84','信託銀行','信託銀行','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04060','85','投資信託委託・投資顧問','投資信託委託・投資顧問','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04050','86','証券・投資銀行','証券・投資銀行','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04055','87','商品取引','商品取引','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04150','88','ベンチャーキャピタル','ベンチャーキャピタル','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04160','89','事業者金融・消費者金融','事業者金融・消費者金融','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04090','90','クレジット・信販','クレジット・信販','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04080','91','リース・レンタル','リース・レンタル','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04070','92','生命保険・損害保険','生命保険・損害保険','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04120','93','共済','共済','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','04100','94','その他金融','その他金融','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05160','95','シンクタンク・マーケティング・調査','シンクタンク・マーケティング・調査','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05170','96','専門コンサルタント','専門コンサルタント','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','08010','97','個人事務所（士業）','個人事務所（士業）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02270','98','建設コンサルタント','建設コンサルタント','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02300','99','建設・土木','建設・土木','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02260','100','設計','設計','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02230','101','設備工事','設備工事','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','09010','102','リフォーム・内装工事','リフォーム・内装工事','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05180','103','不動産','不動産','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05240','104','海運・鉄道・空輸・陸運','海運・鉄道・空輸・陸運','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03020','105','物流・倉庫','物流・倉庫','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02240','106','環境・リサイクル','環境・リサイクル','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02130','107','環境関連設備','環境関連設備','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05200','108','電力・ガス・エネルギー','電力・ガス・エネルギー','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05210','109','警察・消防・自衛隊','警察・消防・自衛隊','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05220','110','官公庁','官公庁','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05260','111','公益・特殊・独立行政法人','公益・特殊・独立行政法人','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','03030','112','生活協同組合','生活協同組合','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','05230','113','農業協同組合（JA金融機関含む）','農業協同組合（JA金融機関含む）','','','','');
          INSERT INTO `m_code` (`category`, `code`, `display_order`, `display_name`, `col_1`, `col_2`, `col_3`, `col_4`, `col_5`) VALUES ('business_type','02220','114','農林・水産','農林・水産','','','','');

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
