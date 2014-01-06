<?php defined('SYSPATH') or die('No direct script access.');
/**
 * SocialMedia Hooks
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package	   Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class socialmedia {
	
	/**
	 * Registers the main event add method
	 */
	public function __construct()
	{
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}

	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
		// Settings menu
		if (Router::$controller == 'settings' or Router::$controller == 'socialmedia')
		{
			Event::add('ushahidi_action.nav_admin_settings', array($this, '_socialmedia'));
		}

		// Messages menu
		if (Router::$controller == 'messages' or Router::$controller == 'socialmedia' or Router::$controller == 'tool' )
		{
			Event::add('ushahidi_action.nav_admin_messages', array($this, '_messages'));
		}

		Event::add('ushahidi_action.report_edit', array("SocialMedia_Message_Model", "update_report_created"));


		// TODO: Hook up incident ID to message once report is saved
		//Event::add('ushahidi_action.report_edit', array($this, '_save_incident_id'));
	}

	public function _socialmedia()
	{
		$this_sub_page = Event::$data;
		echo ($this_sub_page == "socialmedia") ? "SocialMedia" : "<a href=\"".url::site()."admin/settings/socialmedia\">SocialMedia</a>";
	}

	public function _messages()
	{

		$this_sub_page = Event::$data;
		echo ($this_sub_page == "socialmedia") ? "SocialMedia" : "<a href=\"".url::site()."admin/messages/socialmedia\">SocialMedia</a>";

		// Nasty way of hiding the unwanted menu for the Social Media services
		?>
		<script>
			$(document).ready(function() {
				$("a:contains('SocialMedia ')", $(".bg", document.getElementById("content"))).remove();
			});
		</script>
		<?php
	}

/*
	public function _save_incident_id() {
		$incident = Event::$data;
		var_dump($incident);
		die();
	}
*/
}

new socialmedia;