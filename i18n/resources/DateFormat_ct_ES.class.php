<?

class DateFormat_ct_ES extends DateFormat {

	protected  $shortMonths = array(
					  1 => 'Gen'
					, 2 => 'Feb'
					, 3 => 'Mar'
					, 4 => 'Abr'
					, 5 => 'Mai'
					, 6 => 'Jun'
					, 7 => 'Jul'
					, 8 => 'Ag'
					, 9 => 'Set'
					, 10 => 'Oct'
					, 11 => 'Nov'
					, 12 => 'Des'
				);

	public  $longMonths = array(
					  1 => 'Gener'
					, 2 => 'Febrer'
					, 3 => 'Març'
					, 4 => 'Abril'
					, 5 => 'Maig'
					, 6 => 'Juny'
					, 7 => 'Juliol'
					, 8 => 'Agost'
					, 9 => 'Setembre'
					, 10 => 'Octubre'
					, 11 => 'Novembre'
					, 12 => 'Disembre'
				);

	protected  $shortWeekDays = array(
					  0 => 'dl'
					, 1 => 'dm'
					, 2 => 'dc'
					, 3 => 'dj'
					, 4 => 'dv'
					, 5 => 'ds'
					, 6 => 'dg'
				);
	protected $minWeekDays = array(
					  0 => 'dl'
					, 1 => 'dm'
					, 2 => 'dc'
					, 3 => 'dj'
					, 4 => 'dv'
					, 5 => 'ds'
					, 6 => 'dg'
					
				);
	
	protected $firstDay = 1;

	protected  $longWeekDays = array(
					  0 => 'Dilluns'
					, 1 => 'Dimarts'
					, 2 => 'Dimecres'
					, 3 => 'Dijous'
					, 4 => 'Divendres'
					, 5 => 'Dissabte'
					, 6 => 'Diumenge'
				);
				
	/* Atributos para datetimepicker jquery */
	protected $jqueryFormat 	= "dd-mm-yy";
	protected $weekHeader 		= "Sm";
	protected $timeTitle		= "Triï el moment";
	protected $currentTextTime	= "Ara";
	protected $currentText		= "Avui";
	protected $closeText		= "Tancar";
	protected $timeText			= "Moment";
	protected $hourText			= "Hora";
	protected $minuteText		= "Minuts";
	protected $secondText		= "Segons";

	protected $dateFormats = array(
				  self::DATE_FORMAT_DEFAULT	=> '%d %b %Y'
				, self::DATE_FORMAT_SHORT	=> '%d/%M/%Y'
				, self::DATE_FORMAT_MEDIUM	=> '%d %b %Y'
				, self::DATE_FORMAT_FULL_TIME=> '%D-%M-%Y  %H:%I:%S'
				, self::DATE_FORMAT_LONG	=> '%d %B %Y'
				, self::DATE_FORMAT_FULL	=> '%W, %d %B %Y'
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
