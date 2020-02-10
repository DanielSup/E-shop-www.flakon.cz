<?php
class ModelTotalDiscountAndy extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if (isset($this->session->data['discount_andy'])) {
			$this->load->language('total/discount_andy');
			
			$this->load->model('checkout/discount_andy');
			 
			$discount_andy_info = $this->model_checkout_discount_andy->getDiscount_andy();
			
			if ($discount_andy_info) {
				$discount_total = 0;
				
				if (!$discount_andy_info['product']) {
					$sub_total = $this->cart->getSubTotal();
				} else {
					$sub_total = 0;
				
					foreach ($this->cart->getProducts() as $product) {
						if (in_array($product['product_id'], $discount_andy_info['product'])) {
							$sub_total += $product['total'];
						}
					}					
				}
				
				if ($discount_andy_info['type'] == 'F') {
					$discount_andy_info['discount'] = min($discount_andy_info['discount'], $sub_total);
				}
				
				foreach ($this->cart->getProducts() as $product) {
					$discount = 0;
					
					if (!$discount_andy_info['product']) {
						$status = true;
					} else {
						if (in_array($product['product_id'], $discount_andy_info['product'])) {
							$status = true;
						} else {
							$status = false;
						}
					}
					
					if ($status) {
						if ($discount_andy_info['type'] == 'F') {
							$discount = $discount_andy_info['discount'] * ($product['total'] / $sub_total);
						} elseif ($discount_andy_info['type'] == 'P') {
							$discount = $product['total'] / 100 * $discount_andy_info['discount'];
						}
				
						if ($product['tax_class_id']) {
							$tax_rates = $this->tax->getRates($product['total'] - ($product['total'] - $discount), $product['tax_class_id']);
							
							foreach ($tax_rates as $tax_rate) {
								if ($tax_rate['type'] == 'P') {
									$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								}
							}
						}
					}
					
					$discount_total += $discount;
				}
				
				if ($discount_andy_info['shipping'] && isset($this->session->data['shipping_method'])) {
					if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
						$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
						
						foreach ($tax_rates as $tax_rate) {
							if ($tax_rate['type'] == 'P') {
								$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
							}
						}
					}
					
					$discount_total += $this->session->data['shipping_method']['cost'];				
				}				
      			
				$total_data[] = array(
					'code'       => 'discount_andy',
        			//'title'      => sprintf($this->language->get('text_discount_andy'), $this->session->data['discount_andy']),
					'title'      => $this->language->get('text_discount_andy'),
	    			'text'       => $this->currency->format(-$discount_total),
        			'value'      => -$discount_total,
					'sort_order' => $this->config->get('discount_andy_sort_order')
      			);

				$total -= $discount_total;
			} 
		}
	}
	
	public function confirm($order_info, $order_total) {
		$code = '';
		
		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');
		
		if ($start && $end) {  
			$code = substr($order_total['title'], $start, $end - $start);
		}	
		
		$this->load->model('checkout/discount_andy');
		
		$discount_andy_info = $this->model_checkout_discount_andy->getDiscount_andy();
			
		if ($discount_andy_info) {
			$this->model_checkout_discount_andy->redeem($discount_andy_info['discount_andy_id'], $order_info['order_id'], $order_info['customer_id'], $order_total['value']);	
		}						
	}
}
?>