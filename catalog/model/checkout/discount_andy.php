<?php
class ModelCheckoutDiscountAndy extends Model {
	public function getDiscount_andy() {
		$status = true;
		
		$discount_andy_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "discount_andy WHERE total IN (SELECT MAX(total) FROM " . DB_PREFIX . "discount_andy WHERE ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND status =1  AND total<=".$this->cart->getSubTotal().")");
			
		if ($discount_andy_query->num_rows) {
			if ($discount_andy_query->row['total'] > $this->cart->getSubTotal()) {
				$status = false;
			}
		
			$discount_andy_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "discount_andy_history` ch WHERE ch.discount_andy_id = '" . (int)$discount_andy_query->row['discount_andy_id'] . "'");

			if ($discount_andy_query->row['uses_total'] > 0 && ($discount_andy_history_query->row['total'] >= $discount_andy_query->row['uses_total'])) {
				$status = false;
			}
			
			if ($discount_andy_query->row['logged'] && !$this->customer->getId()) {
				$status = false;
			}
			
			if ($this->customer->getId()) 
			{
				$discount_andy_history_query = $this->db->query("SELECT discount_andy_id AS ID FROM `" . DB_PREFIX . "discount_andy` ch WHERE ch.discount_andy_id = '" . (int)$discount_andy_query->row['discount_andy_id'] . "' AND FIND_IN_SET(".$this->customer->getCustomerGroupId().", groups_id )>0");
				
				if ($discount_andy_history_query->num_rows==0) 
				{
					$status = false;
				}
				//echo $discount_andy_history_query->num_rows;
				//exit;
			}
			
			
			if ($this->customer->getId()) {
				$discount_andy_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "discount_andy_history` ch WHERE ch.discount_andy_id = '" . (int)$discount_andy_query->row['discount_andy_id'] . "' AND ch.customer_id = '" . (int)$this->customer->getId() . "'");
				
				if ($discount_andy_query->row['uses_customer'] > 0 && ($discount_andy_history_query->row['total'] >= $discount_andy_query->row['uses_customer'])) {
					$status = false;
				}
			}
				
			$discount_andy_product_data = array();
				
			$discount_andy_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "discount_andy_product WHERE discount_andy_id = '" . (int)$discount_andy_query->row['discount_andy_id'] . "'");

			foreach ($discount_andy_product_query->rows as $result) {
				$discount_andy_product_data[] = $result['product_id'];
			}
				
			if ($discount_andy_product_data) {
				$discount_andy_product = false;
					
				foreach ($this->cart->getProducts() as $product) {
					if (in_array($product['product_id'], $discount_andy_product_data)) {
						$discount_andy_product = true;
							
						break;
					}
				}
					
				if (!$discount_andy_product) {
					$status = false;
				}
			}
		} else {
			$status = false;
		}
		
		if ($status) {
			return array(
				'discount_andy_id'     => $discount_andy_query->row['discount_andy_id'],
				'name'          => $discount_andy_query->row['name'],
				'type'          => $discount_andy_query->row['type'],
				'discount'      => $discount_andy_query->row['discount'],
				'shipping'      => $discount_andy_query->row['shipping'],
				'total'         => $discount_andy_query->row['total'],
				'product'       => $discount_andy_product_data,
				'date_start'    => $discount_andy_query->row['date_start'],
				'date_end'      => $discount_andy_query->row['date_end'],
				'uses_total'    => $discount_andy_query->row['uses_total'],
				'uses_customer' => $discount_andy_query->row['uses_customer'],
				'status'        => $discount_andy_query->row['status'],
				'date_added'    => $discount_andy_query->row['date_added']
			);
		}
	}
	
	public function redeem($discount_andy_id, $order_id, $customer_id, $amount) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "discount_andy_history` SET discount_andy_id = '" . (int)$discount_andy_id . "', order_id = '" . (int)$order_id . "', customer_id = '" . (int)$customer_id . "', amount = '" . (float)$amount . "', date_added = NOW()");
	}
}
?>