<?

class DateFormat_en_EN extends DateFormat {

	protected $shortMonths = array(
					  1 => 'Jan'
					, 2 => 'Feb'
					, 3 => 'Mar'
					, 4 => 'Apr'
					, 5 => 'May'
					, 6 => 'Jun'
					, 7 => 'Jul'
					, 8 => 'Aug'
					, 9 => 'Sep'
					, 10 => 'Oct'
					, 11 => 'Nov'
					, 12 => 'Dec'
				);

	protected $longMonths = array(
					  1 => 'January'
					, 2 => 'February'
					, 3 => 'March'
					, 4 => 'April'
					, 5 => 'May'
					, 6 => 'June'
					, 7 => 'July'
					, 8 => 'August'
					, 9 => 'September'
					, 10 => 'October'
					, 11 => 'November'
					, 12 => 'December'
				);

	protected $shortWeekDays = array(
					  0 => 'Mon'
					, 1 => 'Tue'
					, 2 => 'Wed'
					, 3 => 'Thu'
					, 4 => 'Fri'
					, 5 => 'Sat'
					, 6 => 'Sun'
				);
	protected $minWeekDays = array(
					  0 => 'M'
					, 1 => 'T'
					, 2 => 'W'
					, 3 => 'T'
					, 4 => 'F'
					, 5 => 'S'
					, 6 => 'S'
					
				);
	
	protected $firstDay = 1;

	protected $longWeekDays = array(
					  0 => 'Monday'
					, 1 => 'Tuesday'
					, 2 => 'Wednesday'
					, 3 => 'Thursday'
					, 4 => 'Friday'
					, 5 => 'Saturday'
					, 6 => 'Sunday'
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
				  self::DATE_FORMAT_DEFAULT	=> '%b %d %Y'
				, self::DATE_FORMAT_SHORT	=> '%m-%d-%Y'
				, self::DATE_FORMAT_MEDIUM	=> '%d %b %Y'
				, self::DATE_FORMAT_FULL_TIME=> '%D-%M-%Y  %H:%I:%S'
				, self::DATE_FORMAT_LONG	=> '%B %d %Y'
				, self::DATE_FORMAT_FULL	=> '%W, %B %d, %Y'
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
