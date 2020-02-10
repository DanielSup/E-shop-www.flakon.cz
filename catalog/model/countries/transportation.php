<?php
class Transportation {
	private $company;
	private $delivery_time;
	private $cost;
	private $cash_on_delivery_fee;
	public function __construct($company, $delivery_time, $cost, $cash_on_delivery_fee){
		$this->company = $company;
		$this->delivery_time = $delivery_time;
		$this->cost = $cost;
		$this->cash_on_delivery_fee = $cash_on_delivery_fee;
	}
	
	public function getCompany(){
		return $this->company;
	}
	
	public function getDeliveryTime(){
		return $this->delivery_time;
	}
	
	public function getCost(){
		return $this->cost;
	}
	
	public function getCashOnDeliveryFee(){
		return $this->cash_on_delivery_fee;
	}
}
?>