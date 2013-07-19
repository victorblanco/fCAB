<script>

jQuery(function($){
	$.datepicker.regional['lo'] = {
		closeText: '<!-- {close_text} -->',
		prevText: '',
		nextText: '',
		currentText: '<!-- {current_text} -->',
		monthNames: [<!-- {meses} -->],
		monthNamesShort: [<!-- {meses_short} -->],
		dayNames: [<!-- {dias} -->],
		dayNamesShort: [<!-- {dias_short} -->],
		dayNamesMin: [<!-- {dias_min} -->],
		weekHeader: '<!-- {week_header} -->',
		dateFormat: '<!-- {format} -->',
		firstDay: <!-- {first_day} -->,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.timepicker.regional['lo'] = {
			currentText: "<!-- {current_text_time} -->",
			ampm: false,
			timeFormat: 'hh:mm tt',
			timeOnlyTitle: '<!-- {time_title} -->',
			timeText: '<!-- {time_text} -->',
			hourText: '<!-- {hour_text} -->',
			minuteText: '<!-- {minute_text} -->',
			secondText: '<!-- {second_text} -->'};
	$.datepicker.setDefaults($.datepicker.regional['lo']);
	$.timepicker.setDefaults($.timepicker.regional['lo'])
});

</script>
<div class="breadcrumb">
	<div style="float:left; padding-left: 5px;"><img src="img/logotipo.png" /></div>
	<div style="float:right; padding-right: 5px;"><h1>Administraci&oacute;n</h1></div>
	<div style="clear: both; height: 17px; border-top: 1px double rgb(0, 0, 0); background-color: #FFF; padding: 1px 3px 0px;"><!-- {breadcrumb} --></div>
</div>