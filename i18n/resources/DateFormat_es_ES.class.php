<?php


class DateFormat_es_ES extends DateFormat {

	protected $shortMonths = array(
					  1 => 'Ene'
					, 2 => 'Feb'
					, 3 => 'Mar'
					, 4 => 'Abr'
					, 5 => 'May'
					, 6 => 'Jun'
					, 7 => 'Jul'
					, 8 => 'Ago'
					, 9 => 'Sep'
					, 10 => 'Oct'
					, 11 => 'Nov'
					, 12 => 'Dic'
				);

	protected $longMonths = array(
					  1 => 'Enero'
					, 2 => 'Febrero'
					, 3 => 'Marzo'
					, 4 => 'Abril'
					, 5 => 'Mayo'
					, 6 => 'Junio'
					, 7 => 'Julio'
					, 8 => 'Agosto'
					, 9 => 'Septiembre'
					, 10 => 'Octubre'
					, 11 => 'Noviembre'
					, 12 => 'Diciembre'
				);

	protected $shortWeekDays = array(
					  0 => 'Dom'
					, 1 => 'Lun'
					, 2 => 'Mar'
					, 3 => 'Mie'
					, 4 => 'Jue'
					, 5 => 'Vie'
					, 6 => 'Sab'
				);
	protected $minWeekDays = array(
					  0 => 'D'
					, 1 => 'L'
					, 2 => 'M'
					, 3 => 'X'
					, 4 => 'J'
					, 5 => 'V'
					, 6 => 'S'
					
				);
	
	protected $firstDay = 1;

	protected $longWeekDays = array(
					  0 => 'Domingo'
					, 1 => 'Lunes'
					, 2 => 'Martes'
					, 3 => 'Miercoles'
					, 4 => 'Jueves'
					, 5 => 'Viernes'
					, 6 => 'Sabado'
				);

	/* Atributos para datetimepicker jquery */
	protected $jqueryFormat 	= "dd-mm-yy";
	protected $weekHeader 		= "Sm";
	protected $timeTitle		= "Escoja el momento";
	protected $currentTextTime	= "Ahora";
	protected $currentText		= "Hoy";
	protected $closeText		= "Cerrar";
	protected $timeText			= "Momento";
	protected $hourText			= "Hora";
	protected $minuteText		= "Minutos";
	protected $secondText		= "Segundos";
	
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
