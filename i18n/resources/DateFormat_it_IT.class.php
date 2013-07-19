<?


class DateFormat_it_IT extends DateFormat {

	protected $shortMonths = array(
					  1 => 'Gen'
					, 2 => 'Feb'
					, 3 => 'Mar'
					, 4 => 'Apr'
					, 5 => 'Mag'
					, 6 => 'Giu'
					, 7 => 'Lug'
					, 8 => 'Ago'
					, 9 => 'Set'
					, 10 => 'Ott'
					, 11 => 'Nov'
					, 12 => 'Dic'
				);

	protected $longMonths = array(
					  1 => 'Gennaio'
					, 2 => 'Febbraio'
					, 3 => 'Marzo'
					, 4 => 'Aprile'
					, 5 => 'Maggio'
					, 6 => 'Giugno'
					, 7 => 'Luglio'
					, 8 => 'Agosto'
					, 9 => 'Settembre'
					, 10 => 'Ottobre'
					, 11 => 'Novembre'
					, 12 => 'Dicembre'
				);

	protected $shortWeekDays = array(
					  0 => 'Lun'
					, 1 => 'Mar'
					, 2 => 'Mer'
					, 3 => 'Gio'
					, 4 => 'Ven'
					, 5 => 'Sab'
					, 6 => 'Dom'
				);
	protected $minWeekDays = array(
					  0 => 'D'
					, 1 => 'L'
					, 2 => 'M'
					, 3 => 'M'
					, 4 => 'G'
					, 5 => 'V'
					, 6 => 'S'
					
				);
	
	protected $firstDay = 1;

	protected $longWeekDays = array(
					  0 => 'Lunedi'
					, 1 => 'Martedi'
					, 2 => 'Mercoledi'
					, 3 => 'Giovedi'
					, 4 => 'Venerdi'
					, 5 => 'Sabato'
					, 6 => 'Domenica'
				);
				
	/* Atributos para datetimepicker jquery */
	protected $jqueryFormat 	= "dd-mm-yy";
	protected $weekHeader 		= "St";
	protected $timeTitle		= "Scelga il momento";
	protected $currentTextTime	= "Ora";
	protected $currentText		= "Oggi";
	protected $closeText		= "Chiudi";
	protected $timeText			= "Momento";
	protected $hourText			= "Ora";
	protected $minuteText		= "Minuti";
	protected $secondText		= "Secondi";

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
