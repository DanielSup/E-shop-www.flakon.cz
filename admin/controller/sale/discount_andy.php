<?php  
class ControllerSaleDiscountAndy extends Controller {
	private $error = array();
     
  	public function index() {
		$this->load->language('sale/discount_andy');
    	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/discount_andy');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->load->language('sale/discount_andy');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/discount_andy');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) 
		{
			$ids_customer_groups=$this->ids_customer_groups();
			$this->model_sale_discount_andy->addDiscount_andy($this->request->post,$ids_customer_groups);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('sale/discount_andy', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
    
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->language('sale/discount_andy');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/discount_andy');
				
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) 
		{
			$ids_customer_groups=$this->ids_customer_groups();
			$this->model_sale_discount_andy->editDiscount_andy($this->request->get['discount_andy_id'],$ids_customer_groups, $this->request->post);
      		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('sale/discount_andy', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('sale/discount_andy');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/discount_andy');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) { 
			foreach ($this->request->post['selected'] as $discount_andy_id) {
				$this->model_sale_discount_andy->deleteDiscount_andy($discount_andy_id);
			}
      		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('sale/discount_andy', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getList();
  	}

  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/discount_andy', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('sale/discount_andy/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/discount_andy/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['discounts_andy'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$discount_andy_total = $this->model_sale_discount_andy->getTotalDiscount_andy();
	
		$results = $this->model_sale_discount_andy->getDiscounts_andy($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/discount_andy/update', 'token=' . $this->session->data['token'] . '&discount_andy_id=' . $result['discount_andy_id'] . $url, 'SSL')
			);
						
			$this->data['discounts_andy'][] = array(
				'discount_andy_id'  => $result['discount_andy_id'],
				'name'       => $result['name'],
				'discount'   => $result['discount'],
				'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
				'date_end'   => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['discount_andy_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}
									
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_discount'] = $this->language->get('column_discount');
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=sale/discount_andy&token=' . $this->session->data['token'] . '&sort=name' . $url;
		$this->data['sort_discount'] = HTTPS_SERVER . 'index.php?route=sale/discount_andy&token=' . $this->session->data['token'] . '&sort=discount' . $url;
		$this->data['sort_date_start'] = HTTPS_SERVER . 'index.php?route=sale/discount_andy&token=' . $this->session->data['token'] . '&sort=date_start' . $url;
		$this->data['sort_date_end'] = HTTPS_SERVER . 'index.php?route=sale/discount_andy&token=' . $this->session->data['token'] . '&sort=date_end' . $url;
		$this->data['sort_status'] = HTTPS_SERVER . 'index.php?route=sale/discount_andy&token=' . $this->session->data['token'] . '&sort=status' . $url;
				
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $discount_andy_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=sale/discount_andy&token=' . $this->session->data['token'] . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/discount_andy_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render());
  	}

  	private function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
    	$this->data['text_percent'] = $this->language->get('text_percent');
    	$this->data['text_amount'] = $this->language->get('text_amount');
				
		$this->data['entry_name'] = $this->language->get('entry_name');
    	$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_discount'] = $this->language->get('entry_discount');
		$this->data['entry_logged'] = $this->language->get('entry_logged');
		$this->data['entry_customer_groups'] = $this->language->get('entry_customer_groups');
		$this->data['entry_shipping'] = $this->language->get('entry_shipping');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_product'] = $this->language->get('entry_product');
    	$this->data['entry_date_start'] = $this->language->get('entry_date_start');
    	$this->data['entry_date_end'] = $this->language->get('entry_date_end');
    	$this->data['entry_uses_total'] = $this->language->get('entry_uses_total');
		$this->data['entry_uses_customer'] = $this->language->get('entry_uses_customer');
		$this->data['entry_status'] = $this->language->get('entry_status');

    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_discount_andy_history'] = $this->language->get('tab_discount_andy_history');

		$this->data['token'] = $this->session->data['token'];
	
		if (isset($this->request->get['discount_andy_id'])) {
			$this->data['discount_andy_id'] = $this->request->get['discount_andy_id'];
		} else {
			$this->data['discount_andy_id'] = 0;
		}
				
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	 	
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		
		
		if (isset($this->error['date_start'])) {
			$this->data['error_date_start'] = $this->error['date_start'];
		} else {
			$this->data['error_date_start'] = '';
		}	
		
		if (isset($this->error['date_end'])) {
			$this->data['error_date_end'] = $this->error['date_end'];
		} else {
			$this->data['error_date_end'] = '';
		}	
		
		if (isset($this->error['customer_group_error'])) {
			$this->data['error_customer_group'] = $this->error['customer_group_error'];
		} else {
			$this->data['error_customer_group'] = '';
		}
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/discount_andy', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['discount_andy_id'])) {
			$this->data['action'] = $this->url->link('sale/discount_andy/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/discount_andy/update', 'token=' . $this->session->data['token'] . '&discount_andy_id=' . $this->request->get['discount_andy_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('sale/discount_andy', 'token=' . $this->session->data['token'] . $url, 'SSL');
  		
		if (isset($this->request->get['discount_andy_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$discount_andy_info = $this->model_sale_discount_andy->getDiscount_andy($this->request->get['discount_andy_id']);
    	}
		
    	if (isset($this->request->post['name'])) {
      		$this->data['name'] = $this->request->post['name'];
    	} elseif (!empty($discount_andy_info)) {
			$this->data['name'] = $discount_andy_info['name'];
		} else {
      		$this->data['name'] = '';
    	}
		
		
    	if (isset($this->request->post['type'])) {
      		$this->data['type'] = $this->request->post['type'];
    	} elseif (!empty($discount_andy_info)) {
			$this->data['type'] = $discount_andy_info['type'];
		} else {
      		$this->data['type'] = '';
    	}
		
    	if (isset($this->request->post['discount'])) {
      		$this->data['discount'] = $this->request->post['discount'];
    	} elseif (!empty($discount_andy_info)) {
			$this->data['discount'] = $discount_andy_info['discount'];
		} else {
      		$this->data['discount'] = '';
    	}

    	if (isset($this->request->post['logged'])) {
      		$this->data['logged'] = $this->request->post['logged'];
    	} elseif (!empty($discount_andy_info)) {
			$this->data['logged'] = $discount_andy_info['logged'];
		} else {
      		$this->data['logged'] = '';
    	}
		
    	if (isset($this->request->post['shipping'])) {
      		$this->data['shipping'] = $this->request->post['shipping'];
    	} elseif (!empty($discount_andy_info)) {
			$this->data['shipping'] = $discount_andy_info['shipping'];
		} else {
      		$this->data['shipping'] = '';
    	}

    	if (isset($this->request->post['total'])) {
      		$this->data['total'] = $this->request->post['total'];
    	} elseif (!empty($discount_andy_info)) {
			$this->data['total'] = $discount_andy_info['total'];
		} else {
      		$this->data['total'] = '';
    	}
		
		if (isset($this->request->post['discount_andy_product'])) {
			$products = $this->request->post['discount_andy_product'];
		} elseif (isset($this->request->get['discount_andy_id'])) {		
			$products = $this->model_sale_discount_andy->getDiscount_andy_Products($this->request->get['discount_andy_id']);
		} else {
			$products = array();
		}
		
		$this->load->model('catalog/product');
		
		$this->data['discount_andy_product'] = array();
		
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) {
				$this->data['discount_andy_product'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}

		$this->load->model('catalog/category');
				
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		
			
		
		//ADUCE DATELE DESPRE GRUPURILE DE CLIENTI
		
		if(isset($this->request->post['customer_group_ids']))
		{
			$this->data['customer_group_ids']=$this->request->post['customer_group_ids'];
		}
		elseif(isset($this->request->get['discount_andy_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST'))
		{
			$valori_status=$this->model_sale_discount_andy->get_customer_groups();
			$valori_setate=$this->model_sale_discount_andy->getDiscount_andy($this->request->get['discount_andy_id']);
			$valori_set=explode(",",$valori_setate['groups_id']);
			$customer_group_ids=array();
			foreach($valori_status as $valori_name=>$valori_id)
			{
				$name=array_search($valori_id,$valori_set);
				
				if($name===FALSE){
					$customer_group_ids[$valori_id][$valori_name]=0;
				}
				else{
					$customer_group_ids[$valori_id][$valori_name]=1;
				}
			}
			
			$this->data['customer_group_ids']=$customer_group_ids;
		}
		else
		{
			$valori_status=$this->model_sale_discount_andy->get_customer_groups();
			foreach($valori_status as $valori_name=>$valori_id)
			{
				$customer_group_ids[$valori_id][$valori_name]=0;
			}
			$this->data['customer_group_ids']=$customer_group_ids;
		}
		
		
		
		if (isset($this->request->post['date_start'])) {
       		$this->data['date_start'] = $this->request->post['date_start'];
		} elseif (!empty($discount_andy_info)) {
			$this->data['date_start'] = date('Y-m-d', strtotime($discount_andy_info['date_start']));
		} else {
			$this->data['date_start'] = date('Y-m-d', time());
		}

		if (isset($this->request->post['date_end'])) {
       		$this->data['date_end'] = $this->request->post['date_end'];
		} elseif (!empty($discount_andy_info)) {
			$this->data['date_end'] = date('Y-m-d', strtotime($discount_andy_info['date_end']));
		} else {
			$this->data['date_end'] = date('Y-m-d', time());
		}

    	if (isset($this->request->post['uses_total'])) {
      		$this->data['uses_total'] = $this->request->post['uses_total'];
		} elseif (!empty($discount_andy_info)) {
			$this->data['uses_total'] = $discount_andy_info['uses_total'];
    	} else {
      		$this->data['uses_total'] = 1;
    	}
  
    	if (isset($this->request->post['uses_customer'])) {
      		$this->data['uses_customer'] = $this->request->post['uses_customer'];
    	} elseif (!empty($discount_andy_info)) {
			$this->data['uses_customer'] = $discount_andy_info['uses_customer'];
		} else {
      		$this->data['uses_customer'] = 1;
    	}
 
    	if (isset($this->request->post['status'])) { 
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($discount_andy_info)) {
			$this->data['status'] = $discount_andy_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
		
		$this->template = 'sale/discount_andy_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render());		
  	}
	
	private function ids_customer_groups()
	{
		$customer_groups= isset($this->request->post['customer_group_ids'])?$this->request->post['customer_group_ids']:null;
		$selected_ids=array();
		if(is_null($customer_groups))
		{
			return null;
		}
		foreach ($customer_groups as $customer_group_id=>$customer_group_name)
		{
			$values=array_values($customer_group_name);
			if($values[0]==1)
			{
				$selected_ids[$customer_group_id]=$customer_group_id;
			}
		}
		
		return implode(",",$selected_ids);
		
	}
	
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/discount_andy')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
      	
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
        	$this->error['name'] = $this->language->get('error_name');
      	}
			
		//VERIFICARE CUSTOMER AND USER GROUPS
		
		$customer=0;
		
		if(isset($this->request->post['customer_group_ids']))
		{
			$customer_groups=$this->request->post['customer_group_ids'];
			foreach($customer_groups AS $customer_group_id=>$customer_group_name)
			{
				$values=array_values($customer_group_name);
				if($values[0]==1)
				{
					$customer=1;
				}
			}
		}
	
		if($customer==0)
			{
				$this->error['customer_group_error'] = $this->language->get('error_customer_group');
			}
	
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/discount_andy')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
	  	
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}	
	
	public function history() {
    	$this->language->load('sale/discount_andy');
		
		$this->load->model('sale/discount_andy');
				
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_amount'] = $this->language->get('column_amount');
		$this->data['column_date_added'] = $this->language->get('column_date_added');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['histories'] = array();
			
		$results = $this->model_sale_discount_andy->getDiscount_Andy_Histories($this->request->get['discount_andy_id'], ($page - 1) * 10, 10);
      		
		foreach ($results as $result) {
        	$this->data['histories'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'amount'     => $result['amount'],
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
		
		$history_total = $this->model_sale_discount_andy->getTotalDiscount_Andy_Histories($this->request->get['discount_andy_id']);
			
		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->url = $this->url->link('sale/discount_andy/history', 'token=' . $this->session->data['token'] . '&discount_andy_id=' . $this->request->get['discount_andy_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/discount_andy_history.tpl';		
		
		$this->response->setOutput($this->render());
  	}
  	
  	
public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('sale/discount_andy');
			$this->load->model('catalog/option');
			$this->load->model('catalog/product');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			//adaugat de mine
			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
			} else {
				$filter_category_id = '';
			}
			//
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				//adaugat de mine
				'filter_category_id' => $filter_category_id,
				//
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_sale_discount_andy->getProducts($data);
			
			foreach ($results as $result) {
				$option_data = array();
				
				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);	
				
				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);
					
					if ($option_info) {				
						if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
							$option_value_data = array();
							
							foreach ($product_option['product_option_value'] as $product_option_value) {
								$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);
						
								if ($option_value_info) {
									$option_value_data[] = array(
										'product_option_value_id' => $product_option_value['product_option_value_id'],
										'option_value_id'         => $product_option_value['option_value_id'],
										'name'                    => $option_value_info['name'],
										'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
										'price_prefix'            => $product_option_value['price_prefix']
									);
								}
							}
						
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $option_value_data,
								'required'          => $product_option['required']
							);	
						} else {
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $product_option['option_value'],
								'required'          => $product_option['required']
							);				
						}
					}
				}
					
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}  	

		
}
?>