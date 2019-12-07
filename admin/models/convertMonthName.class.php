<?php

class convertMonthName{

	public function shortnames ($monthname){

		$english_month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$french_month = array('jan', 'fev', 'mar', 'avr', 'mai', 'juin', 'juil', 'aout', 'sep', 'oct', 'nov', 'déc');
		
		$monthname = str_replace($english_month, $french_month, $monthname);

		return $monthname;

	}


	public function longnames ($monthname){

		$english_month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$french_month = array('janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'décembre');
		
		$monthname = str_replace($english_month, $french_month, $monthname);

		return $monthname;

	}
}