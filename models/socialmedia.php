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

class Socialmedia_Model extends ORM
{
	// Database table name
	protected $table_name = 'socialmedia';

	public const TO_REVIEW 	= 0;
	public const DISCARDED 	= 1;
	public const POTENTIAL 	= 10;
	public const REPORTED 	= 11;
	public const SPAM 		= 100;
}

