<?php defined('SYSPATH') or die('No direct script access.');
/**
 * SocialMedia Settings Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
*
*/

class SocialMedia_Controller extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'settings';

		// If user doesn't have access, redirect to dashboard
		if ( ! $this->auth->has_permission("manage"))
		{
			url::redirect(url::site().'admin/dashboard');
		}
	}

	static public function processSubmit() {
		$error = false;
		$saved = false;

		if ($_POST) {
			$post = Validation::factory($_POST);

			//  Add some filters
			$post->pre_filter('trim', TRUE);

			// Add Action
			if ($post->action == 's')
			{
				socialmedia_helper::setSetting("enable_location", (isset($post->enable_location) ? $post->enable_location : false));
				socialmedia_helper::setSetting("radius", (isset($post->radius) ? $post->radius : false));
				socialmedia_helper::setSetting("start_date", (isset($post->start_date) ? $post->start_date : false));

				socialmedia_helper::setSetting("latitude", (isset($post->latitude) ? $post->latitude : false));
				socialmedia_helper::setSetting("longitude", (isset($post->longitude) ? $post->longitude : false));
			}

			$saved = true;
		}

		return array(
			"error"	=> $error,
			"saved" => $saved
		);
	}

	public function index()
	{
		$result = self::processSubmit();

		$this->template->content = new View('admin/settings/socialmedia/main');
		$this->template->content->title = Kohana::lang('ui_admin.settings');

		$this->template->content->form_error = $result["error"];
		$this->template->content->form_saved = $result["saved"];

		$radius_options = array("" => "");
		for ($i = 10; $i < 100; $i += 10) {
			$radius_options[$i] = $i . "km (" . number_format($i/1.6, 2) . " mi)";
		}

		for ($i = 100; $i <= 1000; $i += 100) {
			$radius_options[$i] = $i . "km (" . number_format($i/1.6, 2) . " mi)";
		}


		if (! $latitude = socialmedia_helper::getSetting("latitude")) {
			$latitude = Kohana::config('settings.default_lat');
		}

		if (! $longitude = socialmedia_helper::getSetting("longitude")) {
			$longitude = Kohana::config('settings.default_lon');
		}

		$this->template->content->latitude = $latitude;
		$this->template->content->longitude = $longitude;
		$this->template->content->radius_options = $radius_options;

		$this->template->content->enable_location = socialmedia_helper::getSetting("enable_location");
		$this->template->content->start_date = socialmedia_helper::getSetting("start_date");
		$this->template->content->radius = socialmedia_helper::getSetting("radius");



		$this->themes->js = new View('admin/settings/socialmedia/main_js');
		// Display all maps
		$this->themes->map_enabled = TRUE;
		$this->themes->js->latitude = $latitude;
		$this->themes->js->longitude = $longitude;
		$this->themes->js->default_zoom = Kohana::config('settings.default_zoom');
	}

	public function keywords() {
		$result = self::processKeyword();

		$this->template->content = new View('admin/settings/socialmedia/keywords');
		$this->template->content->title = Kohana::lang('ui_admin.settings');

		$this->template->content->form_error = $result["error"] != false;
		$this->template->content->errors = $result["error"];
		$this->template->content->form_saved = $result["saved"];

		$items = ORM::factory("socialmedia_keyword")
					->orderby("keyword")
					->find_all();

		$this->template->content->total_items = $items->count();
		$this->template->content->keywords = $items;

		$this->themes->js = new View('admin/settings/socialmedia/keywords_js');
	}

	static function processKeyword() {
		$errors = array();
		$saved = false;

		if ($_POST)
		{
			$post = Validation::factory($_POST);

			//  Add some filters
			$post->pre_filter('trim', TRUE);

			// Add Action
			if ($post->action == 'a')
			{
				if (empty($post->keyword)) 
				{
					$errors[] = Kohana::lang('socialmedia.admin.error.keyword_empty');
				} 
				else
				{
					$keywords = ORM::factory("socialmedia_keyword")
						->where("keyword", $post->keyword)
						->find_all();

					if (count($keywords) > 0 && empty($post->keyword_id))
					{
						$errors[] = Kohana::lang('socialmedia.admin.error.keyword_already_exists');
					} 
					else 
					{
						if (empty($post->keyword_id)) {
							$keyword = ORM::factory("socialmedia_keyword");	
						} else {
							$keyword = ORM::factory("socialmedia_keyword")->find($post->keyword_id);
						}

						$keyword->keyword = $post->keyword;
						$keyword->disabled = ! empty($post->disabled);
						$keyword->save();
					}
				}
			}
			elseif ($post->action == 'd')
			{
				$keyword = ORM::factory("socialmedia_keyword")->find($post->keyword_id_action);
				$keyword->delete();
			}

			if (count($errors) == 0)
			{
				$saved = true;
			}
		}

		return array(
			"error"	=> count($errors) == 0 ? false : $errors,
			"saved" => $saved
		);
	}

	/**
	 * Generate Report Sub Tab Menus
	 * @param string $this_sub_page
	 * @return string $menu
	 */
	public static function subtabs($this_sub_page = FALSE)
	{
		$menu = "<li><a href='" . url::site() . "admin/settings/socialmedia'" . ($this_sub_page != "main" ? null : " class='active'") . ">General</a></li>";
		$menu .= "<li><a href='" . url::site() . "admin/settings/socialmedia/keywords'" . ($this_sub_page != "keywords" ? null : " class='active'") . ">" . Kohana::lang('ui_admin.keywords') . "</a></li>";


		echo $menu;

		// Action::socialmedia.settings_subtabs - Add items to the social media settings page
		Event::run('socialmedia.settings_subtabs', $this_sub_page);
	}
}