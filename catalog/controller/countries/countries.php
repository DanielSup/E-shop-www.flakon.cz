<?php
class ControllerCountriesCountries extends Controller {
	private $error = array(); 
	
	public function index(){
		$this->language->load('countries/countries');
		$this->load->model('countries/countries');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/countries/countries.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/countries/countries.tpl';
		} else {
			$this->template = 'default/template/countries/countries.tpl';
		}
		
		$this->data['text_heading'] = $this->language->get('text_heading');
		$this->data['text_delivery_time_begin'] = $this->language->get('text_delivery_time_begin');
		$this->data['text_delivery_time_end'] = $this->language->get('text_delivery_time_end');
		$this->data['text_delivery_cost'] = $this->language->get('text_delivery_cost');
		$this->data['text_delivery_cost_default_currency'] = $this->language->get('text_delivery_cost_default_currency');
		$this->data['text_delivery_cash_on_delivery'] = $this->language->get('text_delivery_cash_on_delivery');
		$this->data['text_delivery_cash_on_delivery_default_currency'] = $this->language->get('text_delivery_cash_on_delivery_default_currency');
		$this->data['text_introduction'] = $this->language->get('text_introduction');
		$this->data['text_no_delivery'] = $this->language->get('text_no_delivery');
		
		$abbreviation = $this->language->get('abbreviation');
		$countriesInfo = $this->model_countries_countries->getCountries($abbreviation);
		$this->data['categories'] = $countriesInfo[0];
		$this->data['countries'] = $this->model_countries_countries->getCountries($abbreviation);
		$this->data['selected_countries'] = $this->model_countries_countries->getSelectedCountries();

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_bottom',
			'common/content_top',
			'common/footer',
			'common/header'	
		);

		$this->response->setOutput($this->render());
	}
}
?>