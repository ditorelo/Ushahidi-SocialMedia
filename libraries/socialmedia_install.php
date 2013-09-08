<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Performs install/uninstall methods for the Social Media plugin
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	 Ushahidi Team <team@ushahidi.com> 
 * @package	Ushahidi - http://source.ushahididev.com
 * @module	 SMSSync Installer
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */


class Socialmedia_Install {
    const TABLE_NAME = "socialmedia";

	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db =  new Database();
	}

	/**
	 * Creates the required database tables for my_plugin_name
	 */
	public function run_install()
	{
		// Create the database tables
		// Include the table_prefix
        $table_prefix = Kohana::config('database.default.table_prefix');
		$this->db->query("
                   CREATE TABLE `" . $table_prefix . self::TABLE_NAME . "_messages` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`channel` varchar(20) NOT NULL COMMENT 'Should be set by plugin, denotes where message came from',
						`channel_id` varchar(255) NOT NULL COMMENT 'Message ID on channel',
						`message` text NOT NULL COMMENT 'Body of message',
						`url` text NOT NULL COMMENT 'URL of original message',
						`original_date` int(11) NOT NULL COMMENT 'Date of original message, in unixtimestamp',
						`latitude` decimal(10,8) DEFAULT NULL,
						`longitude` decimal(11,8) DEFAULT NULL,
						`status` int(11) NOT NULL COMMENT 'Current status of message',
						`priority` int(11) NOT NULL DEFAULT '0' COMMENT 'Messages with higher priority will come up higher',
						`author_id` int(11) NOT NULL,
						`incident_id` int(11) DEFAULT NULL COMMENT 'Incident ID from incident table',
						`last_updated` int(11) DEFAULT NULL COMMENT 'Last date message was updated',
						`in_review` int(11) DEFAULT NULL COMMENT 'Date message went to review',
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Holds all socialmedia info crawled by subplugins';");


		$this->db->query("CREATE TABLE IF NOT EXISTS `" . $table_prefix . self::TABLE_NAME . "_settings` (
					id int(11) unsigned NOT NULL AUTO_INCREMENT,
					setting varchar(40) DEFAULT NULL,
					value varchar(400) DEFAULT NULL,
					PRIMARY KEY (`id`),
					UNIQUE KEY `setting_UNIQUE` (`setting`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . $table_prefix . self::TABLE_NAME . "_keywords` (
					id int(11) unsigned NOT NULL AUTO_INCREMENT,
					keyword varchar(40) DEFAULT NULL,
					disabled boolean,
					PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$this->db->query("CREATE TABLE `" . $table_prefix . self::TABLE_NAME . "_authors` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`author` varchar(255) NOT NULL,
					`channel_id` varchar(255) NOT NULL,
					`channel` varchar(20) DEFAULT NULL,
					PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


		$this->db->query("CREATE TABLE `" . $table_prefix . self::TABLE_NAME . "_asset` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`type` varchar(45) NOT NULL COMMENT 'Holds media type (url, picture, video)',
					`url` text NOT NULL,
					`socialmedia_message_id` int(11) NOT NULL,
					PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		// Add crawler in to scheduler table
		$this->db->query("INSERT IGNORE INTO `" . $table_prefix . "scheduler`
				(`scheduler_name`,`scheduler_last`,`scheduler_weekday`,`scheduler_day`,`scheduler_hour`,`scheduler_minute`,`scheduler_controller`,`scheduler_active`) VALUES
				('Ushahidi-SocialMedia','0','-1','-1','-1','-1','s_socialmedia','1')");
	}


	/**
	 * Deletes the database tables for my_plugin_name
	 */
	public function uninstall()
	{
		$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME . "_messages`;
			");

		$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME . "_settings`;
			");

		$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME . "_keywords`;
			");

		$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME . "_authors`;
			");

		$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME . "_asset`;
			");

		$this->db->query("
			DELETE FROM  `".Kohana::config('database.default.table_prefix') . "sheduler`
			WHERE
			scheduler_controller = `s_socialmedia`;
			");

	}
}