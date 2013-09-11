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

	// Constants 
	const STATUS_TOREVIEW 	= 0;
	const STATUS_DISCARDED 	= 1;
	const STATUS_INREVIEW 	= 2;
	const STATUS_POTENTIAL 	= 10;
	const STATUS_REPORTED 	= 11;
	const STATUS_SPAM 		= 100;

	const CHANNEL_TWITTER = 'twitter';

	/**
	 * Helper to update message status
	 * @param integer Status
	 * @param boolean(optional) $make_spam If Status is STATUS_SPAM will update messages from same author as spam and also flag author as spammer (default true)
	 */
	public function updateStatus($s, $make_spam = true) {
		$this->status = $s;
		$this->save(true);

		if ($make_spam && $s == self::STATUS_SPAM) 
		{
			$this->makeSpam();
		}
	}

	/**
	 * Overrides save function for Spam and Trusted checks
	 * @param boolean $ignore_auto_spam_check Won't set message as spam even if author is flagged as spammer (default false)
	 */
	public function save($ignore_auto_spam_check = false) {
		if (! $ignore_auto_spam_check) 
		{
			// Marking message as spam if author is spammer
			if ($this->author->status == SocialMedia_Author_Model::STATUS_SPAM) 
			{
				$this->status = self::STATUS_SPAM;
			}
		}

		// bumps message status if author is trusted
		if ($this->author->status == SocialMedia_Author_Model::STATUS_TRUSTED && $this->status == self::STATUS_TOREVIEW) 
		{
			$this->status = self::STATUS_POTENTIAL;
		}

		$this->last_updated = time();
		return parent::save();
	}

	/**
	 * Mark message and authors as spam
	 */
	public function makeSpam() {
		$this->author->updateStatus(SocialMedia_Author_Model::STATUS_SPAM);

		// Updates all messages from author as spam
		$messages_from_author = ORM::factory("Socialmedia_Message")
									->where("author_id", $this->author->id)
									->find_all();

		foreach ($messages_from_author as $message)
		{
			$message->updateStatus(self::STATUS_SPAM, false);
		}
	}

	/**
	 * Saves Assets relates to this media as a Socialmedia_asset
	 * @param array Each asset should be represented by a [type, url] array
	 */
	public function addAssets($media) {
		foreach ($media as $type => $objects) 
		{
			foreach ($objects as $url) 
			{
				$media = ORM::factory("Socialmedia_Asset");
				$media->type = $type;
				$media->url = $url;
				$media->socialmedia_message_id = $this->id;
				$media->save();
			}
		}
	}
}