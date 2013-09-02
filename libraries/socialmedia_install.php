<?php
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


class My_plugin_name_Install {
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
                    CREATE  TABLE `" . $table_prefix . self::TABLE_NAME . "` (
                      `id` INT NOT NULL ,
                      `channel` VARCHAR(20) NOT NULL COMMENT 'Should be set by plugin, denotes where message came from' ,
                      `channel_id` VARCHAR(255) NOT NULL COMMENT 'Message ID on channel' ,
                      `message` TEXT NOT NULL COMMENT 'Body of message' ,
                      `url` TEXT NOT NULL COMMENT 'URL of original message' ,
                      `original_date` INT NOT NULL COMMENT 'Date of original message, in unixtimestamp' ,
                      `latitude` DECIMAL(10,8) NULL ,
                      `longitude` DECIMAL(11,8) NULL ,
                      `status` INT NOT NULL COMMENT 'Current status of message' ,
                      PRIMARY KEY (`id`) )
                    DEFAULT CHARACTER SET = utf8
                    COMMENT = 'Holds all socialmedia info crawled by subplugins'");

	}

	/**
	 * Deletes the database tables for my_plugin_name
	 */
	public function uninstall()
	{
		$this->db->query("
			DROP TABLE `".Kohana::config('database.default.table_prefix') . self::TABLE_NAME "`;
			");
	}
}