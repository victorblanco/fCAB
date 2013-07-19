<?php


/**
 * This class provides formatting methods for Date objects.
 *
 * @package php
 * @subpackage i18n
 */
class DateFormat extends DateFormatFactory {

	const DATE_FORMAT_DEFAULT		= 0;
	const DATE_FORMAT_SHORT			= 1;
	const DATE_FORMAT_MEDIUM		= 2;
	const DATE_FORMAT_LONG			= 3;
	const DATE_FORMAT_FULL			= 4;
	const DATE_FORMAT_SQL			= 5;
	const DATE_FORMAT_SQL_FULL  	= 6;
	const DATE_FORMAT_FULL_TIME 	= 7;
	const DATE_FORMAT_MEDIUM_TIME 	= 8;

	const TIME_FORMAT_DEFAULT		= 0;
	const TIME_FORMAT_SHORT			= 1;
	const TIME_FORMAT_LONG			= 2;
	const TIME_FORMAT_FULL			= 3;
	const TIME_FORMAT_SQL			= 4;

	/**
	 * Default DateFormat Instance
	 */
	protected static $default = null;

	/**
	 * Date Formatting Settings
	 */
	protected $dateFormats = array();

	/**
	 * Time Formatting Settings
	 */
	protected $timeFormats = array();

	/**
 	 * Formats a Date object to print localized date
	 *
	 * @param Date $date
	 * @param $format The format to use. Optional, DATE_FORMAT_DEFAULT is used if not provided.
	 */
	public function date( Date $date, $format=self::DATE_FORMAT_DEFAULT ) {
		if ( !isset( $this->dateFormats[$format] ) ) {
			throw new Exception( sprintf( 'Unrecognized Date Format "%s"', $format ) );
		}
		$str = $this->dateFormats[$format];
		if ( preg_match_all( '(%[aAbBdDmMWYHISZ]{1})', $str, $matches ) ) {
			foreach( $matches[0] as $match ) {
				$str = str_replace( $match, $this->replaceDateSymbol( $date, $match ), $str );
			}
		}
		return $str;
	}

	/**
	 * Formats a Date object to print localized time
	 *
	 * @param Date $date
	 * @param $format The format to use. Optional, DATE_FORMAT_DEFAULT is used if not provided.
	 */
	public function time( Date $date, $format=self::TIME_FORMAT_DEFAULT ) {
		if ( !isset( $this->timeFormats[$format] ) ) {
			throw new Exception( sprintf( 'Unrecognized Time Format "%s"', $format ) );
		}
		$str = $this->timeFormats[$format];
		if ( preg_match_all( '(%[HISZ]{1})', $str, $matches ) ) {
			foreach( $matches[0] as $match ) {
				$str = str_replace( $match, $this->replaceDateSymbol( $date, $match ), $str );
			}
		}
		return $str;
	}

	/**
	 * Gets the month name (short version)
	 *
	 * @return string
 	 */
	public function mon( $m ) {
		return $this->shortMonths[(int)$m];;
	}

	/**
	 * Gets the month name (long version)
	 *
	 * @return string
 	 */
	public function month( $m ) {
		return $this->longMonths[(int)$m];
	}

	/**
	 * Gets the weekday name (long version)
	 *
	 * @return string
 	 */
	public function weekday( $d ) {
		return $this->longWeekDays[(int)$d];
	}
	/**
	 * Gets the weekday name (short version)
	 * 
	 * @return string
 	 */
	public function wday( $d ) {
		return $this->shortWeekDays[(int)$d];
	}

	/**
	 * Replaces the matching character $match in the provided $date object
	 *
	 * @param Date $date
	 * @param string $match
	 */
	private function replaceDateSymbol( Date $date, $match ) {
		switch( $match ) {
			case '%a':	return $this->wday( $date->weekday );
			case '%A':	return $this->weekday( $date->weekday );
			case '%b':	return $this->mon( $date->month );
			case '%B':	return $this->month( $date->month );
			case '%d':	return $date->day;
			case '%D':	return sprintf( '%02d', $date->day );
			case '%m':	return $date->month;
			case '%M':	return sprintf( '%02d', $date->month );
			case '%H':	return sprintf( '%02d',$date->hours);
			case '%I':	return sprintf( '%02d',$date->minutes);
			case '%S': 	return sprintf( '%02d',$date->seconds);
			case '%W':	return $date->weekyear;
			case '%Y':	return $date->year;
			case '%Z':	return $date->tz;
		}
	}

}
