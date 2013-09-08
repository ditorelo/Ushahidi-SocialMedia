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
	protected $has_one = array('author' => 'socialmedia_author');
	protected $has_many = array('Socialmedia_Asset');

	// Database table name
	protected $table_name = 'socialmedia_messages';

	const STATUS_TOREVIEW 	= 0;
	const STATUS_DISCARDED 	= 1;
	const STATUS_INREVIEW 	= 2;
	const STATUS_POTENTIAL 	= 10;
	const STATUS_REPORTED 	= 11;
	const STATUS_SPAM 		= 100;

	const CHANNEL_TWITTER = 'twitter';


	public function updateStatus($s, $make_spam =true) {
		$this->status = $s;
		$this->save(true);

		if ($make_spam && $s == self::STATUS_SPAM) 
		{
			$this->makeSpam();
		}
	}

	public function save($ignore_auto_spam_check = false) {
		if (! $ignore_auto_spam_check) 
		{
			if ($this->author->status == SocialMedia_Author_Model::STATUS_SPAM) 
			{
				$this->status = Socialmedia_Message_Model::STATUS_SPAM;
			}
		}

		if ($this->author->status == SocialMedia_Author_Model::STATUS_TRUSTED) 
		{
			$this->status = Socialmedia_Message_Model::STATUS_POTENTIAL;
		}

		$this->last_updated = time();
		return parent::save();
	}

	public function makeSpam() {
		$this->author->updateStatus(SocialMedia_Author_Model::STATUS_SPAM);

		$messages_from_author = ORM::factory("Socialmedia_Message")
									->where("author_id", $this->author->id)
									->find_all();

		foreach ($messages_from_author as $message)
		{
			$message->updateStatus(self::STATUS_SPAM, false);
		}
	}

	public function addAssets($media) {
		foreach ($media as $type => $objects) 
		{
			foreach ($objects as $url) 
			{
				$media = ORM::factory("Socialmedia_Asset");
				$media->type = $type;
				$media->url = $url;
				$media->message_id = $this->id;
				$media->save();
			}
		}
	}
}