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

class Socialmedia_Author_Model extends ORM
{
	protected $belongs_to = array('socialmedia_message');
	
	// Database table name
	protected $table_name = 'socialmedia_authors';

	// Constants
	const STATUS_NORMAL 	= 0;
	const STATUS_SPAM		= 10;
	const STATUS_TRUSTED	= 100;

	public function updateStatus($s) {
		$this->status = $s;
		$this->save();
	}
}