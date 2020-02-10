<?php

$dir = realpath(dirname(__FILE__) . '/../../../borgun');
include_once "{$dir}/borgun.php";
include_once "{$dir}/borgun_opencart_1x.php";

class ModelPaymentBorgun extends Model {

    public function getMethod($address, $total) {
        $this->load->language('payment/borgun');

        $status = check_borgun_currency($this->session->data['currency']);

        $method_data = array();

        if ($this->config->get('borgun_sandbox') == 1) {
            $payment_title = $this->language->get('text_test_mode_title');
        } else {
            $payment_title = $this->language->get('text_title');
        }

        if ($status) {
            $method_data = array(
                'code' => 'borgun',
                'title' => $payment_title,
                'sort_order' => $this->config->get('borgun_sort_order')
            );
        }

        return $method_data;
    }

}

?>