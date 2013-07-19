<?php


class DateFormat_fr_FR extends DateFormat {

	protected $shortMonths = array(
					  1 => 'Jan'
					, 2 => 'Fév'
					, 3 => 'Mar'
					, 4 => 'Avr'
					, 5 => 'Mai'
					, 6 => 'Juin'
					, 7 => 'Juil'
					, 8 => 'Août'
					, 9 => 'Sep'
					, 10 => 'Oct'
					, 11 => 'Nov'
					, 12 => 'Déc'
				);

	protected $longMonths = array(
					  1 => 'Janvier'
					, 2 => 'Février'
					, 3 => 'Mars'
					, 4 => 'Avril'
					, 5 => 'Mai'
					, 6 => 'Juin'
					, 7 => 'Juillet'
					, 8 => 'Août'
					, 9 => 'Septembre'
					, 10 => 'Octobre'
					, 11 => 'Novembre'
					, 12 => 'Décembre'
				);

	protected $shortWeekDays = array(
					  0 => 'Dim'
					, 1 => 'Lun'
					, 2 => 'Mar'
					, 3 => 'Mer'
					, 4 => 'Jeu'
					, 5 => 'Ven'
					, 6 => 'Sam'
				);
	protected $minWeekDays = array(
					  0 => 'D'
					, 1 => 'L'
					, 2 => 'M'
					, 3 => 'M'
					, 4 => 'J'
					, 5 => 'V'
					, 6 => 'S'
					
				);
	
	protected $firstDay = 1;

	protected $longWeekDays = array(
					  0 => 'Dimanche'
					, 1 => 'Lundi'
					, 2 => 'Mardi'
					, 3 => 'Mercredi'
					, 4 => 'Jeudi'
					, 5 => 'Vendredi'
					, 6 => 'Samedi'
				);

	/* Atributos para datetimepicker jquery */
	protected $jqueryFormat 	= "dd-mm-yy";
	protected $weekHeader 		= "Sm";
	protected $timeTitle		= "Choisissez le moment";
	protected $currentTextTime	= "Maintenant";
	protected $currentText		= "Aujourd\'hui";
	protected $closeText		= "Fermer";
	protected $timeText			= "Moment";
	protected $hourText			= "Heure";
	protected $minuteText		= "Minutes";
	protected $secondText		= "Secondes";
	
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
