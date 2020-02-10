<?php

define("BORGUN_MODULE_VERSION", "2.1.8");

$dir = realpath(dirname(__FILE__) . '/../../../borgun');
include_once "{$dir}/borgun.php";
include_once "{$dir}/borgun_opencart_1x.php";

class ControllerPaymentBorgun extends Controller
{
    protected function index()
    {
        $this->load->model('checkout/order');
        $this->load->model('payment/borgun');
        $this->language->load('payment/borgun');

        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        if ($this->config->get('borgun_sandbox')) {
            $this->data['action'] = borgun_test_defaults::$environments["test"];
        } else {
            $this->data['action'] = borgun_test_defaults::$environments["production"];
        }
        $currency = select_borgun_currency($order_info['currency_code']);

        $config = array();
        $config['environment'] = ($this->config->get('borgun_sandbox') == "1") ? borgun_test_defaults::testEnvironmentSetting : borgun_test_defaults::productionEnvironmentSetting;
        $config['pageType'] = $this->config->get('borgun_pagetype') == "1" ? true : false;
        $config['forwardCustomersName'] = $this->config->get('borgun_forwardcustomersname') == "1" ? true : false;
        $config['showAdditionalBrands'] = $this->config->get('borgun_showadditionalbrands') == "1" ? true : false;

        $secretKey = $this->config->get('borgun_secretkey_' . $currency);
        $merchantId = $this->config->get('borgun_merchantid_' . $currency);
        $paymentGatewayId = $this->config->get('borgun_paymentgatewayid_' . $currency);

        $borgun = new borgun_envelope($config, $order_info['order_id'], select_borgun_language(substr($order_info['language_code'], 0, 2)), $order_info['order_id']);
        $borgun->setCurrency($currency, $merchantId, $paymentGatewayId);
        $borgun->skipReceiptPage($this->config->get('borgun_skipreceiptpage') == "1" ? true : false);

        $urls = new borgun_return_url();
        $urls->setSuccess($this->url->link('payment/borgun/callback', '', 'SSL'));
        $urls->setSuccessServer($this->url->link('payment/borgun/ipn', '', 'SSL'));
        $urls->setCancel($this->url->link('payment/borgun/cancel', '', 'SSL'));
        $urls->setError($this->url->link('payment/borgun/cancel', '', 'SSL'));
        $borgun->setUrls($urls);

        $merchant = new borgun_merchant();
        $merchant->setLogo($this->config->get('borgun_merchantlogo'));
        $merchant->setEmail($this->config->get('borgun_merchantemail'));
        $borgun->setMerchant($merchant);

        $buyer = new borgun_buyer();
        $buyer->setAddress($order_info['payment_address_1']);
        $buyer->setCity($order_info['payment_city']);
        if (isset($order_info['comment'])) {
            $buyer->setComment($order_info['comment']);
        }
        $buyer->setCountry($order_info['payment_iso_code_2']);
        $buyer->setEmail($order_info['email']);
        $buyer->setName($order_info['payment_firstname'] . ' ' . $order_info['payment_lastname']);
        if (isset($order_info['telephone'])) {
            $buyer->setPhone($order_info['telephone']);
        }
        if ($this->customer->isLogged()) {
            $buyer->setReferral($this->customer->getId());
        }
        if (isset($order_info['payment_postcode'])) {
            $buyer->setZip($order_info['payment_postcode']);
        }
        $borgun->setBuyer($buyer);

        $order_price_currecny = $this->currency->format($order_info['total'], '', '', false);

        if ($this->config->get('borgun_sendtotalonly') != "1") {
            $products = $this->cart->getProducts();
            $products_to_discount = array();
            foreach ($products as $product) {
                $product_price_with_tax = $this->tax->calculate($product['price'], $product['tax_class_id'], 1);
                $product_price_currecny = $this->currency->format($product_price_with_tax, '', '', false);
                $products_to_discount[$product["product_id"]] = $product_price_currecny * $product['quantity'];
                $item = new borgun_item($product['name'], $product_price_currecny, $product['quantity']);
                $borgun->addItem($item);
            }
            if ((isset($this->session->data['coupon'])) and ( $this->session->data['coupon'] != "")) {
                $coupon_info = $this->model_checkout_coupon->getCoupon($this->session->data['coupon']);
                $amount_to_discount = 0;
                if ((isset($coupon_info['product'])) and ( count($coupon_info['product']) > 0) and ( count($products_to_discount) > 0)) {
                    foreach ($coupon_info['product'] as $pid) {
                        $amount_to_discount = $amount_to_discount + $products_to_discount[$pid];
                    }
                } else {
                    $amount_to_discount = $borgun->getAmount();
                }
                $discount = $coupon_info["type"] == "P" ? ($amount_to_discount * $coupon_info["discount"] / 100) : $this->currency->format($coupon_info["discount"], '', '', false);
                if ($discount > 0) {
                    $singleValue = ($discount * -1);
                    $item = new borgun_item("Coupon ({$coupon_info['code']})", $singleValue);
                    $borgun->addItem($item);
                }
            }
            if (isset($this->session->data['shipping_method'])) {
                $shipping_price_with_tax = $this->tax->calculate($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id'], 1);
                $shipping_price_currecny = $this->currency->format($shipping_price_with_tax, '', '', false);
                if ($shipping_price_currecny > 0) {
                    $item = new borgun_item($this->session->data['shipping_method']['title'], $shipping_price_currecny);
                    $borgun->addItem($item);
                }
            }
        } else {
            $item = new borgun_item($this->language->get('text_ordered_items_total'), $order_price_currecny);
            $borgun->addItem($item);
        }
        
        $borgun->setAmount($order_price_currecny);
        $borgun->calculateHash($secretKey);

        $this->data = array_merge($this->data, $borgun->get());
        $this->data['borgun'] = $this->data;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/borgun.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/borgun.tpl';
        } else {
            $this->template = 'default/template/payment/borgun.tpl';
        }

        $this->render();
    }

// end index

    public function callback()
    {

        /*
          Array
          (
          [orderid] => ORDER123
          [orderhash] => adde1169af4a630d0db55d114c90052c
          [authorizationcode] => 123456
          [creditcardnumber] => 450728******3760
          [customField] =>
          [ticket] =>
          [buyername] => Teszt Elek
          [buyeraddress] =>
          [buyerzip] =>
          [buyercity] =>
          [buyercountry] =>
          [buyerphone] =>
          [buyeremail] => tesztelek@b-payment.hu
          [buyerreferral] =>
          [buyercomment] =>
          [status] => OK
          [step] => Confirmation
          )
         */

        /*
          if($borgun_data['status'] == 'ERROR'){
          $this->log->write('BORGUN ERROR - '. $borgun_data['errordescription']);
          $this->session->data['success'] = 'BORGUN ERROR - '. $borgun_data['errordescription'];
          $this->redirect($this->url->link('checkout/cart'));
          }
         */

        $this->language->load('payment/borgun');
        $this->load->model('checkout/order');
//        $this->load->language('localisation/currency');
        $this->load->model('localisation/currency');


        $confirmation = new borgun_response($this->request->post);
        $environment = $this->config->get('borgun_sandbox') == "1" ? borgun_test_defaults::testEnvironmentSetting : borgun_test_defaults::productionEnvironmentSetting;

        $confirmation = new borgun_response($this->request->post);
        $order = $this->model_checkout_order->getOrder($confirmation->getOrderId());
        $currency = $this->model_localisation_currency->getCurrencyByCode($order['currency_code']);
        $confirmation->setEnvironment($environment);
        $confirmation->setCurrency($currency['code']);

        $order_total = $this->currency->convert($order['total'], $this->config->get('config_currency'), $currency['code']);
        if ($currency['decimal_place'] == 0) {
            $confirmation->setAmount(format($order_total, $currency));
        } else {
            $confirmation->setAmount(sprintf("%01.2f", $order_total));
        }
        $secretKey = $this->config->get('borgun_secretkey_' . $order['currency_code']);
        $secretKey = is_null($secretKey) ? borgun_test_defaults::secretKey : $secretKey;
        $checkhash = $confirmation->checkHash($secretKey);
        if (($confirmation->getStatus() == borgun_response::StatusOK) and ( $checkhash)) {
            $this->model_checkout_order->confirm($confirmation->getOrderId(), $this->config->get('borgun_pending_status_id'));
            if ($this->config->get('skipreceiptpage') == "1") {
                $comment = $this->language->get('text_borgun_status') . " " . $confirmation->getStatus() . "\n" .
                        $this->language->get('text_borgun_authorizationcode') . " " . $confirmation->getAuthorizationCode() . "\n" .
                        $this->language->get('text_borgun_creditcardnumber') . " " . $confirmation->getCreditCardNumber();
//                $this->log->write('Borgun IPN Order ID: ' . $confirmation->getOrderId());
//                $this->log->write('Borgun IPN Comment: ' . $comment);
                $this->model_checkout_order->addOrderHistory($confirmation->getOrderId(), $this->config->get('borgun_completed_status_id'), $comment, true);
            }
            $this->session->data['borgun_authorizationcode'] = $confirmation->getAuthorizationCode();
            $this->redirect($this->url->link('checkout/borgun_success'));
        } else {
            $this->log->write('BORGUN CALLBACK ERROR - The session->data[order_id] does not exist.');
            $this->session->data['success'] = 'BORGUN CALLBACK ERROR - The session->data[order_id] does not exist';
            $this->redirect($this->url->link('checkout/cart'));
        }

//
//        $order_status_id = $this->config->get('borgun_pending_status_id');
//        $this->model_checkout_order->confirm($order_id, $order_status_id);
//        $this->load->model('payment/borgun');
//
//        if ($borgun_data['status'] == 'OK') {
//            if ($this->config->get('skipreceiptpage') == "1") {
//                
//            }
//            $this->session->data['borgun_authorizationcode'] = $borgun_data['authorizationcode'];
//            $this->redirect($this->url->link('checkout/borgun_success'));
//        } else {
//            $comment = $this->language->get('text_borgun_authorizationcode') . $borgun_data['authorizationcode'] . "\n" .
//                    $this->language->get('text_borgun_status') . $borgun_data['status'];
//
//            $order_status_id = $this->config->get('borgun_failed_status_id');
//            $this->model_checkout_order->update($order_id, $order_status_id, $comment, true);
//            $this->redirect($this->url->link('checkout/borgun_failure'));
//        }
//        } else {
//            echo 'BORGUN CALLBACK ERROR - Can not query data in the orders. Not sending email, or not update orders status. This order_id: ' . $order_id;
//            $this->log->write('BORGUN CALLBACK ERROR - Can not query data in the orders. Not sending email, or not update orders status. This order_id: ' . $order_id);
//        }
    }

// end callback

    public function cancel()
    {

        $borgun_data = $this->request->post;

        $this->language->load('payment/borgun');

        if (isset($this->session->data['order_id'])) {
            $order_id = $this->session->data['order_id'];
        } else {
            $order_id = 0;
            $this->log->write('BORGUN ERROR - The BORGUN orderid does not exist. Borgun Request: ' . serialize($borgun_data));
        }

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);

        if ($order_info) {
            $order_status_id = $this->config->get('borgun_pending_status_id');
            $this->model_checkout_order->confirm($order_id, $order_status_id);

            $comment = $this->language->get('text_borgun_status') . $borgun_data['status'];
            $order_status_id = $this->config->get('borgun_canceled_status_id');
            $this->model_checkout_order->update($order_id, $order_status_id, $comment, true);
            $this->redirect($this->url->link('checkout/borgun_failure'));
        } else {
            echo 'BORGUN ERROR - Can not query data in the orders. Not sending email, or not update orders status.';
            $this->log->write('BORGUN ERROR - Can not query data in the orders. Not sending email, or not update orders status.');
        }
    }

// end cancel

    public function ipn()
    {

        $this->language->load('payment/borgun');
        $this->load->model('checkout/order');
//        $this->load->language('localisation/currency');
        $this->load->model('localisation/currency');

        $environment = $this->config->get('borgun_sandbox') == "1" ? borgun_test_defaults::testEnvironmentSetting : borgun_test_defaults::productionEnvironmentSetting;

        $confirmation = new borgun_response($this->request->post);
        $order = $this->model_checkout_order->getOrder($confirmation->getOrderId());
        $currency = $this->model_localisation_currency->getCurrencyByCode($order['currency_code']);
        $confirmation->setEnvironment($environment);
        $confirmation->setCurrency($currency['code']);

        $order_total = $this->currency->convert($order['total'], $this->config->get('config_currency'), $currency['code']);
        if ($currency['decimal_place'] == 0) {
            $confirmation->setAmount(format($order_total, $currency));
        } else {
            $confirmation->setAmount(sprintf("%01.2f", $order_total));
        }
        $secretKey = $this->config->get('borgun_secretkey_' . $order['currency_code']);
        $secretKey = is_null($secretKey) ? borgun_test_defaults::secretKey : $secretKey;
        $checkhash = $confirmation->checkHash($secretKey);

        if (($confirmation->getStatus() == borgun_response::StatusOK) and ( $checkhash)) {
            $this->model_checkout_order->confirm($confirmation->getOrderId(), $this->config->get('borgun_pending_status_id'));
            $comment = $this->language->get('text_borgun_status') . " " . $confirmation->getStatus() . "\n" .
                    $this->language->get('text_borgun_authorizationcode') . " " . $confirmation->getAuthorizationCode() . "\n" .
                    $this->language->get('text_borgun_creditcardnumber') . " " . $confirmation->getCreditCardNumber();
            $this->model_checkout_order->update($confirmation->getOrderId(), $this->config->get('borgun_completed_status_id'), $comment, true);
        } else {
            $this->log->write('BORGUN IPN ERROR - Can not query data in the orders. Not sending email, or not update orders status.');
        }
        echo '<PaymentNotification>Accepted</PaymentNotification>';
    }

    public function debugnotification()
    {
        $notification = new borgun_notify();
        $notification->notify_debug();
        header("Location: " . htmlspecialchars_decode($_SERVER["HTTP_REFERER"]));
    }
}
