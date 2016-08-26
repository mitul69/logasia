<?php

namespace TransportBundle\Util;

class Validater {
	function validateDate($date) {
		$d = \DateTime::createFromFormat ( 'Y-m-d', $date );
		return $d && $d->format ( 'Y-m-d' ) === $date;
	}
	function validateForm($data) {
		if (! isset ( $data ['category'] )) {
			return "Please select category";
		}
		if (! isset ( $data ['fromDate'] ) || ! $this->validateDate ( $data ['fromDate'] )) {
			return "Invalid from Date";
		}
		if (! isset ( $data ['toDate'] ) || ! $this->validateDate ( $data ['toDate'] )) {
			return "Invalid to Date";
		}
		
		if (! isset ( $data ['price'] ) && ! isset ( $data ['availibility'] )) {
			return "Please enter value for price or availibility";
		} else if ( $data ['availibility'] == "" && $data ['price'] == "") {
			return "Please enter value for price or availibility" ;
		}
		
		$daysSelected = false;
		$days = array (
				"sundays", "mondays", "tuesdays", "wednnesdays", "thursdays", "fridays", "saturdays", "weekDays", "weekends", "allDays" 
				);
		foreach ( $days as $day ) {
			if (isset ( $data [$day] ) && $data [$day]) {
				$daysSelected = true;
			}
		}
		if (! $daysSelected) {
			return "Please select Refine days ";
		}
		return true;
	}
	public static function validateSaveDate($data, $date) {
		
		$days = array (
				"Sun" => "sundays",
				"Mon" => "mondays",
				"Tue" => "tuesdays",
				"Wed" => "wednnesdays",
				"Thu" => "thursdays",
				"Fri" => "fridays",
				"Sat" => "saturdays"
		);
		if(isset($data[$days[$date->format("D")]]) && isset($data[$days[$date->format("D")]])){
			 return true;
		}
		
		if (isset ( $data ['allDays'] ) && $data ['allDays']) {
			return true;
		}
		if (isset ( $data ['weekDays'] ) && $data ['weekDays']) {
			if($date->format("D") != 'Sun' && $date->format("D") != 'Sat'){
				return true;	
			}
		}
		
		if (isset ( $data ['weekends'] ) && $data ['weekends']) {
			if($date->format("D") == 'Sun' || $date->format("D") == 'Sat'){
				return true;
			}
		}
		return false;
	}
}

