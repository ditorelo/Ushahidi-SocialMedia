<div id="message" style="padding: 20px; min-height: 600px;">

	<?php if (! empty($message->longitude) && !empty($message->latitude)): ?>
		<div id="map_holder" style="float:right; width: 304px;">
            <div style="width: 304px;" id="socialmedia-map" class="mapstraction"></div>
        </div>
        <div id="map_loaded"></div>
        <input type="hidden" value="<?php echo $message->latitude; ?>" id="latitude" />
        <input type="hidden" value="<?php echo $message->longitude; ?>" id="longitude" />
	<?php endif; ?>

	<p style="font-size: 2em; max-width: 600px; line-height: 1.4em; margin-top: 0;"><?php echo $message->message_detail ?></p>

	<p><?php echo Kohana::lang('ui_main.from');?>: <a href="<?php echo $message->getData("url"); ?>" target="_blank"><?php echo trim($message->reporter->reporter_first . " " . $message->reporter->reporter_last) . "(" . $message->reporter->reporter_email . ")" ?></a><br />
	<?php if ($message->reporter->level_id == SocialMedia_Message_Model::STATUS_TRUSTED): ?>
		(<?php echo Kohana::lang('socialmedia.messages.trusted_reporter');?>)<br />
	<?php elseif ($message->reporter->level_id == SocialMedia_Message_Model::STATUS_SPAM): ?>
		(<?php echo Kohana::lang('socialmedia.messages.spam_reporter');?>)<br />
	<?php endif; ?>
		<?php if ($message->message_level == SocialMedia_Message_Model::STATUS_INREVIEW): ?>
		<br /><?php echo Kohana::lang('socialmedia.messages.message_in_review');?><br />
		<?php endif; ?>
		ID: <?php echo $message->id; ?></p>
	</p>

	<?php if ($message->Socialmedia_Asset->count() > 0): ?>
		<p><strong><?php echo Kohana::lang('socialmedia.messages.assets.title'); ?></strong></p>
		<p>
			<?php foreach ($message->Socialmedia_Asset as $media): ?>
				<?php if ($media->type != "photo"): ?>
					<?php echo Kohana::lang('socialmedia.messages.assets.' . $media->type); ?>: 
					<a target="_blank" href="<?php echo $media->url; ?>"><?php echo $media->url; ?><br />
				<?php endif; ?>
			<?php endforeach; ?>
		</p>

		<?php foreach ($message->Socialmedia_Asset as $media): ?>
			<?php if ($media->type == "photo"): ?>
				<a target="_blank" href="<?php echo $media->url; ?>">
					<img src="<?php echo $media->url; ?>" width='200' />
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php print form::open(NULL ,array('id' => 'toolForm', 'name' => 'toolForm')); ?>
		<?php print form::hidden('message_single', $message->id); ?>
		<?php print form::hidden('action', null); ?>
	<?php print form::close(); ?>

</div>