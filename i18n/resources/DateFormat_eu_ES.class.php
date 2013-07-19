<?php


class DateFormat_eu_ES extends DateFormat {

	protected $shortMonths = array(
					  1 => 'Urt'
					, 2 => 'Ots'
					, 3 => 'Mar'
					, 4 => 'Apr'
					, 5 => 'Mai'
					, 6 => 'Eka'
					, 7 => 'Uzt'
					, 8 => 'Abu'
					, 9 => 'Ira'
					, 10 => 'Urr'
					, 11 => 'Aza'
					, 12 => 'Abe'
				);

	protected $longMonths = array(
					  1 => 'Urtarrila'
					, 2 => 'Otsaila'
					, 3 => 'Martxoa'
					, 4 => 'Apirila'
					, 5 => 'Maiatza'
					, 6 => 'Ekaina'
					, 7 => 'Uztaila'
					, 8 => 'Abuztua'
					, 9 => 'Iraila'
					, 10 => 'Urria'
					, 11 => 'Azaroa'
					, 12 => 'Abendua'
				);

	protected $shortWeekDays = array(
					  0 => 'Iga'
					, 1 => 'Ast'
					, 2 => 'Ast'
					, 3 => 'Ast'
					, 4 => 'Ost'
					, 5 => 'Ost'
					, 6 => 'Lar'
				);
	protected $minWeekDays = array(
					  0 => 'I'
					, 1 => 'A'
					, 2 => 'A'
					, 3 => 'A'
					, 4 => 'O'
					, 5 => 'O'
					, 6 => 'L'
					
				);
	
	protected $firstDay = 1;

	protected $longWeekDays = array(
					  0 => 'Igandea'
					, 1 => 'Astelehena'
					, 2 => 'Asteartea'
					, 3 => 'Asteazkena'
					, 4 => 'Osteguna'
					, 5 => 'Ostirala'
					, 6 => 'Larunbata'
				);

	/* Atributos para datetimepicker jquery */
	protected $jqueryFormat 	= "dd-mm-yy";
	protected $weekHeader 		= "Sm";
	protected $timeTitle		= "Hautatu momnetua";
	protected $currentTextTime	= "Orain";
	protected $currentText		= "Gaur";
	protected $closeText		= "Itxi";
	protected $timeText			= "Momentua";
	protected $hourText			= "Ordua";
	protected $minuteText		= "Minutuak";
	protected $secondText		= "Segunduak";
	
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
