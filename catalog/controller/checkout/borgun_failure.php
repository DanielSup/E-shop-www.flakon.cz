<?php

class ControllerCheckoutBorgunFailure extends Controller {

    public function index() {
        if (isset($this->session->data['order_id'])) {

            $order_id = $this->session->data['order_id'];

            $this->load->model('payment/borgun');
            $this->language->load('payment/borgun');
        }

        $this->language->load('checkout/borgun_failure');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('checkout/cart'),
            'text' => $this->language->get('text_basket'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('checkout/checkout', '', 'SSL'),
            'text' => $this->language->get('text_checkout'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home'),
            'text' => $this->language->get('text_failure'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        if ($this->customer->isLogged()) {
            $this->data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
        } else {
            $this->data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
        }

        $this->data['button_checkout'] = $this->language->get('button_checkout');
        $this->data['checkout'] = $this->url->link('checkout/checkout');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/borgun_failure.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/borgun_failure.tpl';
        } else {
            $this->template = 'default/template/payment/borgun_failure.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }

}

?>