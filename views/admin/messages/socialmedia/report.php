Redirecting...

<form id='socialmedia_report' action='<?php echo url::site(); ?>admin/reports/edit' method='POST'>
	<input type='hidden' name='incident_description' value='<?php echo $incident_description; ?>'>
	<input type='hidden' name='latitude' value='<?php echo $latitude; ?>'>
	<input type='hidden' name='longitude' value='<?php echo $longitude; ?>'>
	<input type='hidden' name='incident_news[]' value='<?php echo $incident_news; ?>'>
	<input type='hidden' name='incident_date' value='<?php echo $incident_date; ?>'>
	<input type='hidden' name='incident_hour' value='<?php echo $incident_hour; ?>'>
	<input type='hidden' name='incident_minute' value='<?php echo $incident_minute; ?>'>
	<input type='hidden' name='incident_ampm' value='<?php echo $incident_ampm; ?>'>
	<input type='hidden' name='location_name' value='<?php echo $location_name; ?>'>
	<input type='hidden' name='socialmediaid' value='<?php echo $socialmediaid; ?>'>
</form>
<script>
	document.getElementById("socialmedia_report").submit();
</script>