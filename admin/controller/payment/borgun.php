<?php

define("BORGUN_MODULE_VERSION", "2.1.8");

$dir = realpath(dirname(__FILE__) . '/../../../borgun');
include "{$dir}/borgun.php";
include "{$dir}/borgun_opencart_1x.php";

class ControllerPaymentBorgun extends Controller
{

    
    private $error = array();
       
    /**
     *
     * @var array contents all enabled currencies
     */
    public $currencies = array();
    
    /**
     * @var array contents all enabled currencies and supported by Borgun
     */
    public $supportedCurrencies = array();
    
    /**
     * @var array contents all enabled currencies but not supported by Borgun
     */
    public $disabledCurrencies = array();
    
    
    public function index()
    {
        $this->load->language('payment/borgun');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('borgun', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            if ($this->request->post['borgun_sandbox'] != $this->config->get('borgun_sandbox')) {
                $notification = new borgun_notify();
                $notification->notify_switch($this->request->post['borgun_sandbox'] == 1 ? borgun_notify::SWITCH_TO_TEST : borgun_notify::SWITCH_TO_PRODUCTION);
            }
            $this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->load->model('localisation/currency');
        $this->currencies = $this->model_localisation_currency->getCurrencies();
        
        $remote_data = new borgun_get_data();
        
        if (file_exists($remote_data->path . "/currencies.php")) {
            include_once $remote_data->path . "/currencies.php";
            $borgun_currency_translations = $borgun_currency_translations + borgun_test_defaults::$currencies_translations;
            $borgun_currencies = $borgun_currencies + borgun_test_defaults::$currencies;
        }
        foreach ($this->currencies as $curency) {
            $title = $curency["title"];
            $code = $curency["code"];
            if ((isset($borgun_currency_translations)) and ( isset($borgun_currency_translations[$code]))) {
                $code = $borgun_currency_translations[$code];
            }
            if ((isset($borgun_currencies)) and ( isset($borgun_currencies[$code]))) {
                $this->supportedCurrencies[$code] = $title;
            } else {
                $this->disabledCurrencies[$code] = $title;
            }
        }
        $this->data['heading_title'] = $this->language->get('admin_title');
        
        $this->data['entry_enable'] = $this->language->get('entry_enable');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        
        
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        
        $this->data['text_borgun_general_information'] = $this->language->get('text_borgun_general_information');
        $this->data['text_borgun_account_information'] = $this->language->get('text_borgun_account_information');
        $this->data['heading_account_title'] = $this->language->get('heading_account_title');
        $this->data['available_configuration'] = $this->language->get('available_configuration');
        $this->data['unavailable_configurations'] = $this->language->get('unavailable_configurations');
        
        $this->data['entry_merchantid'] = $this->language->get('entry_merchantid');
        $this->data['entry_secretkey'] = $this->language->get('entry_secretkey');
        $this->data['entry_paymentgatewayid'] = $this->language->get('entry_paymentgatewayid');
        $this->data['entry_pagetype'] = $this->language->get('entry_pagetype');
        $this->data['entry_forwardcustomersname'] = $this->language->get('entry_forwardcustomersname');
        $this->data['entry_showadditionalbrands'] = $this->language->get('entry_showadditionalbrands');
        $this->data['entry_skipreceiptpage'] = $this->language->get('entry_skipreceiptpage');
        $this->data['entry_merchantemail'] = $this->language->get('entry_merchantemail');
        $this->data['entry_merchantlogo'] = $this->language->get('entry_merchantlogo');
        $this->data['entry_total_only'] = $this->language->get('entry_total_only');

        $this->data['tab_general'] = $this->language->get('tab_general');
        $this->data['tab_account'] = $this->language->get('tab_account');
        $this->data['tab_about'] = $this->language->get('tab_about');
        
        $this->data['entry_pending_status'] = $this->language->get('entry_pending_status');
        $this->data['entry_completed_status'] = $this->language->get('entry_completed_status');
        $this->data['entry_canceled_status'] = $this->language->get('entry_canceled_status');
        $this->data['entry_failed_status'] = $this->language->get('entry_failed_status');
        $this->data['entry_status_return'] = $this->language->get('entry_status_return');
        
        $this->data['entry_total'] = $this->language->get('entry_total');
        $this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_test'] = $this->language->get('entry_test');
        
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_notification'] = $this->language->get('button_notification');
        $this->data['button_apply'] = $this->language->get('button_apply');
        
        $this->load->model('payment/borgun');
        
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        
        if (!class_exists('VQMod')) {
            $this->data['error_warning'] = $this->language->get('error_vqmod');
        }
        
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        
        $this->data['breadcrumbs'] = array();
        
        $this->data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_home'),
        'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
        'separator' => false
        );
        
        $this->data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_payment'),
        'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
        'separator' => ' :: '
        );
        
        $this->data['breadcrumbs'][] = array(
        'text' => $this->language->get('heading_title'),
        'href' => $this->url->link('payment/borgun', 'token=' . $this->session->data['token'], 'SSL'),
        'separator' => ' :: '
        );
        
        $this->data['action'] = $this->url->link('payment/borgun', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['callback'] = HTTP_CATALOG . 'index.php?route=payment/borgun/callback';
        $this->data['ipn'] = HTTP_CATALOG . 'index.php?route=payment/borgun/ipn';
        $this->data['notification'] = HTTP_CATALOG . 'index.php?route=payment/borgun/debugnotification&token=' . $this->session->data['token'];
        
        $sandbox = false;
        
        if ($this->config->get('borgun_sandbox') != '') {
            $this->data['borgun_sandbox'] = $this->config->get('borgun_sandbox');
        } else {
            $this->data['borgun_sandbox'] = borgun_test_defaults::testEnvironment;
        }
        if ($this->data['borgun_sandbox']) {
            $sandbox = true;
        }
        
        $this->data['supportedCurrencies'] = $this->supportedCurrencies;
        $this->data['disabledCurrencies'] = $this->disabledCurrencies;
        
        foreach ($this->supportedCurrencies as $code => $title) {
            if ($this->config->get('borgun_merchantid_' . $code) != '') {
                $this->data['borgun_merchantid_' . $code] = $this->config->get('borgun_merchantid_' . $code);
            } else {
                $this->data['borgun_merchantid_' . $code] = borgun_test_defaults::merchantId;
            }
            
            if ($this->config->get('borgun_secretkey_' . $code) != '') {
                $this->data['borgun_secretkey_' . $code] = $this->config->get('borgun_secretkey_' . $code);
            } else {
                $this->data['borgun_secretkey_' . $code] = borgun_test_defaults::secretKey;
            }
            
            if ($this->config->get('borgun_paymentgatewayid_' . $code) != '') {
                $this->data['borgun_paymentgatewayid_' . $code] = $this->config->get('borgun_paymentgatewayid_' . $code);
            } else {
                $this->data['borgun_paymentgatewayid_' . $code] = borgun_test_defaults::paymentGatewayId;
            }
        }

        if ($this->config->get('borgun_forwardcustomersname') != '') {
            $this->data['borgun_forwardcustomersname'] = $this->config->get('borgun_forwardcustomersname');
        } else {
            $this->data['borgun_forwardcustomersname'] = borgun_test_defaults::forwardCustomersName;
        }

        if ($this->config->get('borgun_sendtotalonly') != '') {
            $this->data['borgun_sendtotalonly'] = $this->config->get('borgun_sendtotalonly');
        } else {
            $this->data['borgun_sendtotalonly'] = borgun_test_defaults::sendTotalOnly;
        }
        
        if ($this->config->get('borgun_pagetype') != '') {
            $this->data['borgun_pagetype'] = $this->config->get('borgun_pagetype');
        } else {
            $this->data['borgun_pagetype'] = borgun_test_defaults::pageType;
        }
        
        if ($this->config->get('borgun_showadditionalbrands') != '') {
            $this->data['borgun_showadditionalbrands'] = $this->config->get('borgun_showadditionalbrands');
        } else {
            $this->data['borgun_showadditionalbrands'] = borgun_test_defaults::showAdditionalBrands;
        }
        
        if ($this->config->get('borgun_skipreceiptpage') != '') {
            $this->data['borgun_skipreceiptpage'] = $this->config->get('borgun_skipreceiptpage');
        } else {
            $this->data['borgun_skipreceiptpage'] = borgun_test_defaults::skipReceiptPage;
        }
        
        if ($this->config->get('borgun_merchantemail') != '') {
            $this->data['borgun_merchantemail'] = $this->config->get('borgun_merchantemail');
        } else {
            $this->data['borgun_merchantemail'] = $this->config->get('config_email');
        }
        
        if ($this->config->get('borgun_merchantlogo') != '') {
            $this->data['borgun_merchantlogo'] = $this->config->get('borgun_merchantlogo');
        } else {
            $this->data['borgun_merchantlogo'] = HTTP_CATALOG . 'image/' . $this->config->get('config_logo');
        }
        
        /*
		if ($this->config->get('borgun_total') != '') {
			$this->data['borgun_total'] = $this->config->get('borgun_total');
    	} else {
         	$this->data['borgun_total'] = "";
    	}
		*/
        
        if ($this->config->get('borgun_pending_status_id') != '') {
            $this->data['borgun_pending_status_id'] = $this->config->get('borgun_pending_status_id');
        } else {
            $this->data['borgun_pending_status_id'] = "1";
        }
        
        if ($this->config->get('borgun_completed_status_id') != '') {
            $this->data['borgun_completed_status_id'] = $this->config->get('borgun_completed_status_id');
        } else {
            $this->data['borgun_completed_status_id'] = "2";
        }
        
        if ($this->config->get('borgun_canceled_status_id') != '') {
            $this->data['borgun_canceled_status_id'] = $this->config->get('borgun_canceled_status_id');
        } else {
            $this->data['borgun_canceled_status_id'] = "7";
        }
        
        if ($this->config->get('borgun_failed_status_id') != '') {
            $this->data['borgun_failed_status_id'] = $this->config->get('borgun_failed_status_id');
        } else {
            $this->data['borgun_failed_status_id'] = "10";
        }
        
        $this->load->model('localisation/order_status');
        
        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        
        /*
        if (isset($this->request->post['borgun_geo_zone_id'])) {
			$this->data['borgun_geo_zone_id'] = $this->request->post['borgun_geo_zone_id'];
	    } else {
    		$this->data['borgun_geo_zone_id'] = $this->config->get('borgun_geo_zone_id');
        }
   		$this->load->model('localisation/geo_zone');
   		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
        */
        
        if (isset($this->request->post['borgun_status'])) {
            $this->data['borgun_status'] = $this->request->post['borgun_status'];
        } else {
            $this->data['borgun_status'] = $this->config->get('borgun_status');
        }
        
        if (isset($this->request->post['borgun_sort_order'])) {
            $this->data['borgun_sort_order'] = $this->request->post['borgun_sort_order'];
        } else {
            $this->data['borgun_sort_order'] = $this->config->get('borgun_sort_order');
        }
        
        $this->data['error_required'] = $this->language->get('error_required');
        
        $this->template = 'payment/borgun.tpl';
        $this->children = array(
        'common/header',
        'common/footer'
        );
        
        $this->response->setOutput($this->render());
    }

    private function validate()
    {																																																		
            
        $this->load->model('payment/borgun');
        /*
        foreach ($this->supportedCurrencies as $code => $title) {
        	if (($this->request->post['borgun_status']) && (isset($this->request->post['borgun_merchantid_' . $code])) && (empty($this->request->post['borgun_merchantid_' . $code]))) {
            	$this->error['warning'] = $this->language->get('error_required_merchantid');
                $this->data['error_required_merchantid'] = $this->language->get('error_required');
		    }
   			if (($this->request->post['borgun_status']) && (isset($this->request->post['borgun_secretkey_' . $code])) && (empty($this->request->post['borgun_secretkey_' . $code]))) {
                $this->error['warning'] = $this->language->get('error_required_secretkey');
                $this->data['error_required_secretkey'] = $this->language->get('error_required');
			}
            if (($this->request->post['borgun_status']) && (isset($this->request->post['borgun_paymentgatewayid_' . $code])) && (empty($this->request->post['borgun_paymentgatewayid_' . $code]))) {
            	$this->error['warning'] = $this->language->get('error_required_paymentgatewayid');
                $this->data['error_required_paymentgatewayid'] = $this->language->get('error_required');
            }
        }
        if (($this->request->post['borgun_status']) && ($this->request->post['borgun_pagetype']) && (empty($this->request->post['error_required_merchantemail']))) {
        	$this->error['warning'] = $this->language->get('error_required_merchantemail');
        	$this->data['error_required_merchantemail'] = $this->language->get('error_required');
        }
        if (($this->request->post['borgun_status']) && (empty($this->request->post['borgun_total']))) {
            $this->error['warning'] = $this->language->get('error_borgun_total');
            $this->data['error_required_total'] = $this->language->get('error_required');
        }
		*/
        
        if (!$this->user->hasPermission('modify', 'payment/borgun')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
    
    public function install()
    {
        $notification = new borgun_notify();
        $notification->notify_install();
    }
    
    
    public function uninstall()
    {
        $notification = new borgun_notify();
        $notification->notify_uninstall();
    }
}
