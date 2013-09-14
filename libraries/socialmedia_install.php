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

        // messages table
		$this->db->query("
                   CREATE TABLE `" . $table_prefix . self::TABLE_NAME . "_messages_data` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`field_name` varchar(45) NOT NULL,
					`value` text NOT NULL,
					`message_id` int(11) NOT NULL,
					PRIMARY KEY (`id`),
					KEY `message_id` (`message_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Holds all socialmedia info crawled by subplugins';");

		// settings table
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . $table_prefix . self::TABLE_NAME . "_settings` (
						`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						`setting` varchar(40) DEFAULT NULL,
						`value` varchar(400) DEFAULT NULL,
						PRIMARY KEY (`id`),
						UNIQUE KEY `setting_UNIQUE` (`setting`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		// keywords table
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . $table_prefix . self::TABLE_NAME . "_keywords` (
					id int(11) unsigned NOT NULL AUTO_INCREMENT,
					keyword varchar(40) DEFAULT NULL,
					disabled boolean,
					PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		/*$this->db->query("CREATE TABLE `" . $table_prefix . self::TABLE_NAME . "_authors` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`author` varchar(255) NOT NULL,
					`channel_id` varchar(255) NOT NULL,
  					`channel` varchar(20) NOT NULL,
  					`status` int(11) NOT NULL,
					PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");*/

		// assets table
		$this->db->query("CREATE TABLE `" . $table_prefix . self::TABLE_NAME . "_asset` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`type` varchar(45) NOT NULL COMMENT 'Holds media type (url, picture, video)',
			`url` text NOT NULL,
			`message_id` int(11) NOT NULL,
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
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME . "_messages_data`;
			");

		$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME . "_settings`;
			");

		$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME . "_keywords`;
			");

		/*$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME . "_authors`;
			");*/

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