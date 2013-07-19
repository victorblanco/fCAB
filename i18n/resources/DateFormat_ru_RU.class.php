<?



class DateFormat_ru_RU extends DateFormat {

	protected $shortMonths = array(
					  1 => 'Янв'
					, 2 => 'Фев'
					, 3 => 'Мар'
					, 4 => 'Апр'
					, 5 => 'Май'
					, 6 => 'Июн'
					, 7 => 'Июл'
					, 8 => 'Авг'
					, 9 => 'Сен'
					, 10 => 'Окт'
					, 11 => 'Ноя'
					, 12 => 'Дек'
				);

	protected $longMonths = array(
					  1 => 'Январь'
					, 2 => 'Февраль'
					, 3 => 'Март'
					, 4 => 'Апрель'
					, 5 => 'Май'
					, 6 => 'Июнь'
					, 7 => 'Июль'
					, 8 => 'Август'
					, 9 => 'Сентябрь'
					, 10 => 'Октябрь'
					, 11 => 'Ноябрь'
					, 12 => 'Декабрь'
				);

	protected $shortWeekDays = array(
					  0 => 'Вс.'
					, 1 => 'Пн.'
					, 2 => 'Вт.'
					, 3 => 'Ср.'
					, 4 => 'Чт.'
					, 5 => 'Пт.'
					, 6 => 'Сб.'
				);

	protected $longWeekDays = array(
					  0 => 'Воскресенье'
					, 1 => 'Понедельник'
					, 2 => 'Вторник'
					, 3 => 'Среда'
					, 4 => 'Четверг'
					, 5 => 'Пятница'
					, 6 => 'Суббота'
				);

	protected $dateFormats = array(
				  self::DATE_FORMAT_DEFAULT	=> '%d %b %Y'
				, self::DATE_FORMAT_SHORT	=> '%d.%M.%Y'
				, self::DATE_FORMAT_MEDIUM	=> '%d %b %Y'
				, self::DATE_FORMAT_LONG	=> '%d %B %Y'
				, self::DATE_FORMAT_FULL	=> '%W, %d %B %Y'
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
