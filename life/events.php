<?php
date_default_timezone_set("America/Los_Angeles");
	
class Events {
	private $_eventsFilename = NULL;
	private $_phasesFilename = NULL;
	
	private $_eventsDict = NULL;
	private $_weekDict = NULL;
	private $_phasesDict = NULL;
	
	private function _contentsOfFile($filename) {
		$file = fopen($filename, "r");
		$fileContents = fread($file, filesize($filename));
		fclose($file);
		
		return $fileContents;
	}
	
	private function _eventsDict() {
		if ($this->_eventsDict == NULL) {
			$contents = $this->_contentsOfFile($this->_eventsFilename);
			$this->_eventsDict = json_decode($contents, true);
		}
		
		return $this->_eventsDict;
	}
	
	private function _phasesDict() {
		if ($this->_phasesDict == NULL) {
			$contents = $this->_contentsOfFile($this->_phasesFilename);
			$this->_phasesDict = json_decode($contents, true);
		}
		
		return $this->_phasesDict;
	}
	
	public function __construct($eventsFilename = "events/dates.json", $phasesFilename = "events/phases.json") {
		$this->_eventsFilename = $eventsFilename;
		$this->_phasesFilename = $phasesFilename;
	}
	
	public function keyedWeekDictionary($startDate) {
		if ($this->_weekDict == NULL) {
			$rawEventsDict = $this->_eventsDict();
			
			// Key based on Week No => Event
			$this->_weekDict = array();
			foreach ($rawEventsDict as $rawDate => $event) {
				$date = new DateTime($rawDate);
			
				// Compute number of weeks since startDate
				$diff = $date->diff($startDate);
				$numberOfWeeks = $diff->days / 7;
			
				if ($this->_weekDict[$numberOfWeeks]) {
					array_push($this->_weekDict[$numberOfWeeks], $event);
				} else {
					$this->_weekDict[$numberOfWeeks] = array($event);
				}
			}
		}
		
		return $this->_weekDict;
	}
	
	public function eventsForYear($year) {
		$yearDT = new DateTime();
		$yearDT->setDate($year, 1, 1);
		
		$events = array();
		foreach ($this->_eventsDict() as $rawDate => $event) {
			$date = new DateTime($rawDate);
			
			$diff = $yearDT->diff($date);
			if ($diff->invert == 0 && $diff->y < 1) {
				$event["date"] = $date;
				array_push($events, $event);
			}
		}
		
		return $events;
	}
	
	public function phasesDuringDate($date) {
		$phasesDuringDate = array();
		
		$dateTimestamp = $date->getTimestamp();
		$phases = $this->_phasesDict();
		foreach ($phases as $phase) {
			$startDate = new DateTime($phase["start"]);
			$endDate = new DateTime($phase["end"]);
			
			if ( ($dateTimestamp > $startDate->getTimestamp()) && ($dateTimestamp < $endDate->getTimestamp()) ) {
				array_push($phasesDuringDate, $phase);
			}
		}
		
		return $phasesDuringDate;
	}
}

?>