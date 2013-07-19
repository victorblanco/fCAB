<?



class DateFormat_ru_RU extends DateFormat {

	protected $shortMonths = array(
					  1 => '���'
					, 2 => '���'
					, 3 => '���'
					, 4 => '���'
					, 5 => '���'
					, 6 => '���'
					, 7 => '���'
					, 8 => '���'
					, 9 => '���'
					, 10 => '���'
					, 11 => '���'
					, 12 => '���'
				);

	protected $longMonths = array(
					  1 => '������'
					, 2 => '�������'
					, 3 => '����'
					, 4 => '������'
					, 5 => '���'
					, 6 => '����'
					, 7 => '����'
					, 8 => '������'
					, 9 => '��������'
					, 10 => '�������'
					, 11 => '������'
					, 12 => '�������'
				);

	protected $shortWeekDays = array(
					  0 => '��.'
					, 1 => '��.'
					, 2 => '��.'
					, 3 => '��.'
					, 4 => '��.'
					, 5 => '��.'
					, 6 => '��.'
				);

	protected $longWeekDays = array(
					  0 => '�����������'
					, 1 => '�����������'
					, 2 => '�������'
					, 3 => '�����'
					, 4 => '�������'
					, 5 => '�������'
					, 6 => '�������'
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
