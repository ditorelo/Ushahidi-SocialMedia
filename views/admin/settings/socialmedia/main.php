<?php
/**
 * Social Media settings view page.
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
				<?php print form::open(NULL, array('id' => 'SocialMediaSettings', 'name' => 'SocialMediaSettings')); ?>

				<!-- tabs -->
				<div class="tabs">
					<!-- tabset -->
					<ul class="tabset">
						<?php SocialMedia_Controller::subtabs("main"); ?>
					</ul>
					<!-- /tabset -->

					<!-- tab -->
					<div class="tab">
						<ul>
							<li><input style="margin:0;" type="submit" class="save-rep-btn" value="<?php echo Kohana::lang('ui_admin.save_settings');?>" /></li>
						</ul>
					</div>
					<!-- /tab -->
				</div>
				<!-- /tabs -->

				<input type="hidden" name="action" id="action" value="s" />

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

					<!--column-->
					<div class="l-column">
						<div class="row">
							<h4><?php echo Kohana::lang('socialmedia.settings.start_date'); ?></h4>
							<?php print form::input('start_date', $start_date, ' class="text"'); ?>
							<div style="clear:both"></div>
							<p><?php echo Kohana::lang('socialmedia.settings.start_date_explanation'); ?></p>
						</div>
						<div class="row">
							<h4><?php echo Kohana::lang('socialmedia.settings.order'); ?></h4>
							<?php print form::dropdown('order', $orders, $order); ?>
							<div style="clear:both"></div>
						</div>
						<div class="row">
							<h4><?php echo Kohana::lang('socialmedia.settings.images'); ?></h4>
							<?php print form::checkbox('show_images_on_listing', "1", $show_images_on_listing); ?>
							<div style="clear:both"></div>
						</div>
					</div>
                    <div class="r-column">
                                <h4><?php echo Kohana::lang('socialmedia.settings.map_radius'); ?></h4>
                                <p><?php echo Kohana::lang('socialmedia.settings.map_radius_explanation'); ?></p>

                                <label><?php print form::checkbox('enable_location', '1', !empty($enable_location)); ?> <?php echo Kohana::lang('socialmedia.settings.enable_location'); ?></label>

                                <div class="location-info" style='width: 100%; float:none; padding: 10px 0 0 0; height:30px;'>
                                    <span><?php echo Kohana::lang('ui_main.latitude');?>:</span>
                                    <?php print form::input('latitude', $latitude, ' readonly="readonly" class="text"'); ?>
                                    <span><?php echo Kohana::lang('ui_main.longitude');?>:</span>
                                    <?php print form::input('longitude', $longitude, ' readonly="readonly" class="text"'); ?>
                                    <span><?php echo Kohana::lang('socialmedia.settings.radius_label');?>:</span>
                                    <?php print form::dropdown('radius', $radius_options, $radius, "style='width:100px'"); ?>
                                </div>

                            <div id="map_holder">
                                <div id="socialmedia-map" class="mapstraction"></div>
                            </div>
                            <div style="margin-top:25px" id="map_loaded"></div>
                        </div>
				</div>
				<?php print form::close(); ?>
			</div>
