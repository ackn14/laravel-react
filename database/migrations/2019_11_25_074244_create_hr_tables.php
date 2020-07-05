<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
      
--
-- テーブルの構造 `hr_applicant`
--

DROP TABLE IF EXISTS `hr_applicant`;
CREATE TABLE `hr_applicant` (
  `applicant_id` int(11) UNSIGNED NOT NULL,
  `platform_id` int(11) UNSIGNED DEFAULT NULL,
  `apply_date` date DEFAULT NULL,
  `share_to_id` int(11) DEFAULT NULL,
  `apply_medium_id` int(11) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name_ruby` varchar(255) DEFAULT NULL,
  `first_name_ruby` varchar(255) DEFAULT NULL,
  `initial_name` varchar(10) DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL COMMENT '0:男性 1:女性',
  `age` tinyint(4) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `prefecture_id` varchar(11) DEFAULT NULL,
  `city_id` varchar(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `nearest_station` varchar(255) DEFAULT NULL,
  `nationality` tinyint(4) DEFAULT NULL COMMENT '0:未選択 1:日本籍 3:外国籍',
  `logo_image` varchar(255) DEFAULT NULL,
  `movie` varchar(255) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `other_resume` varchar(255) DEFAULT NULL,
  `portfolio` varchar(255) DEFAULT NULL,
  `educational_background` varchar(255) DEFAULT NULL,
  `educational_background_detail` varchar(255) DEFAULT NULL,
  `graduate_date` date DEFAULT NULL,
  `release_flag` tinyint(4) DEFAULT '0' COMMENT '0:非公開\n1:公開',
  `del_flag` tinyint(4) DEFAULT '0' COMMENT '0:未削除\n1:削除済',
  `last_update_user_id` int(11) UNSIGNED DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- テーブルの構造 `hr_applicant_question`
--

DROP TABLE IF EXISTS `hr_applicant_question`;
CREATE TABLE `hr_applicant_question` (
  `applicant_id` int(11) UNSIGNED NOT NULL,
  `motivation` text NOT NULL,
  `objective_short` varchar(255) DEFAULT NULL,
  `objective_medium` varchar(255) DEFAULT NULL,
  `objective_long` varchar(255) DEFAULT NULL,
  `self_introduction_sp` varchar(255) DEFAULT NULL,
  `self_introduction_wp` varchar(255) DEFAULT NULL,
  `seeking` text,
  `eyesight` text,
  `join_period` varchar(255) DEFAULT NULL,
  `operation_date` date DEFAULT NULL,
  `ses_propriety` tinyint(1) NOT NULL,
  `skill_language` text,
  `study_style` text,
  `study_time` text,
  `desired_contract_type` varchar(11) NOT NULL DEFAULT '',
  `job_category_id` int(11) UNSIGNED NOT NULL,
  `desired_annual_salary` int(11) UNSIGNED DEFAULT NULL,
  `desired_work_time` tinyint(4) UNSIGNED DEFAULT NULL,
  `desired_work_day` tinyint(4) UNSIGNED DEFAULT NULL,
  `desired_etc` text,
  `last_update_user_id` int(11) UNSIGNED DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- テーブルの構造 `hr_selection_result`
--

DROP TABLE IF EXISTS `hr_selection_result`;
CREATE TABLE `hr_selection_result` (
  `applicant_id` int(11) UNSIGNED NOT NULL,
  `selection_status_id` int(11) NOT NULL,
  `user_company_id` int(11) DEFAULT NULL,
  `selection_type_id` int(11) DEFAULT NULL,
  `interview_date` datetime DEFAULT NULL COMMENT '面接日',
  `other_selection` text,
  `assessment` tinyint(4) DEFAULT NULL,
  `comment` text,
  `first_impression` tinyint(4) DEFAULT NULL,
  `comprehension` tinyint(4) DEFAULT NULL,
  `earnest` tinyint(4) DEFAULT NULL,
  `aggressive` tinyint(4) DEFAULT NULL,
  `cooperation` tinyint(4) DEFAULT NULL,
  `fixing` tinyint(4) DEFAULT NULL,
  `communication` tinyint(4) DEFAULT NULL,
  `del_flag` tinyint(1) UNSIGNED DEFAULT '0',
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- テーブルの構造 `hr_worker_history`
--

DROP TABLE IF EXISTS `hr_worker_history`;
CREATE TABLE `hr_worker_history` (
  `applicant_id` int(11) UNSIGNED NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `employment_status` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `work_content` varchar(255) DEFAULT NULL,
  `retirement_reason` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `last_update_user_id` int(11) UNSIGNED DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- テーブルの構造 `m_platform`
--

DROP TABLE IF EXISTS `m_platform`;
CREATE TABLE `m_platform` (
  `platform_id` int(11) UNSIGNED NOT NULL,
  `platform_name` varchar(255) NOT NULL DEFAULT '',
  `ip_adress` varchar(5) NOT NULL DEFAULT '',
  `display_order` int(11) UNSIGNED NOT NULL,
  `del_flag` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- テーブルの構造 `m_recording_site`
--

DROP TABLE IF EXISTS `m_recording_site`;
CREATE TABLE `m_recording_site` (
  `recording_site_id` int(11) NOT NULL,
  `recording_site_name` varchar(32) NOT NULL,
  `url` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL,
  `del_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `hr_applicant`
--
ALTER TABLE `hr_applicant`
  ADD PRIMARY KEY (`applicant_id`),
  ADD KEY `last_update_user_id` (`last_update_user_id`),
  ADD KEY `platform_id` (`platform_id`);

--
-- テーブルのインデックス `hr_applicant_question`
--
ALTER TABLE `hr_applicant_question`
  ADD PRIMARY KEY (`applicant_id`),
  ADD KEY `last_update_user_id` (`last_update_user_id`);

--
-- テーブルのインデックス `hr_selection_result`
--
ALTER TABLE `hr_selection_result`
  ADD PRIMARY KEY (`applicant_id`,`selection_status_id`);

--
-- テーブルのインデックス `hr_worker_history`
--
ALTER TABLE `hr_worker_history`
  ADD PRIMARY KEY (`applicant_id`),
  ADD KEY `last_update_user_id` (`last_update_user_id`);

--
-- テーブルのインデックス `m_platform`
--
ALTER TABLE `m_platform`
  ADD PRIMARY KEY (`platform_id`),
  ADD UNIQUE KEY `platform_name` (`platform_name`);

--
-- テーブルのインデックス `m_recording_site`
--
ALTER TABLE `m_recording_site`
  ADD PRIMARY KEY (`recording_site_id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `hr_applicant`
--
ALTER TABLE `hr_applicant`
  MODIFY `applicant_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `m_platform`
--
ALTER TABLE `m_platform`
  MODIFY `platform_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `m_recording_site`
--
ALTER TABLE `m_recording_site`
  MODIFY `recording_site_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `hr_applicant`
--
ALTER TABLE `hr_applicant`
  ADD CONSTRAINT `hr_applicant_ibfk_1` FOREIGN KEY (`last_update_user_id`) REFERENCES `user_company` (`user_company_id`),
  ADD CONSTRAINT `hr_applicant_ibfk_2` FOREIGN KEY (`platform_id`) REFERENCES `m_platform` (`platform_id`);

--
-- テーブルの制約 `hr_applicant_question`
--
ALTER TABLE `hr_applicant_question`
  ADD CONSTRAINT `hr_applicant_question_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `hr_applicant` (`applicant_id`),
  ADD CONSTRAINT `hr_applicant_question_ibfk_2` FOREIGN KEY (`last_update_user_id`) REFERENCES `user_company` (`user_company_id`);

--
-- テーブルの制約 `hr_selection_result`
--
ALTER TABLE `hr_selection_result`
  ADD CONSTRAINT `hr_selection_result_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `hr_applicant` (`applicant_id`);

--
-- テーブルの制約 `hr_worker_history`
--
ALTER TABLE `hr_worker_history`
  ADD CONSTRAINT `hr_worker_history_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `hr_applicant` (`applicant_id`),
  ADD CONSTRAINT `hr_worker_history_ibfk_2` FOREIGN KEY (`last_update_user_id`) REFERENCES `user_company` (`user_company_id`);
COMMIT;

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
