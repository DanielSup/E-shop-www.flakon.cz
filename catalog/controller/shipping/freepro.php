<?php
class ControllerShippingFreePro extends Controller {
	
	public function geolocation(){

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['ip'])) {
		
			$json = array();
			
			$ip = $this->request->post['ip'];
			
			$response = $this->getGeoplugin($ip);
			
			if (!empty($response)) {				
				$json['msg'] = $this->getCFSData($response);;
			} else {
				$json['msg'] = 'Service Unavailable';
			}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		}
	}
	
	protected function getCFSData($data){
		
		$_SESSION['geo_data'] = $data;
				
		$cfs = $this->config->get('cfs');
		
		if (empty($_SESSION['cfs_data'])) {
			$_SESSION['cfs_data'] = $cfs;
		}
		
		if (empty($country) && isset($data['country_code'])) {
			$this->load->model('localisation/country');
			$country = $this->model_localisation_country->getCountryData($data['country_code']);
			$_SESSION['country_data'] = $country;
		}
		
		if ($this->customer->isLogged() == false) {
			$customer_group_id = 0;
		} else {
			$customer_group_id = $this->customer->getCustomerGroupId();
		}
		
		if (isset($country) && isset($customer_group_id)) {
			
			foreach ($cfs as $key) {
				if ($key['country_id'] == $country['country_id'] && in_array($customer_group_id, $key['customer_group_id'])) {
						$_SESSION['cfs_match'] = 1;
						$_SESSION['cfs'] = $key;
					break;
				} else {
					$_SESSION['cfs_match'] = 0;
				}
			}
		}
		return $data;
	}
	
	protected function getGeoplugin($ip) {
	
		$response = $this->getContents($ip, 'http://www.geoplugin.net/json.gp?ip=');
		
		if (empty($response)) {
			$_SESSION['geoip_success'] = 0;
		} else {
			$_SESSION['geoip_success'] = 1;
		}
		return $this->reformatJson($response);
	}
	
	protected function reformatJson($d) {
	
		$geoplugin_data = json_decode($d, true);
		
		$response = array(
		
			'ip' 			=> $geoplugin_data['geoplugin_request'],
			'country_code' 	=> $geoplugin_data['geoplugin_countryCode'],
			'country_name' 	=> $geoplugin_data['geoplugin_countryName'],
			'city'			=> $geoplugin_data['geoplugin_city']
		);
	
		return $response;
	}
	
	protected function getContents($ip, $url) {
		
		$url .= $ip;
		$response = file_get_contents("$url");
		
		return $response;
		
	}
	
	//Debug
	
	public function resetSession() {
		
		$_SESSION = array();
		
	}
}