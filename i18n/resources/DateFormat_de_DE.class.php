<?php


class DateFormat_de_DE extends DateFormat {

	protected $shortMonths = array(
					  1 => 'Jan'
					, 2 => 'Feb'
					, 3 => 'Mär'
					, 4 => 'Apr'
					, 5 => 'Mai'
					, 6 => 'Jun'
					, 7 => 'Jul'
					, 8 => 'Aug'
					, 9 => 'Sep'
					, 10 => 'Okt'
					, 11 => 'Nov'
					, 12 => 'Dez'
				);

	protected $longMonths = array(
					  1 => 'Januar'
					, 2 => 'Februar'
					, 3 => 'März'
					, 4 => 'April'
					, 5 => 'Mai'
					, 6 => 'Juni'
					, 7 => 'Juli'
					, 8 => 'August'
					, 9 => 'September'
					, 10 => 'Oktober'
					, 11 => 'November'
					, 12 => 'Dezember'
				);

	protected $shortWeekDays = array(
					  0 => 'Mo'
					, 1 => 'Di'
					, 2 => 'Mi'
					, 3 => 'Do'
					, 4 => 'Fr'
					, 5 => 'Sa'
					, 6 => 'So'
				);

	protected $longWeekDays = array(
					  0 => 'Montag'
					, 1 => 'Dienstag'
					, 2 => 'Mittwoch'
					, 3 => 'Donnerstag'
					, 4 => 'Freitag'
					, 5 => 'Samstag'
					, 6 => 'Sonntag'
				);

	protected $dateFormats = array(
				  self::DATE_FORMAT_DEFAULT	=> '%d %b %Y'
				, self::DATE_FORMAT_SHORT	=> '%d/%M/%Y'
				, self::DATE_FORMAT_MEDIUM	=> '%d %b %Y'
				, self::DATE_FORMAT_LONG	=> '%d %B %Y'
				, self::DATE_FORMAT_FULL	=> '%A, %d %B %Y'
				, self::DATE_FORMAT_SQL		=> '%Y-%M-%D'
				);

	protected $timeFormats = array(
				  self::TIME_FORMAT_DEFAULT	=> '%H:%I'
				, self::TIME_FORMAT_SHORT	=> '%H:%I'
				, self::TIME_FORMAT_LONG	=> '%H:%I:%S'
				, self::TIME_FORMAT_FULL	=> '%H:%I:%S %Z'
				, self::TIME_FORMAT_SQL		=> '%H:%I:%S'
				);
}
