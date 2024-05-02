/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 10.4.24-MariaDB : Database - myappsec
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`myappsec` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `myappsec`;

/*Table structure for table `analysis` */

DROP TABLE IF EXISTS `analysis`;

CREATE TABLE `analysis` (
  `analysis_id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) DEFAULT NULL,
  `jira_id` varchar(255) DEFAULT NULL,
  `category` enum('Security jira','Functional jira') DEFAULT NULL,
  `jira_type` enum('epic','story','Bug','TI') DEFAULT NULL,
  `SonarQube` enum('Pass','Fail') DEFAULT NULL,
  `Contrast` enum('Pass','Fail') DEFAULT NULL,
  `Dep_Check` enum('Pass','Fail') DEFAULT NULL,
  `Manual_Secure_Code_Review` enum('Pass','Fail') DEFAULT NULL,
  `Manual_Security_Testing` enum('Pass','Fail') DEFAULT NULL,
  `Remark` varchar(255) DEFAULT NULL,
  `delete_flag` int(11) DEFAULT 0,
  `created_by` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`analysis_id`),
  KEY `assignment_id` (`assignment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `analysis` */

insert  into `analysis`(`analysis_id`,`assignment_id`,`jira_id`,`category`,`jira_type`,`SonarQube`,`Contrast`,`Dep_Check`,`Manual_Secure_Code_Review`,`Manual_Security_Testing`,`Remark`,`delete_flag`,`created_by`,`timestamp`) values 
(1,4,'56','Functional jira','story','Pass','Pass','Pass','Pass','Pass','ty',NULL,'2','2024-04-27 21:37:24'),
(2,10,'56565','Security jira','epic','Pass','Pass','Pass','Pass','Pass','565',1,'2','2024-04-29 07:55:49'),
(3,10,'56566','Security jira','epic','Pass','Pass','Pass','Pass','Pass','5656',1,'2','2024-04-29 07:55:45'),
(4,10,'rtrtrt','Security jira','epic','Pass','Pass','Pass','Pass','Pass','tyt',0,'2','2024-04-29 07:57:22'),
(5,10,'67567','Functional jira','epic','Pass','Pass','Pass','Pass','Fail','67567',0,'2','2024-04-29 07:58:17'),
(6,10,'ioioio','Security jira','epic','Pass','Pass','Pass','Pass','Pass','oiio',0,'2','2024-04-29 08:00:23');

/*Table structure for table `assignments` */

DROP TABLE IF EXISTS `assignments`;

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `rm_pm` varchar(255) DEFAULT NULL,
  `assigned_date` date DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT 0,
  `created_by` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`assignment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `assignments` */

insert  into `assignments`(`assignment_id`,`title`,`description`,`assigned_to`,`product_name`,`rm_pm`,`assigned_date`,`delete_flag`,`created_by`,`timestamp`) values 
(3,'assignment','assignment','2','CMR','Ron','2024-04-27',1,'pm','2024-04-27 17:52:17'),
(4,'new assignment','new assignment','2','CMR','dan7','2024-04-27',0,'pm','2024-04-27 17:53:09'),
(5,'assingment 5','assingment 5','2','CMR','jack2','2024-04-27',0,'pm','2024-04-27 17:59:16'),
(6,'new assignment','new assignment','2','CMR','jack','2024-04-27',0,'pm','2024-04-27 18:01:14'),
(7,'hello','hello','2','CMR','hello','2024-04-27',0,'pm','2024-04-27 19:26:46'),
(8,'56577','5756756776','2','CMR','dino','2024-04-28',0,'pm','2024-04-28 10:37:33'),
(9,'tytyy','tyty','2','DMR','ty','2024-04-28',0,'pm','2024-04-28 10:49:27'),
(10,'yuy','jhjjgj','2','CMR','dan','2024-04-28',0,'pm','2024-04-28 10:54:58'),
(11,'ttttt','tttt','2','CMR','ttt','2024-05-01',0,'pm','2024-05-01 03:16:12'),
(12,'rrtg','gdfgdf','2','DMR','fgdgd','2024-05-01',0,'pm','2024-05-01 20:52:36'),
(13,'fggd','gfdg','2','CMR','dfgdg','2024-05-01',0,'pm','2024-05-01 20:55:10'),
(14,'fdgdg','dfgdg','2','CMR','fg','2024-05-01',0,'pm','2024-05-01 20:55:18'),
(15,'jhgj','jhgjg','2','CMR','hjgj','2024-05-01',0,'pm','2024-05-01 21:08:03');

/*Table structure for table `assignments_vapt` */

DROP TABLE IF EXISTS `assignments_vapt`;

CREATE TABLE `assignments_vapt` (
  `assignment_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `rm_pm` varchar(255) DEFAULT NULL,
  `assigned_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flag` tinyint(1) DEFAULT 0,
  `created_by` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`assignment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `assignments_vapt` */

insert  into `assignments_vapt`(`assignment_id`,`title`,`description`,`assigned_to`,`product_name`,`rm_pm`,`assigned_date`,`delete_flag`,`created_by`,`timestamp`) values 
(15,'vapt1','vapt1','2','CMR','jack','2024-04-23 00:00:00',0,'admin','2024-04-23 05:38:29'),
(17,'tim','tim','2','CMR','tim','2024-04-23 00:00:00',0,'admin','2024-04-23 05:46:45'),
(19,'trimm','trimm','2','CMR','trimm','2024-04-23 00:00:00',0,'admin','2024-04-23 05:50:54');

/*Table structure for table `certification` */

DROP TABLE IF EXISTS `certification`;

CREATE TABLE `certification` (
  `certification_id` int(11) NOT NULL AUTO_INCREMENT,
  `certification_status` varchar(50) DEFAULT 'Approved',
  `delete_flag` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`certification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `certification` */

insert  into `certification`(`certification_id`,`certification_status`,`delete_flag`) values 
(1,'Approved',0),
(2,'Approved with Exception',0),
(3,'Rejected',0),
(4,'OnHold',0);

/*Table structure for table `file_access` */

DROP TABLE IF EXISTS `file_access`;

CREATE TABLE `file_access` (
  `file_access_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `in_menu` tinyint(1) DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`file_access_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4;

/*Data for the table `file_access` */

insert  into `file_access`(`file_access_id`,`file_name`,`role_id`,`display_name`,`in_menu`,`delete_flag`,`timestamp`,`created_by`,`order_by`) values 
(17,'addanalysis.php',1,NULL,NULL,0,'2024-04-22 10:27:30',NULL,NULL),
(18,'addanalysis.php',2,NULL,NULL,0,'2024-04-22 10:27:33',NULL,NULL),
(19,'addanalysis.php',3,NULL,NULL,0,'2024-04-22 10:27:35',NULL,NULL),
(20,'addanalysis.php',4,NULL,NULL,0,'2024-04-22 10:27:36',NULL,NULL),
(21,'addanalysis.php',5,NULL,NULL,0,'2024-04-22 10:27:40',NULL,NULL),
(22,'addanalysis.php',6,NULL,NULL,0,'2024-04-22 10:27:47',NULL,NULL),
(23,'addanalysis.php',7,NULL,NULL,0,'2024-04-22 10:28:08',NULL,NULL),
(24,'addpatchdetails.php',1,NULL,NULL,0,'2024-04-22 10:28:21',NULL,NULL),
(25,'addpatchdetails.php',2,NULL,NULL,0,'2024-04-22 10:28:26',NULL,NULL),
(26,'addpatchdetails.php',3,NULL,NULL,0,'2024-04-22 10:28:27',NULL,NULL),
(27,'addpatchdetails.php',4,NULL,NULL,0,'2024-04-22 10:28:29',NULL,NULL),
(28,'addpatchdetails.php',5,NULL,NULL,0,'2024-04-22 10:28:30',NULL,NULL),
(29,'addpatchdetails.php',6,NULL,NULL,0,'2024-04-22 10:28:40',NULL,NULL),
(30,'addpatchdetails.php',7,NULL,NULL,0,'2024-04-22 10:28:43',NULL,NULL),
(31,'assignments.php',1,'Create',0,0,'2024-04-22 10:29:34',NULL,NULL),
(32,'assignments.php',2,NULL,NULL,0,'2024-04-22 10:29:36',NULL,NULL),
(33,'assignments.php',3,NULL,NULL,0,'2024-04-22 10:29:38',NULL,NULL),
(34,'assignments.php',4,NULL,NULL,0,'2024-04-22 10:29:39',NULL,NULL),
(36,'assignments.php',6,NULL,NULL,0,'2024-04-22 10:29:43',NULL,NULL),
(37,'assignments.php',7,'Create Assignment',0,0,'2024-04-22 10:29:44',NULL,2),
(38,'dashboard.php',1,'Dashboard',0,0,'2024-04-22 10:29:46',NULL,NULL),
(39,'dashboard.php',2,'Dashboard',0,0,'2024-04-22 10:29:48',NULL,NULL),
(40,'dashboard.php',3,'Dashboard',0,0,'2024-04-22 10:29:50',NULL,NULL),
(41,'dashboard.php',4,'Dashboard',0,0,'2024-04-22 10:29:52',NULL,NULL),
(42,'dashboard.php',5,'Dashboard',0,0,'2024-04-22 10:29:53',NULL,1),
(43,'dashboard.php',6,'Dashboard',0,0,'2024-04-22 10:29:55',NULL,NULL),
(44,'dashboard.php',7,'Dashboard',0,0,'2024-04-22 10:30:55',NULL,1),
(45,'leadapproval.php',3,NULL,NULL,0,'2024-04-22 10:31:37',NULL,NULL),
(46,'leftmenu.php',1,NULL,NULL,0,'2024-04-22 10:31:52',NULL,NULL),
(47,'leftmenu.php',2,NULL,NULL,0,'2024-04-22 10:31:55',NULL,NULL),
(48,'leftmenu.php',3,NULL,NULL,0,'2024-04-22 10:31:58',NULL,NULL),
(49,'leftmenu.php',4,NULL,NULL,0,'2024-04-22 10:31:59',NULL,NULL),
(50,'leftmenu.php',5,NULL,NULL,0,'2024-04-22 10:32:02',NULL,NULL),
(51,'leftmenu.php',6,NULL,NULL,0,'2024-04-22 10:32:04',NULL,NULL),
(52,'leftmenu.php',7,NULL,NULL,0,'2024-04-22 10:32:15',NULL,NULL),
(53,'logout.php',1,NULL,NULL,0,'2024-04-22 10:32:27',NULL,NULL),
(54,'logout.php',2,NULL,NULL,0,'2024-04-22 10:32:28',NULL,NULL),
(55,'logout.php',3,NULL,NULL,0,'2024-04-22 10:32:30',NULL,NULL),
(56,'logout.php',4,NULL,NULL,0,'2024-04-22 10:32:32',NULL,NULL),
(57,'logout.php',5,'Logout',0,0,'2024-04-22 10:32:34',NULL,4),
(58,'logout.php',6,NULL,NULL,0,'2024-04-22 10:32:35',NULL,NULL),
(59,'logout.php',7,'Logout',0,0,'2024-04-22 10:32:37',NULL,5),
(60,'mentorreview.php',4,NULL,NULL,0,'2024-04-22 10:32:38',NULL,NULL),
(61,'printpreview.php',5,NULL,NULL,0,'2024-04-22 10:33:26',NULL,NULL),
(62,'profile.php',1,NULL,NULL,0,'2024-04-22 10:33:36',NULL,NULL),
(63,'profile.php',2,NULL,NULL,0,'2024-04-22 10:33:37',NULL,NULL),
(64,'profile.php',3,NULL,NULL,0,'2024-04-22 10:33:39',NULL,NULL),
(65,'profile.php',4,NULL,NULL,0,'2024-04-22 10:33:43',NULL,NULL),
(66,'profile.php',5,'Profile',0,0,'2024-04-22 10:33:46',NULL,3),
(67,'profile.php',6,NULL,NULL,0,'2024-04-22 10:33:48',NULL,NULL),
(68,'profile.php',7,'Profile',0,0,'2024-04-22 10:33:58',NULL,4),
(69,'view_assignments.php',3,'View All Patches',0,0,'2024-04-22 10:34:11',NULL,NULL),
(70,'view_assignments.php',4,'View All Patches',0,0,'2024-04-22 10:34:13',NULL,NULL),
(71,'view_assignments_analyst.php',5,'View Assignment',0,0,'2024-04-22 10:34:34',NULL,2),
(72,'view_assignments_lead.php',3,'Patches for Approval',0,0,'2024-04-22 10:34:54',NULL,NULL),
(73,'view_assignments_mentor.php',4,'Patches for Review',0,0,'2024-04-22 10:34:57',NULL,NULL),
(74,'view_assignments.php',7,'View Assignment',0,0,'2024-04-22 10:35:00',NULL,3),
(75,'assignments_vapt.php',1,'Create VAPT',0,0,'2024-04-23 09:07:58',NULL,NULL);

/*Table structure for table `meeting_notes` */

DROP TABLE IF EXISTS `meeting_notes`;

CREATE TABLE `meeting_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `meeting_notes` */

/*Table structure for table `otg_info_001` */

DROP TABLE IF EXISTS `otg_info_001`;

CREATE TABLE `otg_info_001` (
  `OTG_INFO_001_id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` varchar(10) DEFAULT NULL,
  `test_case` text DEFAULT NULL,
  `manual_testing` enum('Not Started','InProgress','Completed','OnHold','Not Applicable') DEFAULT NULL,
  `code_review` enum('Not Started','InProgress','Completed','OnHold','Not Applicable') DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flag` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`OTG_INFO_001_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `otg_info_001` */

insert  into `otg_info_001`(`OTG_INFO_001_id`,`assignment_id`,`test_case`,`manual_testing`,`code_review`,`notes`,`updated_by`,`timestamp`,`delete_flag`) values 
(1,'11','OTG_INFO_001',NULL,NULL,NULL,NULL,'2024-04-23 09:40:15',0);

/*Table structure for table `patches` */

DROP TABLE IF EXISTS `patches`;

CREATE TABLE `patches` (
  `patches_id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `security_validation_status` varchar(255) DEFAULT NULL,
  `third_party_verified` varchar(255) DEFAULT NULL,
  `contrast_verified` varchar(255) DEFAULT NULL,
  `sonar_verified` varchar(255) DEFAULT NULL,
  `secure_code_review` varchar(255) DEFAULT NULL,
  `conclusion` varchar(255) DEFAULT NULL,
  `qa_env_url` varchar(255) DEFAULT NULL,
  `contrast_server_name` varchar(255) DEFAULT NULL,
  `qa_servers` varchar(255) DEFAULT NULL,
  `tech_imp_count` varchar(255) DEFAULT NULL,
  `bug_count` varchar(255) DEFAULT NULL,
  `story_count` varchar(255) DEFAULT NULL,
  `epic_count` varchar(255) DEFAULT NULL,
  `summary_url` varchar(255) DEFAULT 'Summary',
  `rm_pm` varchar(255) DEFAULT NULL,
  `assigned_date` date DEFAULT NULL,
  `eta` date DEFAULT NULL,
  `security_jira` int(11) DEFAULT NULL,
  `functional_jira` int(11) DEFAULT NULL,
  `koc_date` date DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `emanager_ir` varchar(255) DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  `sql_injection` enum('NA','Found','Not Found') DEFAULT NULL,
  `xss` enum('NA','Found','Not Found') DEFAULT NULL,
  `path_traversal` enum('NA','Found','Not Found') DEFAULT NULL,
  `command_injection` enum('NA','Found','Not Found') DEFAULT NULL,
  `xxe` enum('NA','Found','Not Found') DEFAULT NULL,
  `readline` enum('NA','Found','Not Found') DEFAULT NULL,
  `header_injection` enum('NA','Found','Not Found') DEFAULT NULL,
  `insecure_deserial` enum('NA','Found','Not Found') DEFAULT NULL,
  `session_test` enum('NA','Found','Not Found') DEFAULT NULL,
  `out_of_band` enum('NA','Found','Not Found') DEFAULT NULL,
  `sensitive_info_querystring` enum('NA','Found','Not Found') DEFAULT NULL,
  `vul_crypto_algo` enum('NA','Found','Not Found') DEFAULT NULL,
  `sensitive_info_logs` enum('NA','Found','Not Found') DEFAULT NULL,
  `tbv` enum('NA','Found','Not Found') DEFAULT NULL,
  `sensitive_info_response` enum('NA','Found','Not Found') DEFAULT NULL,
  `hardcoded_cred` enum('NA','Found','Not Found') DEFAULT NULL,
  `csv_injection` enum('NA','Found','Not Found') DEFAULT NULL,
  `unrestricted_fileupload` enum('NA','Found','Not Found') DEFAULT NULL,
  `unnecessary_file_distribution` enum('NA','Found','Not Found') DEFAULT NULL,
  `ssrf` enum('NA','Found','Not Found') DEFAULT NULL,
  `vul_components` enum('NA','Found','Not Found') DEFAULT NULL,
  `root_detection` enum('NA','Found','Not Found') DEFAULT NULL,
  `improper_error_handling` enum('NA','Found','Not Found') DEFAULT NULL,
  `reverse_tabnabbing` enum('NA','Found','Not Found') DEFAULT NULL,
  `weak_access_control` enum('NA','Found','Not Found') DEFAULT NULL,
  `weak_random_number` enum('NA','Found','Not Found') DEFAULT NULL,
  `sessionless_js` enum('NA','Found','Not Found') DEFAULT NULL,
  `removal_jcryption_files` enum('NA','Found','Not Found') DEFAULT NULL,
  `log_injection` enum('NA','Found','Not Found') DEFAULT NULL,
  `no_of_jiras_tested` int(11) DEFAULT NULL,
  `changelog_reviewers` varchar(255) DEFAULT NULL,
  `total_time_taken` time DEFAULT NULL,
  `mentor_feedback` varchar(500) DEFAULT NULL,
  `lead_feedback` varchar(500) DEFAULT NULL,
  `mentor_username` varchar(255) DEFAULT NULL,
  `lead_username` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Not Started',
  `aging` int(11) GENERATED ALWAYS AS (to_days(curdate()) - to_days(`assigned_date`)) VIRTUAL,
  `total_jira` int(11) GENERATED ALWAYS AS (`security_jira` + `functional_jira`) VIRTUAL,
  `total_no_of_jiras` int(11) GENERATED ALWAYS AS (`security_jira` + `functional_jira`) VIRTUAL,
  `certification_status` varchar(50) DEFAULT '',
  `status_mentor` varchar(50) DEFAULT NULL,
  `status_lead` varchar(50) DEFAULT NULL,
  `review_status` varchar(50) DEFAULT 'Not Started',
  `certification_status_imp` varchar(50) DEFAULT 'Not Started',
  PRIMARY KEY (`patches_id`),
  UNIQUE KEY `unique_assignment_id` (`assignment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `patches` */

insert  into `patches`(`patches_id`,`assignment_id`,`title`,`description`,`assigned_to`,`product_name`,`comments`,`security_validation_status`,`third_party_verified`,`contrast_verified`,`sonar_verified`,`secure_code_review`,`conclusion`,`qa_env_url`,`contrast_server_name`,`qa_servers`,`tech_imp_count`,`bug_count`,`story_count`,`epic_count`,`summary_url`,`rm_pm`,`assigned_date`,`eta`,`security_jira`,`functional_jira`,`koc_date`,`notes`,`comment`,`emanager_ir`,`delete_flag`,`timestamp`,`updated_by`,`sql_injection`,`xss`,`path_traversal`,`command_injection`,`xxe`,`readline`,`header_injection`,`insecure_deserial`,`session_test`,`out_of_band`,`sensitive_info_querystring`,`vul_crypto_algo`,`sensitive_info_logs`,`tbv`,`sensitive_info_response`,`hardcoded_cred`,`csv_injection`,`unrestricted_fileupload`,`unnecessary_file_distribution`,`ssrf`,`vul_components`,`root_detection`,`improper_error_handling`,`reverse_tabnabbing`,`weak_access_control`,`weak_random_number`,`sessionless_js`,`removal_jcryption_files`,`log_injection`,`no_of_jiras_tested`,`changelog_reviewers`,`total_time_taken`,`mentor_feedback`,`lead_feedback`,`mentor_username`,`lead_username`,`status`,`certification_status`,`status_mentor`,`status_lead`,`review_status`,`certification_status_imp`) values 
(5,3,'assignment','assignment','2','CMR','','NA','NA','NA','NA','NA','','','','','67','67','67','10','Summary',NULL,'2024-04-27','2024-04-29',0,0,NULL,'','','',1,'2024-04-27 21:22:17',NULL,'NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA',0,'','00:00:00','','','3','4','InProgress','Completed',NULL,NULL,'Not Started','Not Started'),
(7,4,'new assignment1','new assignment','2','CMR','','NA','NA','NA','NA','NA','','','','','','','','10','Summary','dan7','2024-04-27','2024-04-30',0,0,NULL,'','','',1,'2024-04-27 21:23:09',NULL,'NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA',0,'','00:00:00','','','3','4','Not Started','Approved',NULL,NULL,'Not Started','Not Started'),
(9,5,NULL,NULL,NULL,NULL,'','NA','NA','NA','NA','NA','','','','','','','','','Summary','jack2',NULL,NULL,0,0,NULL,'','','',0,'2024-04-27 21:29:16',NULL,'','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA',0,'','00:00:00','','','3','4','InProgress','Approved',NULL,NULL,'Not Started','Not Started'),
(10,6,NULL,NULL,NULL,NULL,'','NA','NA','NA','NA','NA','','','','','','','','','Summary','jack',NULL,'2024-04-28',0,0,NULL,'','','',0,'2024-04-27 21:31:14',NULL,'NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA',0,'','00:00:00','','','3','4','Not Started','Approved',NULL,NULL,'Not Started','Not Started'),
(11,7,'hello188','hello','2',NULL,'','NA','NA','NA','NA','NA','24','','','','','','','','Summary','hello777',NULL,'2024-04-28',0,0,'2024-04-29','','','',0,'2024-04-27 22:56:46',NULL,'NA','NA','NA','Not Found','Not Found','Not Found','Not Found','Not Found','Not Found','Not Found','Not Found','Found','Not Found','Not Found','Not Found','Not Found','Not Found','Not Found','Not Found','Not Found','Not Found','Not Found','Not Found','Found','Found','Found','Found','Found','Found',0,'','00:00:00','','',NULL,NULL,'Lead Approval Pending','Approved','Passed with Exception','Approved with Exception','Not Started','Not Started'),
(12,8,'56577','5756756776','2',NULL,'','NA','NA','NA','NA','NA','','','','','','','','','Summary','dino',NULL,'2024-04-28',0,0,'0000-00-00','','','',0,'2024-04-28 14:07:33',NULL,'Found','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA',0,'','00:00:00','','',NULL,NULL,'Lead Approval Pending','Approved','Passed with Exception',NULL,'Not Started','Not Started'),
(13,9,'tytyy','tyty','2','DMR','','NA','NA','NA','NA','NA','','','','','','','','','Summary','ty','2024-04-28','0000-00-00',0,0,'0000-00-00','','','',0,'2024-04-28 14:19:27',NULL,'NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA',0,'','00:00:00','','',NULL,NULL,'Lead Approval Pending','Approved','Passed','Approved','Not Started','Not Started'),
(14,10,'yuy','jhjjgj','2','CMR','','NA','NA','NA','NA','NA','7','','','7','','','7','7','Summary','dan','2024-04-28','2024-04-30',7,0,'2024-04-29','7','7','7',0,'2024-04-28 14:24:58',NULL,'NA','Found','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA',0,'','00:00:00','','',NULL,NULL,'Lead Approval Pending','Approved with Exception','Passed','','Passed','Not Started'),
(15,11,'ttttt','tttt','2','CMR','','NA','NA','NA','NA','NA','','','','','','','','','Summary','ttt','2024-05-01','0000-00-00',0,0,'0000-00-00','','','',0,'2024-05-01 06:46:12',NULL,'NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA','NA',0,'','00:00:00','','',NULL,NULL,'Lead Approval Completed','Approved with Exception','','','Passed with Exception','Not Started'),
(16,12,'rrtg','gdfgdf','2','DMR',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Summary','fgdgd','2024-05-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2024-05-02 00:22:36',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Lead Approval Completed','Approved with Exception',NULL,NULL,'Not Started','Not Started'),
(17,13,'fggd','gfdg','2','CMR',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Summary','dfgdg','2024-05-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2024-05-02 00:25:10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Lead Approval Completed','Approved with Exception',NULL,NULL,'Passed','Not Started'),
(18,14,'fdgdg','dfgdg','2','CMR',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Summary','fg','2024-05-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2024-05-02 00:25:18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Lead Approval Pending','Approved with Exception',NULL,NULL,'Passed with Exception','Not Started'),
(19,15,'jhgj','jhgjg','2','CMR',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Summary','hjgj','2024-05-01',NULL,NULL,NULL,NULL,NULL,NULL,'67',0,'2024-05-02 00:38:03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Lead Approval Pending','Approved',NULL,NULL,'Passed','Not Started');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT 0,
  `created_by` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `products` */

insert  into `products`(`product_id`,`product_name`,`delete_flag`,`created_by`,`timestamp`) values 
(1,'CMR',0,NULL,'2024-04-20 08:24:11'),
(2,'DMR',0,NULL,'2024-04-20 08:24:15');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `delete_flag` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `roles` */

insert  into `roles`(`role_id`,`role_name`,`delete_flag`) values 
(1,'admin',0),
(2,'manager',0),
(3,'lead',0),
(4,'mentor',0),
(5,'analyst',0),
(6,'coordinator',0),
(7,'pm',0);

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `delete_flag` int(11) DEFAULT 0,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `status` */

insert  into `status`(`status_id`,`status`,`role_id`,`delete_flag`) values 
(1,'Not Started',5,0),
(2,'InProgress',5,0),
(3,'Terv Closed & IR Addressed',5,0),
(4,'Mentor Review Pending',5,0),
(5,'Mentor Reviewed Completed',4,0),
(6,'Lead Approval Pending',4,0),
(7,'Lead Approved Completed',3,0);

/*Table structure for table `summary` */

DROP TABLE IF EXISTS `summary`;

CREATE TABLE `summary` (
  `summary_id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) DEFAULT NULL,
  `epic_count` int(11) DEFAULT NULL,
  `story_count` int(11) DEFAULT NULL,
  `bug_count` int(11) DEFAULT NULL,
  `tech_imp_count` int(11) DEFAULT NULL,
  `qa_servers` varchar(255) DEFAULT NULL,
  `contrast_server_name` varchar(255) DEFAULT NULL,
  `qa_env_url` varchar(255) DEFAULT NULL,
  `conclusion` varchar(255) DEFAULT NULL,
  `secure_code_review` enum('NA','Done','Not Done') DEFAULT 'NA',
  `sonar_verified` enum('NA','Done','Not Done') DEFAULT 'NA',
  `contrast_verified` enum('NA','Done','Not Done') DEFAULT 'NA',
  `third_party_verified` enum('NA','Done','Not Done') DEFAULT 'NA',
  `security_validation_status` enum('Approved','Approved with Exception','Rejected') DEFAULT 'Approved',
  `comments` varchar(255) DEFAULT NULL,
  `deleteflag` enum('0','1') DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`summary_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

/*Data for the table `summary` */

insert  into `summary`(`summary_id`,`assignment_id`,`epic_count`,`story_count`,`bug_count`,`tech_imp_count`,`qa_servers`,`contrast_server_name`,`qa_env_url`,`conclusion`,`secure_code_review`,`sonar_verified`,`contrast_verified`,`third_party_verified`,`security_validation_status`,`comments`,`deleteflag`,`timestamp`,`created_by`) values 
(19,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NA','NA','NA','NA','Approved',NULL,'0','2024-04-27 22:56:46',NULL),
(20,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NA','NA','NA','NA','Approved',NULL,'0','2024-04-28 14:07:33',NULL),
(21,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NA','NA','NA','NA','Approved',NULL,'0','2024-04-28 14:19:27',NULL),
(22,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NA','NA','NA','NA','Approved',NULL,'0','2024-04-28 14:24:58',NULL),
(23,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NA','NA','NA','NA','Approved',NULL,'0','2024-05-01 06:46:12',NULL),
(24,12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NA','NA','NA','NA','Approved',NULL,'0','2024-05-02 00:22:36',NULL),
(25,13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NA','NA','NA','NA','Approved',NULL,'0','2024-05-02 00:25:10',NULL),
(26,14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NA','NA','NA','NA','Approved',NULL,'0','2024-05-02 00:25:18',NULL),
(27,15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'NA','NA','NA','NA','Approved',NULL,'0','2024-05-02 00:38:03',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `ufname` varchar(255) DEFAULT NULL,
  `ulname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`password_hash`,`ufname`,`ulname`,`email`,`role_id`,`delete_flag`,`timestamp`,`created_by`) values 
(1,'admin','$2y$10$PxmidOVR/JKBOXREzjCQFuhMh1z89TGEtrmBoGGnfvXvDEPylAXBq','admin','admin','admin@test.com',1,0,'2024-04-20 08:16:10',NULL),
(2,'analyst','$2y$10$/s8BOqYLjakfpe9Gg3r8keEbAmPI06tyl6OJoJsqMrTHIeXO2vDdy','Analyst','Analyst','analyst@test.com',5,0,'2024-04-21 15:57:48',NULL),
(3,'mentor','$2y$10$/s8BOqYLjakfpe9Gg3r8keEbAmPI06tyl6OJoJsqMrTHIeXO2vDdy','A','B','abhijeet@test.com',4,0,'2024-04-21 23:52:20',NULL),
(4,'lead','$2y$10$/s8BOqYLjakfpe9Gg3r8keEbAmPI06tyl6OJoJsqMrTHIeXO2vDdy','AB','BA','abhijee1t@test.com',3,0,'2024-04-21 23:53:18',NULL),
(5,'pm','$2y$10$./I0IrNQyKpuhHNYy82q4OSfTRqbmYRRUJv1oVaZbOAf6HYpDDbo.','pm','pm','pm@test.com',7,0,'2024-04-27 09:44:48',NULL);

/*Table structure for table `vapt` */

DROP TABLE IF EXISTS `vapt`;

CREATE TABLE `vapt` (
  `vapt_id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `assigned_date` date DEFAULT NULL,
  `last_updatedby` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flag` tinyint(4) DEFAULT 0,
  `Test_Case_1` varchar(255) DEFAULT NULL,
  `Test_Case_2` text DEFAULT NULL,
  `Test_Case_3` text DEFAULT NULL,
  `Test_Case_4` text DEFAULT NULL,
  `Test_Case_5` text DEFAULT NULL,
  `Test_Case_6` text DEFAULT NULL,
  `Test_Case_7` text DEFAULT NULL,
  `Test_Case_8` text DEFAULT NULL,
  `Test_Case_9` text DEFAULT NULL,
  `Test_Case_10` text DEFAULT NULL,
  `Test_Case_11` text DEFAULT NULL,
  `Test_Case_12` text DEFAULT NULL,
  `Test_Case_13` text DEFAULT NULL,
  `Test_Case_14` text DEFAULT NULL,
  `Test_Case_15` text DEFAULT NULL,
  `Test_Case_16` text DEFAULT NULL,
  `Test_Case_17` text DEFAULT NULL,
  `Test_Case_18` text DEFAULT NULL,
  `Test_Case_19` text DEFAULT NULL,
  `Test_Case_20` text DEFAULT NULL,
  `Test_Case_21` text DEFAULT NULL,
  `Test_Case_22` text DEFAULT NULL,
  `Test_Case_23` text DEFAULT NULL,
  `Test_Case_24` text DEFAULT NULL,
  `Test_Case_25` text DEFAULT NULL,
  `Test_Case_26` text DEFAULT NULL,
  `Test_Case_27` text DEFAULT NULL,
  `Test_Case_28` text DEFAULT NULL,
  `Test_Case_29` text DEFAULT NULL,
  `Test_Case_30` text DEFAULT NULL,
  `Test_Case_31` text DEFAULT NULL,
  `Test_Case_32` text DEFAULT NULL,
  `Test_Case_33` text DEFAULT NULL,
  `Test_Case_34` text DEFAULT NULL,
  `Test_Case_35` text DEFAULT NULL,
  `Test_Case_36` text DEFAULT NULL,
  `Test_Case_37` text DEFAULT NULL,
  `Test_Case_38` text DEFAULT NULL,
  `Test_Case_39` text DEFAULT NULL,
  `Test_Case_40` text DEFAULT NULL,
  `Test_Case_41` text DEFAULT NULL,
  `Test_Case_42` text DEFAULT NULL,
  `Test_Case_43` text DEFAULT NULL,
  `Test_Case_44` text DEFAULT NULL,
  `Test_Case_45` text DEFAULT NULL,
  `Test_Case_46` text DEFAULT NULL,
  `Test_Case_47` text DEFAULT NULL,
  `Test_Case_48` text DEFAULT NULL,
  `Test_Case_49` text DEFAULT NULL,
  `Test_Case_50` text DEFAULT NULL,
  `Test_Case_51` text DEFAULT NULL,
  `Test_Case_52` text DEFAULT NULL,
  `Test_Case_53` text DEFAULT NULL,
  `Test_Case_54` text DEFAULT NULL,
  `Test_Case_55` text DEFAULT NULL,
  `Test_Case_56` text DEFAULT NULL,
  `Test_Case_57` text DEFAULT NULL,
  `Test_Case_58` text DEFAULT NULL,
  `Test_Case_59` text DEFAULT NULL,
  `Test_Case_60` text DEFAULT NULL,
  `Test_Case_61` text DEFAULT NULL,
  `Test_Case_62` text DEFAULT NULL,
  `Test_Case_63` text DEFAULT NULL,
  `Test_Case_64` text DEFAULT NULL,
  `Test_Case_65` text DEFAULT NULL,
  `Test_Case_66` text DEFAULT NULL,
  `Test_Case_67` text DEFAULT NULL,
  `Test_Case_68` text DEFAULT NULL,
  `Test_Case_69` text DEFAULT NULL,
  `Test_Case_70` text DEFAULT NULL,
  `Test_Case_71` text DEFAULT NULL,
  `Test_Case_72` text DEFAULT NULL,
  `Test_Case_73` text DEFAULT NULL,
  `Test_Case_74` text DEFAULT NULL,
  `Test_Case_75` text DEFAULT NULL,
  `Test_Case_76` text DEFAULT NULL,
  `Test_Case_77` text DEFAULT NULL,
  `Test_Case_78` text DEFAULT NULL,
  `Test_Case_79` text DEFAULT NULL,
  `Test_Case_80` text DEFAULT NULL,
  `Test_Case_81` text DEFAULT NULL,
  `Test_Case_82` text DEFAULT NULL,
  `Test_Case_83` text DEFAULT NULL,
  `Test_Case_84` text DEFAULT NULL,
  `Test_Case_85` text DEFAULT NULL,
  `Test_Case_86` text DEFAULT NULL,
  `Test_Case_87` text DEFAULT NULL,
  `Test_Case_88` text DEFAULT NULL,
  `Test_Case_89` text DEFAULT NULL,
  `manual_testing_Test_Case_1` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_2` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_3` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_4` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_5` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_6` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_7` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_8` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_9` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_10` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_11` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_12` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_13` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_14` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_15` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_16` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_17` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_18` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_19` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_20` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_21` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_22` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_23` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_24` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_25` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_26` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_27` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_28` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_29` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_30` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_31` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_32` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_33` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_34` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_35` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_36` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_37` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_38` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_39` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_40` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_41` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_42` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_43` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_44` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_45` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_46` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_47` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_48` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_49` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_50` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_51` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_52` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_53` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_54` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_55` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_56` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_57` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_58` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_59` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_60` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_61` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_62` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_63` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_64` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_65` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_66` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_67` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_68` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_69` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_70` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_71` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_72` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_73` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_74` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_75` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_76` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_77` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_78` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_79` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_80` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_81` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_82` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_83` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_84` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_85` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_86` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_87` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_88` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `manual_testing_Test_Case_89` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_1` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_2` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_3` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_4` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_5` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_6` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_7` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_8` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_9` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_10` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_11` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_12` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_13` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_14` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_15` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_16` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_17` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_18` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_19` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_20` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_21` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_22` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_23` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_24` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_25` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_26` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_27` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_28` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_29` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_30` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_31` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_32` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_33` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_34` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_35` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_36` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_37` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_38` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_39` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_40` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_41` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_42` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_43` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_44` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_45` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_46` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_47` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_48` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_49` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_50` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_51` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_52` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_53` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_54` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_55` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_56` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_57` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_58` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_59` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_60` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_61` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_62` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_63` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_64` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_65` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_66` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_67` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_68` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_69` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_70` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_71` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_72` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_73` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_74` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_75` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_76` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_77` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_78` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_79` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_80` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_81` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_82` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_83` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_84` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_85` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_86` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_87` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_88` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `code_review_Test_Case_89` enum('Not Started','In Progress','OnHold','Not Applicable','Completed') DEFAULT NULL,
  `notes_Test_Case_1` text DEFAULT NULL,
  `notes_Test_Case_2` text DEFAULT NULL,
  `notes_Test_Case_3` text DEFAULT NULL,
  `notes_Test_Case_4` text DEFAULT NULL,
  `notes_Test_Case_5` text DEFAULT NULL,
  `notes_Test_Case_6` text DEFAULT NULL,
  `notes_Test_Case_7` text DEFAULT NULL,
  `notes_Test_Case_8` text DEFAULT NULL,
  `notes_Test_Case_9` text DEFAULT NULL,
  `notes_Test_Case_10` text DEFAULT NULL,
  `notes_Test_Case_11` text DEFAULT NULL,
  `notes_Test_Case_12` text DEFAULT NULL,
  `notes_Test_Case_13` text DEFAULT NULL,
  `notes_Test_Case_14` text DEFAULT NULL,
  `notes_Test_Case_15` text DEFAULT NULL,
  `notes_Test_Case_16` text DEFAULT NULL,
  `notes_Test_Case_17` text DEFAULT NULL,
  `notes_Test_Case_18` text DEFAULT NULL,
  `notes_Test_Case_19` text DEFAULT NULL,
  `notes_Test_Case_20` text DEFAULT NULL,
  `notes_Test_Case_21` text DEFAULT NULL,
  `notes_Test_Case_22` text DEFAULT NULL,
  `notes_Test_Case_23` text DEFAULT NULL,
  `notes_Test_Case_24` text DEFAULT NULL,
  `notes_Test_Case_25` text DEFAULT NULL,
  `notes_Test_Case_26` text DEFAULT NULL,
  `notes_Test_Case_27` text DEFAULT NULL,
  `notes_Test_Case_28` text DEFAULT NULL,
  `notes_Test_Case_29` text DEFAULT NULL,
  `notes_Test_Case_30` text DEFAULT NULL,
  `notes_Test_Case_31` text DEFAULT NULL,
  `notes_Test_Case_32` text DEFAULT NULL,
  `notes_Test_Case_33` text DEFAULT NULL,
  `notes_Test_Case_34` text DEFAULT NULL,
  `notes_Test_Case_35` text DEFAULT NULL,
  `notes_Test_Case_36` text DEFAULT NULL,
  `notes_Test_Case_37` text DEFAULT NULL,
  `notes_Test_Case_38` text DEFAULT NULL,
  `notes_Test_Case_39` text DEFAULT NULL,
  `notes_Test_Case_40` text DEFAULT NULL,
  `notes_Test_Case_41` text DEFAULT NULL,
  `notes_Test_Case_42` text DEFAULT NULL,
  `notes_Test_Case_43` text DEFAULT NULL,
  `notes_Test_Case_44` text DEFAULT NULL,
  `notes_Test_Case_45` text DEFAULT NULL,
  `notes_Test_Case_46` text DEFAULT NULL,
  `notes_Test_Case_47` text DEFAULT NULL,
  `notes_Test_Case_48` text DEFAULT NULL,
  `notes_Test_Case_49` text DEFAULT NULL,
  `notes_Test_Case_50` text DEFAULT NULL,
  `notes_Test_Case_51` text DEFAULT NULL,
  `notes_Test_Case_52` text DEFAULT NULL,
  `notes_Test_Case_53` text DEFAULT NULL,
  `notes_Test_Case_54` text DEFAULT NULL,
  `notes_Test_Case_55` text DEFAULT NULL,
  `notes_Test_Case_56` text DEFAULT NULL,
  `notes_Test_Case_57` text DEFAULT NULL,
  `notes_Test_Case_58` text DEFAULT NULL,
  `notes_Test_Case_59` text DEFAULT NULL,
  `notes_Test_Case_60` text DEFAULT NULL,
  `notes_Test_Case_61` text DEFAULT NULL,
  `notes_Test_Case_62` text DEFAULT NULL,
  `notes_Test_Case_63` text DEFAULT NULL,
  `notes_Test_Case_64` text DEFAULT NULL,
  `notes_Test_Case_65` text DEFAULT NULL,
  `notes_Test_Case_66` text DEFAULT NULL,
  `notes_Test_Case_67` text DEFAULT NULL,
  `notes_Test_Case_68` text DEFAULT NULL,
  `notes_Test_Case_69` text DEFAULT NULL,
  `notes_Test_Case_70` text DEFAULT NULL,
  `notes_Test_Case_71` text DEFAULT NULL,
  `notes_Test_Case_72` text DEFAULT NULL,
  `notes_Test_Case_73` text DEFAULT NULL,
  `notes_Test_Case_74` text DEFAULT NULL,
  `notes_Test_Case_75` text DEFAULT NULL,
  `notes_Test_Case_76` text DEFAULT NULL,
  `notes_Test_Case_77` text DEFAULT NULL,
  `notes_Test_Case_78` text DEFAULT NULL,
  `notes_Test_Case_79` text DEFAULT NULL,
  `notes_Test_Case_80` text DEFAULT NULL,
  `notes_Test_Case_81` text DEFAULT NULL,
  `notes_Test_Case_82` text DEFAULT NULL,
  `notes_Test_Case_83` text DEFAULT NULL,
  `notes_Test_Case_84` text DEFAULT NULL,
  `notes_Test_Case_85` text DEFAULT NULL,
  `notes_Test_Case_86` text DEFAULT NULL,
  `notes_Test_Case_87` text DEFAULT NULL,
  `notes_Test_Case_88` text DEFAULT NULL,
  `notes_Test_Case_89` text DEFAULT NULL,
  `timetaken_Test_Case_1` int(3) DEFAULT NULL,
  `timetaken_Test_Case_2` int(3) DEFAULT NULL,
  `timetaken_Test_Case_3` int(3) DEFAULT NULL,
  `timetaken_Test_Case_4` int(3) DEFAULT NULL,
  `timetaken_Test_Case_5` int(3) DEFAULT NULL,
  `timetaken_Test_Case_6` int(3) DEFAULT NULL,
  `timetaken_Test_Case_7` int(3) DEFAULT NULL,
  `timetaken_Test_Case_8` int(3) DEFAULT NULL,
  `timetaken_Test_Case_9` int(3) DEFAULT NULL,
  `timetaken_Test_Case_10` int(3) DEFAULT NULL,
  `timetaken_Test_Case_11` int(3) DEFAULT NULL,
  `timetaken_Test_Case_12` int(3) DEFAULT NULL,
  `timetaken_Test_Case_13` int(3) DEFAULT NULL,
  `timetaken_Test_Case_14` int(3) DEFAULT NULL,
  `timetaken_Test_Case_15` int(3) DEFAULT NULL,
  `timetaken_Test_Case_16` int(3) DEFAULT NULL,
  `timetaken_Test_Case_17` int(3) DEFAULT NULL,
  `timetaken_Test_Case_18` int(3) DEFAULT NULL,
  `timetaken_Test_Case_19` int(3) DEFAULT NULL,
  `timetaken_Test_Case_20` int(3) DEFAULT NULL,
  `timetaken_Test_Case_21` int(3) DEFAULT NULL,
  `timetaken_Test_Case_22` int(3) DEFAULT NULL,
  `timetaken_Test_Case_23` int(3) DEFAULT NULL,
  `timetaken_Test_Case_24` int(3) DEFAULT NULL,
  `timetaken_Test_Case_25` int(3) DEFAULT NULL,
  `timetaken_Test_Case_26` int(3) DEFAULT NULL,
  `timetaken_Test_Case_27` int(3) DEFAULT NULL,
  `timetaken_Test_Case_28` int(3) DEFAULT NULL,
  `timetaken_Test_Case_29` int(3) DEFAULT NULL,
  `timetaken_Test_Case_30` int(3) DEFAULT NULL,
  `timetaken_Test_Case_31` int(3) DEFAULT NULL,
  `timetaken_Test_Case_32` int(3) DEFAULT NULL,
  `timetaken_Test_Case_33` int(3) DEFAULT NULL,
  `timetaken_Test_Case_34` int(3) DEFAULT NULL,
  `timetaken_Test_Case_35` int(3) DEFAULT NULL,
  `timetaken_Test_Case_36` int(3) DEFAULT NULL,
  `timetaken_Test_Case_37` int(3) DEFAULT NULL,
  `timetaken_Test_Case_38` int(3) DEFAULT NULL,
  `timetaken_Test_Case_39` int(3) DEFAULT NULL,
  `timetaken_Test_Case_40` int(3) DEFAULT NULL,
  `timetaken_Test_Case_41` int(3) DEFAULT NULL,
  `timetaken_Test_Case_42` int(3) DEFAULT NULL,
  `timetaken_Test_Case_43` int(3) DEFAULT NULL,
  `timetaken_Test_Case_44` int(3) DEFAULT NULL,
  `timetaken_Test_Case_45` int(3) DEFAULT NULL,
  `timetaken_Test_Case_46` int(3) DEFAULT NULL,
  `timetaken_Test_Case_47` int(3) DEFAULT NULL,
  `timetaken_Test_Case_48` int(3) DEFAULT NULL,
  `timetaken_Test_Case_49` int(3) DEFAULT NULL,
  `timetaken_Test_Case_50` int(3) DEFAULT NULL,
  `timetaken_Test_Case_51` int(3) DEFAULT NULL,
  `timetaken_Test_Case_52` int(3) DEFAULT NULL,
  `timetaken_Test_Case_53` int(3) DEFAULT NULL,
  `timetaken_Test_Case_54` int(3) DEFAULT NULL,
  `timetaken_Test_Case_55` int(3) DEFAULT NULL,
  `timetaken_Test_Case_56` int(3) DEFAULT NULL,
  `timetaken_Test_Case_57` int(3) DEFAULT NULL,
  `timetaken_Test_Case_58` int(3) DEFAULT NULL,
  `timetaken_Test_Case_59` int(3) DEFAULT NULL,
  `timetaken_Test_Case_60` int(3) DEFAULT NULL,
  `timetaken_Test_Case_61` int(3) DEFAULT NULL,
  `timetaken_Test_Case_62` int(3) DEFAULT NULL,
  `timetaken_Test_Case_63` int(3) DEFAULT NULL,
  `timetaken_Test_Case_64` int(3) DEFAULT NULL,
  `timetaken_Test_Case_65` int(3) DEFAULT NULL,
  `timetaken_Test_Case_66` int(3) DEFAULT NULL,
  `timetaken_Test_Case_67` int(3) DEFAULT NULL,
  `timetaken_Test_Case_68` int(3) DEFAULT NULL,
  `timetaken_Test_Case_69` int(3) DEFAULT NULL,
  `timetaken_Test_Case_70` int(3) DEFAULT NULL,
  `timetaken_Test_Case_71` int(3) DEFAULT NULL,
  `timetaken_Test_Case_72` int(3) DEFAULT NULL,
  `timetaken_Test_Case_73` int(3) DEFAULT NULL,
  `timetaken_Test_Case_74` int(3) DEFAULT NULL,
  `timetaken_Test_Case_75` int(3) DEFAULT NULL,
  `timetaken_Test_Case_76` int(3) DEFAULT NULL,
  `timetaken_Test_Case_77` int(3) DEFAULT NULL,
  `timetaken_Test_Case_78` int(3) DEFAULT NULL,
  `timetaken_Test_Case_79` int(3) DEFAULT NULL,
  `timetaken_Test_Case_80` int(3) DEFAULT NULL,
  `timetaken_Test_Case_81` int(3) DEFAULT NULL,
  `timetaken_Test_Case_82` int(3) DEFAULT NULL,
  `timetaken_Test_Case_83` int(3) DEFAULT NULL,
  `timetaken_Test_Case_84` int(3) DEFAULT NULL,
  `timetaken_Test_Case_85` int(3) DEFAULT NULL,
  `timetaken_Test_Case_86` int(3) DEFAULT NULL,
  `timetaken_Test_Case_87` int(3) DEFAULT NULL,
  `timetaken_Test_Case_88` int(3) DEFAULT NULL,
  `timetaken_Test_Case_89` int(3) DEFAULT NULL,
  PRIMARY KEY (`vapt_id`),
  KEY `assignment_id` (`assignment_id`),
  CONSTRAINT `vapt_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments_vapt` (`assignment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `vapt` */

insert  into `vapt`(`vapt_id`,`assignment_id`,`title`,`description`,`assigned_to`,`product_name`,`assigned_date`,`last_updatedby`,`timestamp`,`delete_flag`,`Test_Case_1`,`Test_Case_2`,`Test_Case_3`,`Test_Case_4`,`Test_Case_5`,`Test_Case_6`,`Test_Case_7`,`Test_Case_8`,`Test_Case_9`,`Test_Case_10`,`Test_Case_11`,`Test_Case_12`,`Test_Case_13`,`Test_Case_14`,`Test_Case_15`,`Test_Case_16`,`Test_Case_17`,`Test_Case_18`,`Test_Case_19`,`Test_Case_20`,`Test_Case_21`,`Test_Case_22`,`Test_Case_23`,`Test_Case_24`,`Test_Case_25`,`Test_Case_26`,`Test_Case_27`,`Test_Case_28`,`Test_Case_29`,`Test_Case_30`,`Test_Case_31`,`Test_Case_32`,`Test_Case_33`,`Test_Case_34`,`Test_Case_35`,`Test_Case_36`,`Test_Case_37`,`Test_Case_38`,`Test_Case_39`,`Test_Case_40`,`Test_Case_41`,`Test_Case_42`,`Test_Case_43`,`Test_Case_44`,`Test_Case_45`,`Test_Case_46`,`Test_Case_47`,`Test_Case_48`,`Test_Case_49`,`Test_Case_50`,`Test_Case_51`,`Test_Case_52`,`Test_Case_53`,`Test_Case_54`,`Test_Case_55`,`Test_Case_56`,`Test_Case_57`,`Test_Case_58`,`Test_Case_59`,`Test_Case_60`,`Test_Case_61`,`Test_Case_62`,`Test_Case_63`,`Test_Case_64`,`Test_Case_65`,`Test_Case_66`,`Test_Case_67`,`Test_Case_68`,`Test_Case_69`,`Test_Case_70`,`Test_Case_71`,`Test_Case_72`,`Test_Case_73`,`Test_Case_74`,`Test_Case_75`,`Test_Case_76`,`Test_Case_77`,`Test_Case_78`,`Test_Case_79`,`Test_Case_80`,`Test_Case_81`,`Test_Case_82`,`Test_Case_83`,`Test_Case_84`,`Test_Case_85`,`Test_Case_86`,`Test_Case_87`,`Test_Case_88`,`Test_Case_89`,`manual_testing_Test_Case_1`,`manual_testing_Test_Case_2`,`manual_testing_Test_Case_3`,`manual_testing_Test_Case_4`,`manual_testing_Test_Case_5`,`manual_testing_Test_Case_6`,`manual_testing_Test_Case_7`,`manual_testing_Test_Case_8`,`manual_testing_Test_Case_9`,`manual_testing_Test_Case_10`,`manual_testing_Test_Case_11`,`manual_testing_Test_Case_12`,`manual_testing_Test_Case_13`,`manual_testing_Test_Case_14`,`manual_testing_Test_Case_15`,`manual_testing_Test_Case_16`,`manual_testing_Test_Case_17`,`manual_testing_Test_Case_18`,`manual_testing_Test_Case_19`,`manual_testing_Test_Case_20`,`manual_testing_Test_Case_21`,`manual_testing_Test_Case_22`,`manual_testing_Test_Case_23`,`manual_testing_Test_Case_24`,`manual_testing_Test_Case_25`,`manual_testing_Test_Case_26`,`manual_testing_Test_Case_27`,`manual_testing_Test_Case_28`,`manual_testing_Test_Case_29`,`manual_testing_Test_Case_30`,`manual_testing_Test_Case_31`,`manual_testing_Test_Case_32`,`manual_testing_Test_Case_33`,`manual_testing_Test_Case_34`,`manual_testing_Test_Case_35`,`manual_testing_Test_Case_36`,`manual_testing_Test_Case_37`,`manual_testing_Test_Case_38`,`manual_testing_Test_Case_39`,`manual_testing_Test_Case_40`,`manual_testing_Test_Case_41`,`manual_testing_Test_Case_42`,`manual_testing_Test_Case_43`,`manual_testing_Test_Case_44`,`manual_testing_Test_Case_45`,`manual_testing_Test_Case_46`,`manual_testing_Test_Case_47`,`manual_testing_Test_Case_48`,`manual_testing_Test_Case_49`,`manual_testing_Test_Case_50`,`manual_testing_Test_Case_51`,`manual_testing_Test_Case_52`,`manual_testing_Test_Case_53`,`manual_testing_Test_Case_54`,`manual_testing_Test_Case_55`,`manual_testing_Test_Case_56`,`manual_testing_Test_Case_57`,`manual_testing_Test_Case_58`,`manual_testing_Test_Case_59`,`manual_testing_Test_Case_60`,`manual_testing_Test_Case_61`,`manual_testing_Test_Case_62`,`manual_testing_Test_Case_63`,`manual_testing_Test_Case_64`,`manual_testing_Test_Case_65`,`manual_testing_Test_Case_66`,`manual_testing_Test_Case_67`,`manual_testing_Test_Case_68`,`manual_testing_Test_Case_69`,`manual_testing_Test_Case_70`,`manual_testing_Test_Case_71`,`manual_testing_Test_Case_72`,`manual_testing_Test_Case_73`,`manual_testing_Test_Case_74`,`manual_testing_Test_Case_75`,`manual_testing_Test_Case_76`,`manual_testing_Test_Case_77`,`manual_testing_Test_Case_78`,`manual_testing_Test_Case_79`,`manual_testing_Test_Case_80`,`manual_testing_Test_Case_81`,`manual_testing_Test_Case_82`,`manual_testing_Test_Case_83`,`manual_testing_Test_Case_84`,`manual_testing_Test_Case_85`,`manual_testing_Test_Case_86`,`manual_testing_Test_Case_87`,`manual_testing_Test_Case_88`,`manual_testing_Test_Case_89`,`code_review_Test_Case_1`,`code_review_Test_Case_2`,`code_review_Test_Case_3`,`code_review_Test_Case_4`,`code_review_Test_Case_5`,`code_review_Test_Case_6`,`code_review_Test_Case_7`,`code_review_Test_Case_8`,`code_review_Test_Case_9`,`code_review_Test_Case_10`,`code_review_Test_Case_11`,`code_review_Test_Case_12`,`code_review_Test_Case_13`,`code_review_Test_Case_14`,`code_review_Test_Case_15`,`code_review_Test_Case_16`,`code_review_Test_Case_17`,`code_review_Test_Case_18`,`code_review_Test_Case_19`,`code_review_Test_Case_20`,`code_review_Test_Case_21`,`code_review_Test_Case_22`,`code_review_Test_Case_23`,`code_review_Test_Case_24`,`code_review_Test_Case_25`,`code_review_Test_Case_26`,`code_review_Test_Case_27`,`code_review_Test_Case_28`,`code_review_Test_Case_29`,`code_review_Test_Case_30`,`code_review_Test_Case_31`,`code_review_Test_Case_32`,`code_review_Test_Case_33`,`code_review_Test_Case_34`,`code_review_Test_Case_35`,`code_review_Test_Case_36`,`code_review_Test_Case_37`,`code_review_Test_Case_38`,`code_review_Test_Case_39`,`code_review_Test_Case_40`,`code_review_Test_Case_41`,`code_review_Test_Case_42`,`code_review_Test_Case_43`,`code_review_Test_Case_44`,`code_review_Test_Case_45`,`code_review_Test_Case_46`,`code_review_Test_Case_47`,`code_review_Test_Case_48`,`code_review_Test_Case_49`,`code_review_Test_Case_50`,`code_review_Test_Case_51`,`code_review_Test_Case_52`,`code_review_Test_Case_53`,`code_review_Test_Case_54`,`code_review_Test_Case_55`,`code_review_Test_Case_56`,`code_review_Test_Case_57`,`code_review_Test_Case_58`,`code_review_Test_Case_59`,`code_review_Test_Case_60`,`code_review_Test_Case_61`,`code_review_Test_Case_62`,`code_review_Test_Case_63`,`code_review_Test_Case_64`,`code_review_Test_Case_65`,`code_review_Test_Case_66`,`code_review_Test_Case_67`,`code_review_Test_Case_68`,`code_review_Test_Case_69`,`code_review_Test_Case_70`,`code_review_Test_Case_71`,`code_review_Test_Case_72`,`code_review_Test_Case_73`,`code_review_Test_Case_74`,`code_review_Test_Case_75`,`code_review_Test_Case_76`,`code_review_Test_Case_77`,`code_review_Test_Case_78`,`code_review_Test_Case_79`,`code_review_Test_Case_80`,`code_review_Test_Case_81`,`code_review_Test_Case_82`,`code_review_Test_Case_83`,`code_review_Test_Case_84`,`code_review_Test_Case_85`,`code_review_Test_Case_86`,`code_review_Test_Case_87`,`code_review_Test_Case_88`,`code_review_Test_Case_89`,`notes_Test_Case_1`,`notes_Test_Case_2`,`notes_Test_Case_3`,`notes_Test_Case_4`,`notes_Test_Case_5`,`notes_Test_Case_6`,`notes_Test_Case_7`,`notes_Test_Case_8`,`notes_Test_Case_9`,`notes_Test_Case_10`,`notes_Test_Case_11`,`notes_Test_Case_12`,`notes_Test_Case_13`,`notes_Test_Case_14`,`notes_Test_Case_15`,`notes_Test_Case_16`,`notes_Test_Case_17`,`notes_Test_Case_18`,`notes_Test_Case_19`,`notes_Test_Case_20`,`notes_Test_Case_21`,`notes_Test_Case_22`,`notes_Test_Case_23`,`notes_Test_Case_24`,`notes_Test_Case_25`,`notes_Test_Case_26`,`notes_Test_Case_27`,`notes_Test_Case_28`,`notes_Test_Case_29`,`notes_Test_Case_30`,`notes_Test_Case_31`,`notes_Test_Case_32`,`notes_Test_Case_33`,`notes_Test_Case_34`,`notes_Test_Case_35`,`notes_Test_Case_36`,`notes_Test_Case_37`,`notes_Test_Case_38`,`notes_Test_Case_39`,`notes_Test_Case_40`,`notes_Test_Case_41`,`notes_Test_Case_42`,`notes_Test_Case_43`,`notes_Test_Case_44`,`notes_Test_Case_45`,`notes_Test_Case_46`,`notes_Test_Case_47`,`notes_Test_Case_48`,`notes_Test_Case_49`,`notes_Test_Case_50`,`notes_Test_Case_51`,`notes_Test_Case_52`,`notes_Test_Case_53`,`notes_Test_Case_54`,`notes_Test_Case_55`,`notes_Test_Case_56`,`notes_Test_Case_57`,`notes_Test_Case_58`,`notes_Test_Case_59`,`notes_Test_Case_60`,`notes_Test_Case_61`,`notes_Test_Case_62`,`notes_Test_Case_63`,`notes_Test_Case_64`,`notes_Test_Case_65`,`notes_Test_Case_66`,`notes_Test_Case_67`,`notes_Test_Case_68`,`notes_Test_Case_69`,`notes_Test_Case_70`,`notes_Test_Case_71`,`notes_Test_Case_72`,`notes_Test_Case_73`,`notes_Test_Case_74`,`notes_Test_Case_75`,`notes_Test_Case_76`,`notes_Test_Case_77`,`notes_Test_Case_78`,`notes_Test_Case_79`,`notes_Test_Case_80`,`notes_Test_Case_81`,`notes_Test_Case_82`,`notes_Test_Case_83`,`notes_Test_Case_84`,`notes_Test_Case_85`,`notes_Test_Case_86`,`notes_Test_Case_87`,`notes_Test_Case_88`,`notes_Test_Case_89`,`timetaken_Test_Case_1`,`timetaken_Test_Case_2`,`timetaken_Test_Case_3`,`timetaken_Test_Case_4`,`timetaken_Test_Case_5`,`timetaken_Test_Case_6`,`timetaken_Test_Case_7`,`timetaken_Test_Case_8`,`timetaken_Test_Case_9`,`timetaken_Test_Case_10`,`timetaken_Test_Case_11`,`timetaken_Test_Case_12`,`timetaken_Test_Case_13`,`timetaken_Test_Case_14`,`timetaken_Test_Case_15`,`timetaken_Test_Case_16`,`timetaken_Test_Case_17`,`timetaken_Test_Case_18`,`timetaken_Test_Case_19`,`timetaken_Test_Case_20`,`timetaken_Test_Case_21`,`timetaken_Test_Case_22`,`timetaken_Test_Case_23`,`timetaken_Test_Case_24`,`timetaken_Test_Case_25`,`timetaken_Test_Case_26`,`timetaken_Test_Case_27`,`timetaken_Test_Case_28`,`timetaken_Test_Case_29`,`timetaken_Test_Case_30`,`timetaken_Test_Case_31`,`timetaken_Test_Case_32`,`timetaken_Test_Case_33`,`timetaken_Test_Case_34`,`timetaken_Test_Case_35`,`timetaken_Test_Case_36`,`timetaken_Test_Case_37`,`timetaken_Test_Case_38`,`timetaken_Test_Case_39`,`timetaken_Test_Case_40`,`timetaken_Test_Case_41`,`timetaken_Test_Case_42`,`timetaken_Test_Case_43`,`timetaken_Test_Case_44`,`timetaken_Test_Case_45`,`timetaken_Test_Case_46`,`timetaken_Test_Case_47`,`timetaken_Test_Case_48`,`timetaken_Test_Case_49`,`timetaken_Test_Case_50`,`timetaken_Test_Case_51`,`timetaken_Test_Case_52`,`timetaken_Test_Case_53`,`timetaken_Test_Case_54`,`timetaken_Test_Case_55`,`timetaken_Test_Case_56`,`timetaken_Test_Case_57`,`timetaken_Test_Case_58`,`timetaken_Test_Case_59`,`timetaken_Test_Case_60`,`timetaken_Test_Case_61`,`timetaken_Test_Case_62`,`timetaken_Test_Case_63`,`timetaken_Test_Case_64`,`timetaken_Test_Case_65`,`timetaken_Test_Case_66`,`timetaken_Test_Case_67`,`timetaken_Test_Case_68`,`timetaken_Test_Case_69`,`timetaken_Test_Case_70`,`timetaken_Test_Case_71`,`timetaken_Test_Case_72`,`timetaken_Test_Case_73`,`timetaken_Test_Case_74`,`timetaken_Test_Case_75`,`timetaken_Test_Case_76`,`timetaken_Test_Case_77`,`timetaken_Test_Case_78`,`timetaken_Test_Case_79`,`timetaken_Test_Case_80`,`timetaken_Test_Case_81`,`timetaken_Test_Case_82`,`timetaken_Test_Case_83`,`timetaken_Test_Case_84`,`timetaken_Test_Case_85`,`timetaken_Test_Case_86`,`timetaken_Test_Case_87`,`timetaken_Test_Case_88`,`timetaken_Test_Case_89`) values 
(1,15,'trimm',NULL,NULL,NULL,NULL,NULL,'2024-04-23 09:20:54',0,'Information Gathering: OTG-INFO-001 - Conduct Search Engine Discovery and Reconnaissance for Information Leakage',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/* Trigger structure for table `assignments` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `after_assignment_insert1` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `after_assignment_insert1` AFTER INSERT ON `assignments` FOR EACH ROW 
BEGIN
    INSERT INTO summary (assignment_id) VALUES (NEW.assignment_id);
END */$$


DELIMITER ;

/* Trigger structure for table `assignments` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `insert_into_patches` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `insert_into_patches` AFTER INSERT ON `assignments` FOR EACH ROW 
BEGIN
    IF NEW.rm_pm IS NOT NULL THEN
        INSERT INTO patches (assignment_id, rm_pm)
        VALUES (NEW.assignment_id, NEW.rm_pm);
    END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `assignments` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `copy_to_patches` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `copy_to_patches` AFTER INSERT ON `assignments` FOR EACH ROW 
BEGIN
    IF EXISTS (SELECT 1 FROM patches WHERE assignment_id = NEW.assignment_id) THEN
        UPDATE patches
        SET title = NEW.title,
            description = NEW.description,
            assigned_to = NEW.assigned_to,
            product_name = NEW.product_name,
            rm_pm = NEW.rm_pm
        WHERE assignment_id = NEW.assignment_id;
    END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `assignments` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `copy_to_patches_assigneddate` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `copy_to_patches_assigneddate` AFTER INSERT ON `assignments` FOR EACH ROW 
BEGIN
    IF EXISTS (SELECT 1 FROM patches WHERE assignment_id = NEW.assignment_id) THEN
        UPDATE patches
        SET assigned_date = NEW.assigned_date
                 WHERE assignment_id = NEW.assignment_id;
    END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `assignments_vapt` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `after_insert_assignments_vapt` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `after_insert_assignments_vapt` AFTER INSERT ON `assignments_vapt` FOR EACH ROW 
BEGIN
    DECLARE v_assigned_to VARCHAR(255);
    DECLARE v_description TEXT;
    DECLARE v_product_name VARCHAR(100);
    
    -- Get assigned_to, description, and product_name from assignments table based on assignment_id
    SELECT CONCAT(u.ufname, ' ', u.ulname), a.description, a.product_name 
    INTO v_assigned_to, v_description, v_product_name
    FROM users u 
    JOIN assignments a ON u.user_id = a.assigned_to 
    WHERE a.assignment_id = NEW.assignment_id;

    -- Insert values into vapt table
    INSERT INTO vapt (assignment_id, title, description, assigned_to, product_name)
    VALUES (NEW.assignment_id, NEW.title, v_description, v_assigned_to, v_product_name);
END */$$


DELIMITER ;

/* Trigger structure for table `patches` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_status_on_status_mentor_change` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `update_status_on_status_mentor_change` BEFORE UPDATE ON `patches` FOR EACH ROW 
BEGIN
    IF NEW.status_mentor IN ('Passed', 'Passed with Exception', 'Failed') THEN
        SET NEW.status = 'Lead Approval Pending';
    END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `patches` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_mentor_username_on_status_mentor_change` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `update_mentor_username_on_status_mentor_change` BEFORE UPDATE ON `patches` FOR EACH ROW 
BEGIN
    DECLARE role_id_val INT;
    DECLARE user_id_val INT;
    
    -- Assign the value of user_id session variable to user_id_val
    SET user_id_val = @user_id;
    
    -- Fetch the user's role_id
    SELECT role_id INTO role_id_val FROM users WHERE user_id = user_id_val AND delete_flag = 0;
    
    -- If the user has role_id=4 and status_mentor is being updated
    IF role_id_val = 4 AND OLD.status_mentor != NEW.status_mentor THEN
        SET NEW.mentor_username = (SELECT username FROM users WHERE user_id = user_id_val);
    END IF;
END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
