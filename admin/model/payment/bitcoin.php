<?php
class ModelPaymentBitcoin extends Model {
	public function getOrderAmount() {
		
		$query = $this->db->query("SELECT ROUND(SUM(total/currency_value),2) AS gross FROM " . DB_PREFIX . "order WHERE `payment_code`='bitcoin'");

		if($query->num_rows){
			if($query->row["gross"]>10000){
				return true;
			} else {
				return false;
			}
		}

	}
}