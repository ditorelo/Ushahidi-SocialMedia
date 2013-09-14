Redirecting...

<form id='socialmedia_report' action='<?php echo url::site(); ?>admin/reports/edit?mid=<?php echo $socialmediaid; ?>' method='POST'>
	<input type='hidden' name='incident_news[]' value='<?php echo $incident_news; ?>'>
	<input type='hidden' name='location_name' value='<?php echo $location_name; ?>'>
</form>
<script>
	document.getElementById("socialmedia_report").submit();
</script>