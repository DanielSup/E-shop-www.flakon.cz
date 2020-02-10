<?php
class ControllerShippingCountryFree extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/country_free');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('localisation/country');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('country_free', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_subtotal'] = $this->language->get('text_subtotal');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_translate'] = $this->language->get('text_translate');
		$i = 0;
		while ($i < 3) {
			$i++;
			$key = 'text_teaser_' . $i;
			$this->data[$key] = $this->language->get($key);
			
		}
		$this->data['text_msg_no'] = $this->language->get('text_msg_no');
		$this->data['text_msg_yes'] = $this->language->get('text_msg_yes');
		$this->data['text_msg_to'] = $this->language->get('text_msg_to');
		
		$this->data['entry_freeshippingno'] = $this->language->get('entry_freeshippingno');
		$this->data['entry_freeshippingyes'] = $this->language->get('entry_freeshippingyes');
		$this->data['entry_to_country'] = $this->language->get('entry_to_country');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_show_teaser'] = $this->language->get('entry_show_teaser');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_select_total'] = $this->language->get('entry_select_total');

		$this->data['button_add'] = $this->language->get('button_add');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		foreach (array('no', 'yes', 'to') as $key) {
			$var = 'error_' . $key;
			if (isset($this->error[$key])) {
				$this->data[$var] = $this->error[$key];
				$this->data['error_warning'] = $this->error['required'];
			} else {
				$this->data[$var] = array();
			}
		}
		
		$this->load->model('account/customer_group');
		$customer_groups = $this->model_account_customer_group->getCustomerGroups();
		
		foreach ($customer_groups as $customer_group) {
			$t[] = array(
				'customer_group_id' => $customer_group['customer_group_id'],
				'name' 				=> $customer_group['name']
			);
		}
		
		array_unshift($t, array(
            'customer_group_id' => 0,
            'name' 				=> $this->language->get('text_anonymous'),
        ));
        
        $this->data['customer_groups'] = $t;
		
		$this->data['countries'] = $this->model_localisation_country->getCountries();
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/country_free', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/country_free', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
	
		$this->data['country_free_shipping'] = array();
		
		if (isset($this->request->post['cfs'])) {
			$this->data['country_free_shipping'] = $this->request->post['cfs'];
		} else {
			$this->data['country_free_shipping'] = $this->config->get('cfs');
		}
		
		if (isset($this->request->post['country_free_status'])) {
			$this->data['country_free_status'] = $this->request->post['country_free_status'];
		} else {
			$this->data['country_free_status'] = $this->config->get('country_free_status');
		}
		
		if (isset($this->request->post['country_free_sort_order'])) {
			$this->data['country_free_sort_order'] = $this->request->post['country_free_sort_order'];
		} else {
			$this->data['country_free_sort_order'] = $this->config->get('country_free_sort_order');
		}
		
		if (isset($this->request->post['country_free_debug'])) {
			$this->data['country_free_debug'] = $this->request->post['country_free_debug'];
		} else {
			$this->data['country_free_debug'] = $this->config->get('country_free_debug');
		}
		
		$i = 0;
		while ($i < 3) {
			$i++;
			$key = 'country_free_teaser_' . $i;
			if (isset($this->request->post[$key])) {
				$this->data[$key] = $this->request->post[$key];
			} else {
				$this->data[$key] = $this->config->get($key);
			}
		}
		
		if (isset($this->request->post['country_free_total'])) {
			$this->data['country_free_total'] = $this->request->post['country_free_total'];
		} else {
			$this->data['country_free_total'] = $this->config->get('country_free_total');
		}	
		
		// Custom Messages
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['country_free_msg'])) {
			$this->data['country_free_msg'] = $this->request->post['country_free_msg'];
		} else {
			$this->data['country_free_msg'] = $this->config->get('country_free_msg');
		}
										
		$this->template = 'shipping/country_free.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/country_free')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		foreach (array('no', 'yes', 'to') as $key) {
			foreach ($this->request->post['country_free_msg'] as $language_id => $value) {
				if ((utf8_strlen($value[$key]) < 1) || (utf8_strlen($value[$key]) > 255)) {
					$this->error[$key][$language_id] = $this->language->get('error_msg');
					$this->error['required'] = $this->language->get('error_required');
				}
			}
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>