	<script type="text/javascript" src="js/calendar.js"></script>
	<script type="text/javascript" src="js/date.js"></script>
	<link href="css/ControlCalendar.css" rel="stylesheet" type="text/css" />

<input name="<!-- {name} -->" style="width:70px; border:solid 1px #CCCCCC; letter-spacing:0px; text-align:center;" value="<!-- {selected} -->" id="<!-- {name} -->" class="date-pick dp-applied" type="text">

<script type="text/javascript">
	$j = jQuery.noConflict();
	$j(function() {
	  Date.format = 'dd-mm-yyyy';
	  $j('#<!-- {name} -->').datePicker({startDate:'01-01-1996'});
	});
</script>
