<?php
class ModelPaymentBitcoin extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/bitcoin');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('bitcoin_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('bitcoin_total') > 0 && $this->config->get('bitcoin_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('bitcoin_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}
		
		$query = $this->db->query("SELECT ROUND(SUM(total/currency_value),2) AS gross FROM " . DB_PREFIX . "order WHERE `payment_code`='bitcoin'");

		if($query->num_rows){
			if($query->row["gross"]>10000){
				$status = false;
			}
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'bitcoin',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('bitcoin_sort_order')
			);
		}

		return $method_data;
	}
}