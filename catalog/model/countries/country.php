<?php
class Country{
	private $title;
	private $abbreviation;
	private $transportations = array();
	
	public function __construct($title, $abbreviation){
		$this->title = $title;
		$this->abbreviation = $abbreviation;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function getAbbreviation(){
		return $this->abbreviation;
	}
	
	public function addTransportation($transportation){
		array_push($this->transportations, $transportation);
	}
	
	public function getTransportations(){
		return $this->transportations;
	}
}
?>