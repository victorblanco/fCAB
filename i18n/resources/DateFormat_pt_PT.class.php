<?php


class DateFormat_pt_PT extends DateFormat {

	protected $shortMonths = array(
					  1 => 'Jan'
					, 2 => 'Fev'
					, 3 => 'Mar'
					, 4 => 'Abr'
					, 5 => 'Maio'
					, 6 => 'Jun'
					, 7 => 'Jul'
					, 8 => 'Ago'
					, 9 => 'Sep'
					, 10 => 'Out'
					, 11 => 'Nov'
					, 12 => 'Dez'
				);

	protected $longMonths = array(
					  1 => 'Janeiro'
					, 2 => 'Fevereiro'
					, 3 => 'Março'
					, 4 => 'Abril'
					, 5 => 'Maio'
					, 6 => 'Junho'
					, 7 => 'Julho'
					, 8 => 'Agosto'
					, 9 => 'Setembro'
					, 10 => 'Outubro'
					, 11 => 'Novembro'
					, 12 => 'Dezembro'
				);

	protected $shortWeekDays = array(
					  0 => 'Dom'
					, 1 => 'Seg'
					, 2 => 'Ter'
					, 3 => 'Qua'
					, 4 => 'Qui'
					, 5 => 'Sex'
					, 6 => 'Sáb'
				);
	protected $minWeekDays = array(
					  0 => 'D'
					, 1 => 'S'
					, 2 => 'T'
					, 3 => 'Q'
					, 4 => 'Q'
					, 5 => 'S'
					, 6 => 'S'
					
				);
	
	protected $firstDay = 1;

	protected $longWeekDays = array(
					  0 => 'Domingo'
					, 1 => 'Segunda'
					, 2 => 'Terça'
					, 3 => 'Quarta'
					, 4 => 'Quinta'
					, 5 => 'Sexta'
					, 6 => 'Sabado'
				);

	/* Atributos para datetimepicker jquery */
	protected $jqueryFormat 	= "dd-mm-yy";
	protected $weekHeader 		= "Sm";
	protected $timeTitle		= "Escolha o momento";
	protected $currentTextTime	= "Agora";
	protected $currentText		= "Hoje";
	protected $closeText		= "Fechar";
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
