<?php 
/**
 * Twitter view page.
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
?>
				<h2>
					<?php admin::messages_subtabs("socialmedia"); ?>
				</h2>

				<div class="tabs">
					<ul class="tabset">
							<li><a href="/admin/messages/socialmedia"><?php echo Kohana::lang('socialmedia.messages.back'); ?></a></li>
					</ul>
					<!-- tab -->					
					<div class="tab">
						<ul>
							<li><a href="#" onclick="toolAction('p')"><?php echo utf8::strtoupper(Kohana::lang('socialmedia.messages.tool.potential_report')) ;?></a></li>
							<li><a href="#" onclick="toolAction('d')"><?php echo utf8::strtoupper(Kohana::lang('socialmedia.messages.discard')) ;?></a></li>
							<li><a href="#" onclick="toolAction('s')"><?php echo utf8::strtoupper(Kohana::lang('ui_main.spam')) ;?></a></li>
							<li><a href="#" onclick="toolAction('')"><?php echo utf8::strtoupper(Kohana::lang('socialmedia.messages.skip')) ;?></a></li>

						</ul>

						<div class="sort_by">
							<?php echo Kohana::lang('socialmedia.messages.amount_left') ;?>: <?php echo $messages_left; ?>
						</div>
					</div>
				</div>

				<div class="report-form">
					<?php require_once "tool-box.php"; ?>
				</div>
