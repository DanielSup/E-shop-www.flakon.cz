<?php
class ControllerPaymentBitcoin extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/bitcoin');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		$this->load->model('payment/bitcoin');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bitcoin', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');

		$this->data['text_merchant_id'] = $this->language->get('text_merchant_id');
		$this->data['text_merchant_vector'] = $this->language->get('text_merchant_vector');
		$this->data['text_merchant_key'] = $this->language->get('text_merchant_key');
		$this->data['text_bitcoin_currency'] = $this->language->get('text_bitcoin_currency');

		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_order_status_fail'] = $this->language->get('entry_order_status_fail');
		$this->data['entry_order_status_success'] = $this->language->get('entry_order_status_success');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		if($this->model_payment_bitcoin->getOrderAmount()){
			$this->data['max_order_amount'] = $this->language->get('max_order_amount');
		} else {
			$this->data['max_order_amount'] = '';
		}

		$this->data['help_total'] = $this->language->get('help_total');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/bitcoin', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/bitcoin', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['bitcoin_merchant_id'])) {
			$this->data['bitcoin_merchant_id'] = $this->request->post['bitcoin_merchant_id'];
		} else {
			$this->data['bitcoin_merchant_id'] = $this->config->get('bitcoin_merchant_id');
		}

		if (isset($this->request->post['bitcoin_merchant_vector'])) {
			$this->data['bitcoin_merchant_vector'] = $this->request->post['bitcoin_merchant_vector'];
		} else {
			$this->data['bitcoin_merchant_vector'] = $this->config->get('bitcoin_merchant_vector');
		}

		if (isset($this->request->post['bitcoin_merchant_key'])) {
			$this->data['bitcoin_merchant_key'] = $this->request->post['bitcoin_merchant_key'];
		} else {
			$this->data['bitcoin_merchant_key'] = $this->config->get('bitcoin_merchant_key');
		}

		if (isset($this->request->post['bitcoin_currency'])) {
			$this->data['bitcoin_currency'] = $this->request->post['bitcoin_currency'];
		} else {
			$this->data['bitcoin_currency'] = $this->config->get('bitcoin_currency');
		}

		if (isset($this->request->post['bitcoin_total'])) {
			$this->data['bitcoin_total'] = $this->request->post['bitcoin_total'];
		} else {
			$this->data['bitcoin_total'] = $this->config->get('bitcoin_total');
		}

		/*if (isset($this->request->post['bitcoin_order_status_id'])) {
			$this->data['bitcoin_order_status_id'] = $this->request->post['bitcoin_order_status_id'];
		} else {
			$this->data['bitcoin_order_status_id'] = $this->config->get('bitcoin_order_status_id');
		}*/

		if (isset($this->request->post['bitcoin_order_status_fail_id'])) {
			$this->data['bitcoin_order_status_fail_id'] = $this->request->post['bitcoin_order_status_fail_id'];
		} else {
			$this->data['bitcoin_order_status_fail_id'] = $this->config->get('bitcoin_order_status_fail_id');
		}

		if (isset($this->request->post['bitcoin_order_status_success_id'])) {
			$this->data['bitcoin_order_status_success_id'] = $this->request->post['bitcoin_order_status_success_id'];
		} else {
			$this->data['bitcoin_order_status_success_id'] = $this->config->get('bitcoin_order_status_success_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['bitcoin_geo_zone_id'])) {
			$this->data['bitcoin_geo_zone_id'] = $this->request->post['bitcoin_geo_zone_id'];
		} else {
			$this->data['bitcoin_geo_zone_id'] = $this->config->get('bitcoin_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['bitcoin_status'])) {
			$this->data['bitcoin_status'] = $this->request->post['bitcoin_status'];
		} else {
			$this->data['bitcoin_status'] = $this->config->get('bitcoin_status');
		}

		if (isset($this->request->post['bitcoin_sort_order'])) {
			$this->data['bitcoin_sort_order'] = $this->request->post['bitcoin_sort_order'];
		} else {
			$this->data['bitcoin_sort_order'] = $this->config->get('bitcoin_sort_order');
		}

		$this->template = 'payment/bitcoin.tpl';
		
		$this->children = array(

			'common/header',

			'common/footer'

		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/bitcoin')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}