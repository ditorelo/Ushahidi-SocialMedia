<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for Social Media
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @subpackage Models
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Socialmedia_Message_Model extends ORM
{
	protected $has_one = array('socialmedia_author');

	// Database table name
	protected $table_name = 'socialmedia_messages';

	const STATUS_TOREVIEW 	= 0;
	const STATUS_DISCARDED 	= 1;
	const STATUS_POTENTIAL 	= 10;
	const STATUS_REPORTED 	= 11;
	const STATUS_SPAM 		= 100;

	const CHANNEL_TWITTER = 'twitter';
}