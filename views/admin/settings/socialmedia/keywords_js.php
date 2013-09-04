/**
 * Social Media Keywords js file.
 *
 * Handles javascript stuff related to feeds function.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
// Categories JS
function fillFields(id, keyword, disabled)
{
	$(document.getElementById("keyword_id")).val(decodeURIComponent(id));
	$(document.getElementById("keyword")).val(decodeURIComponent(keyword));
	$(document.getElementById("disabled")).attr("checked", decodeURIComponent(disabled) != "0");

	return false;
}

// Form Submission
function keywordAction ( action, confirmAction, id )
{
	var statusMessage;
	var answer = confirm('<?php echo Kohana::lang('ui_admin.are_you_sure_you_want_to'); ?> ' + confirmAction + '?')
	if (answer) {
		// Set Category ID
		$(document.getElementById("keyword_id_action")).val(id);
		// Set Submit Type
		$(document.getElementById("action")).val(action);
		// Submit Form
		$(document.getElementById("keywordListing")).submit();
	}
}