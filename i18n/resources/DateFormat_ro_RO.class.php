<?php


class DateFormat_ro_RO extends DateFormat {

	protected $shortMonths = array(
					  1 => 'Ian'
					, 2 => 'Feb'
					, 3 => 'Mar'
					, 4 => 'Abr'
					, 5 => 'Mai'
					, 6 => 'Iun'
					, 7 => 'Iul'
					, 8 => 'Aug'
					, 9 => 'Sep'
					, 10 => 'Oct'
					, 11 => 'Nov'
					, 12 => 'Dic'
				);

	protected $longMonths = array(
					  1 => 'Ianuarie'
					, 2 => 'Februarie'
					, 3 => 'Martie'
					, 4 => 'Aprilie'
					, 5 => 'Mai'
					, 6 => 'Iunie'
					, 7 => 'Iulie'
					, 8 => 'August'
					, 9 => 'Septembrie'
					, 10 => 'Octombrie'
					, 11 => 'Noiembrie'
					, 12 => 'Decembrie'
				);

	protected $shortWeekDays = array(
					  0 => 'Dum'
					, 1 => 'Lun'
					, 2 => 'Mar'
					, 3 => 'Mie'
					, 4 => 'Joi'
					, 5 => 'Vin'
					, 6 => 'Sâm'
				);
	protected $minWeekDays = array(
					  0 => 'D'
					, 1 => 'L'
					, 2 => 'M'
					, 3 => 'Mi'
					, 4 => 'J'
					, 5 => 'V'
					, 6 => 'S'
					
				);
	
	protected $firstDay = 1;

	protected $longWeekDays = array(
					  0 => 'Duminicã'
					, 1 => 'Luni'
					, 2 => 'Marþi'
					, 3 => 'Miercuri'
					, 4 => 'Joi'
					, 5 => 'Vineri'
					, 6 => 'Sâmbãtã'
				);

	/* Atributos para datetimepicker jquery */
	protected $jqueryFormat 	= "zz-ll-aa";
	protected $weekHeader 		= "Sãpt";
	protected $timeTitle		= "Alege momentul";
	protected $currentTextTime	= "Acum";
	protected $currentText		= "Azi";
	protected $closeText		= "Închide";
	protected $timeText			= "Momentul";
	protected $hourText			= "Ora";
	protected $minuteText		= "Minutele";
	protected $secondText		= "Secundele";
	
	protected $dateFormats = array(
				  self::DATE_FORMAT_DEFAULT	=> '%d %b %Y'
				, self::DATE_FORMAT_SHORT	=> '%d/%M/%Y'
				, self::DATE_FORMAT_MEDIUM	=> '%d %b %Y'
				, self::DATE_FORMAT_FULL_TIME=> '%D-%M-%Y  %H:%I:%S'
				, self::DATE_FORMAT_LONG	=> '%d %B %Y'
				, self::DATE_FORMAT_FULL	=> '%A, %d %B %Y'
				, self::DATE_FORMAT_SQL		=> '%Y-%M-%D'
				, self::DATE_FORMAT_SQL_FULL=> '%Y-%M-%D %H:%I:%S'
				, self::DATE_FORMAT_MEDIUM_TIME=> '%d %b %Y  %H:%I:%S'
				);

	protected $timeFormats = array(
				  self::TIME_FORMAT_DEFAULT	=> '%H:%I'
				, self::TIME_FORMAT_SHORT	=> '%H:%I'
				, self::TIME_FORMAT_LONG	=> '%H:%I:%S'
				, self::TIME_FORMAT_FULL	=> '%H:%I:%S %Z'
				, self::TIME_FORMAT_SQL		=> '%H:%I:%S'
				);
}
