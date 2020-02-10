<?php
class ControllerPaymentBitcoin extends Controller {
	public function index() {
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		//$this->data['continue'] = $this->url->link('checkout/success');

		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		if($order_info){
			$this->data["MerchantId"] = $this->config->get('bitcoin_merchant_id');
			$bcCurrency = $this->config->get('bitcoin_currency');
			$bcCurrencyValue = $this->currency->getValue($bcCurrency);
			$this->data["TxnModel"] = "01";
			$this->data["RefNo"] = $this->session->data['order_id'];
			$this->data["TxnCur"] = $order_info['currency_code'];
			$totalAmount = $this->currency->convert($order_info['total'], $order_info['currency_code'], $bcCurrency);
			$total = $this->currency->format($order_info['total'], $bcCurrency, $bcCurrencyValue, false);
			$this->data["TxnAmt"] = $total;
			$Custname = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8')." ".html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
			$this->data["CustName"] = $Custname;
			$this->data["CustEmail"] = $order_info['email'];
			$this->data["Version"] = "1.00";
			$this->data["ResponseURL"] = $this->url->link('checkout/success');
			$this->data["BackgroundURL"] = $this->url->link('payment/bitcoin/callback', '', 'SSL');
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/bitcoin.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/bitcoin.tpl';
			} else {
				$this->template = 'default/template/payment/bitcoin.tpl';
			}
			$this->render();
		}
	}

	public function callback() {
		require_once dirname(__FILE__)."/aes_small.php";
		require_once dirname(__FILE__)."/cryptoHelpers.php";
		if(isset($_REQUEST['callback'])){
			 $aes_key = $this->config->get('bitcoin_merchant_key'); ;
			 $aes_vector = $this->config->get('bitcoin_merchant_vector'); ;
			 $encrypted_base64Data = $_REQUEST['callback'];
			 $encrypted_base64Data = str_replace(" ", "+", $encrypted_base64Data);
			 $this->log->write('BitCoin Payment Server Response :::: Complete Response :: '.$encrypted_base64Data);
			 $aes = new AES(); //Instantiate the AES class
			 $ch = new cryptoHelpers(); //instantiate the cryptoHelper class
			 $cipherIn= $ch->base64_decode($encrypted_base64Data); //decode data
			 $originalsize = sizeof($cipherIn) + 32; //compute original size by adding 32 to the cipherIn array
			 $key = $ch->base64_decode($aes_key); //decode the key using the crypto helper
			 $iv = $ch->base64_decode($aes_vector); //decode the vextor using crypto helper
			 $decrypt = $aes->decrypt($cipherIn,$originalsize,2,$key,32,$iv); //decrypt with the above found information
			 $json = $ch->convertByteArrayToString($decrypt); //convert array to json string
			 //additional step to filter some characters that are appended by AES.
			 $last_index = strripos($json,'}') + 1;
			 $json = substr($json, 0, $last_index );
			 $this->data = json_decode($json,true);
			 if($this->data && isset($this->data["Reference"])){
			 	$order_id = $this->data["Reference"];
				$this->load->model('checkout/order');
				$order_info = $this->model_checkout_order->getOrder($order_id);
			 	if($this->data['Confirmations'] == 0) {
			 		$order_status_id = $this->config->get('bitcoin_order_status_success_id');
					$this->model_checkout_order->confirm($order_id, $order_status_id);
				}else{
					$order_status_id = $this->config->get('bitcoin_order_status_fail_id');
					$this->model_checkout_order->update($order_id, $order_status_id);
				}
			 }else{
			 	$order_id = 0;
			 }
			 $this->log->write('BitCoin Payment Server Response :: Order ID :: '.$order_id.' :: Complete Response :: '.json_encode($json));
		}
	}
}