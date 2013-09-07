/**
 * JavaScript for the socialmedia messages page
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://github.com/ushahidi/Ushahidi_Web
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */


<?php require SYSPATH.'../application/views/admin/utils_js.php' ?>

// Form Submission
function socialMediaAction ( action, confirmAction, id )
{
	var statusMessage;
	var answer = confirm('<?php echo Kohana::lang('socialmedia.messages.are_you_sure_you_want_to_mark_reports'); ?> ' + confirmAction + '?')
	if (answer) {
		if (id != "") {
			$(document.getElementById("checkallmessages")).attr("checked", false);
			CheckAll( 'checkallmessages', 'message_id[]' );
		}

		// Set Message ID
		$(document.getElementById("message_single")).val(id);
		// Set Submit Type
		$(document.getElementById("action")).val(action);
		// Submit Form
		$(document.getElementById("socialMediaMain")).submit();
	}
}