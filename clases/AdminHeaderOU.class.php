<?php


class AdminHeaderOU extends Output{
	
	public function getOutput(){
		$tpl = new Template("admin_header.tpl");
		
		$tpl->setVar("breadcrumb",FACTORIE::getDefault()->AdminBreadCrumbOU()->getOutput());
		$this->setLocationForDatepicker($tpl);
		return $tpl->parse();
	}
	
	protected function setLocationForDatepicker($tpl){
		$date_format = DateFormatFactory::getDefault();
		//Obtengo las localizaciones para el formato de fecha actual
		$tpl->setVar("current_text",$date_format->getCurrentText())
			->setVar("close_text",$date_format->getCloseText())
			->setVar("meses","'".implode("','",$date_format->getLongMonths())."'")
			->setVar("meses_short","'".implode("','",$date_format->getShortMonths())."'")
			->setVar("dias","'".implode("','",$date_format->getShortWeekDays())."'")
			->setVar("dias_short","'".implode("','",$date_format->getShortWeekDays())."'")
			->setVar("dias_min","'".implode("','",$date_format->getMinWeekDays())."'")
			->setVar("week_header",$date_format->getWeekHeader())
			->setVar("format",$date_format->getJqueryFormat())
			->setVar("first_day",$date_format->getFirstDay())
			->setVar("current_text_time",$date_format->getCurrentTextTime())
			->setVar("time_title",$date_format->getTimeTitle())
			->setVar("time_text",$date_format->getTimeText())
			->setVar("hour_text",$date_format->getHourText())
			->setVar("minute_text",$date_format->getMinuteText())
			->setVar("second_text",$date_format->getSecondText());
				
		
		
	}
}