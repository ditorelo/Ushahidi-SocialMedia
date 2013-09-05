<?php
/**
 * Social Media Keywords view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	 Ushahidi Team <team@ushahidi.com> 
 * @package	Ushahidi - http://source.ushahididev.com
 * @module	 API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
			<div class="bg">
				<h2>
					<?php admin::settings_subtabs("socialmedia"); ?>
				</h2>
				<!-- tabs -->
				<div class="tabs">
					<!-- tabset -->
					<ul class="tabset">
						<?php SocialMedia_Controller::subtabs("keywords"); ?>
					</ul>
					<!-- /tabset -->
				</div>
				<!-- /tabs -->

				<div class="report-form">
					<?php if ($form_error): ?>
					<!-- red box-->
					<div class="red-box">
						<h3><?php echo Kohana::lang('ui_main.error'); ?></h3>
						<ul>
							<?php
								foreach ($errors as $error_item => $error_description)
								{
									print (!$error_description)? '' : "<li>" . $error_description . "</li>";
								}
							?>
						</ul>
					</div>
					<?php endif; ?>

					<?php if ($form_saved): ?>
						<!-- green box -->
						<div class="green-box">
							<h3><?php echo Kohana::lang('ui_main.configuration_saved'); ?></h3>
						</div>
					<?php endif; ?>

						<?php print form::open(NULL,array('id' => 'keywordListing', 'name' => 'keywordListing')); ?>
							<input type="hidden" name="action" id="action" value="">
							<input type="hidden" name="keyword_id_action" id="keyword_id_action" value="">
							<div class="table-holder">
								<table class="table">
									<thead>
										<tr>
											<th class="col-1">&nbsp;</th>
											<th class="col-2"><?php echo Kohana::lang('ui_admin.keywords');?></th>
											<th class="col-4"><?php echo Kohana::lang('ui_main.actions');?></th>
										</tr>
									</thead>
									<tbody>
										<?php if ($total_items == 0): ?>
											<tr>
												<td colspan="4" class="col">
													<h3><?php echo Kohana::lang('ui_main.no_results');?></h3>
												</td>
											</tr>
										<?php endif; ?>
										<?php
										foreach ($keywords as $item)
										{
										?>
											<tr>
												<td class="col-1">&nbsp;</td>
												<td class="col-2">
													<?php echo $item->keyword; ?><?php echo $item->disabled ? " (" . utf8::strtolower(Kohana::lang('ui_main.disabled')) . ")" : null ?>
												</td>
												<td class="col-4">
													<ul>
														<li class="none-separator"><a href="#add" onClick="fillFields('<?php echo(rawurlencode($item->id)); ?>' ,'<?php echo(rawurlencode($item->keyword)); ?>','<?php echo(rawurlencode($item->disabled)); ?>')"><?php echo Kohana::lang('ui_main.edit');?></a></li>
														<li><a href="javascript:keywordAction('d','DELETE','<?php echo(rawurlencode($item->id)); ?>')" class="del"><?php echo Kohana::lang('ui_main.delete');?></a></li>
													</ul>
												</td>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
							</div>
						<?php print form::close(); ?>
					</div>
					
					<!-- tabs -->
					<div class="tabs">
						<!-- tabset -->
						<a name="add"></a>
						<ul class="tabset">
							<li><a href="#" class="active"><?php echo Kohana::lang('ui_main.add_edit');?></a></li>
						</ul>
						<!-- tab -->
						<div class="tab">
							<?php print form::open(NULL,array('id' => 'keywordMain', 'name' => 'keywordMain')); ?>
							<input type="hidden" id="keyword_id"  name="keyword_id" value="" />
							<input type="hidden" name="action" id="action" value="a"/>
							<div class="tab_form_item">
								<strong><?php echo Kohana::lang('ui_admin.keyword');?>:</strong><br />
								<?php print form::input('keyword', '', ' class="text"'); ?>
							</div>
							<div class="tab_form_item">
								<strong><?php echo Kohana::lang('ui_main.disabled');?>:</strong><br />
								<?php print form::checkbox('disabled', 1); ?>
							</div>
							<div class="tab_form_item">
								<input type="submit" class="save-rep-btn" value="<?php echo Kohana::lang('ui_main.save');?>" />
							</div>
							<?php print form::close(); ?>
						</div>
					</div>
				</div>
			</div>