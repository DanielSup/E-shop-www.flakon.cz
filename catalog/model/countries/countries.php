<?php
require_once 'country.php';
require_once 'transportation.php';

class ModelCountriesCountries extends Model {
	public function getCountries($language) {
		$countries_info_array = $this->loadFile("catalog/model/countries/ceny a doba dopravy.csv");
		if ($language == 'cs') {
			return $countries_info_array[0];
		} else {
			return $countries_info_array[1];
		}
	}
	
	public function getSelectedCountries(){
		return ['DE', 'PL', 'HU', 'US', 'GB', 'FR', 'IT', 'CH', 'CA', 'RU', 'CN', 'AU', 'JP', 'ES', 'PT', 'BR', 'MX'];
	}
	
	private function loadFile($fileName) {
		if (($handle_countries = fopen($fileName, "r")) !== FALSE) {
			$row = 0; 
			$array_categories_czech = ['Česká republika', 'Slovenská republika', 'Evropská unie', 'Ostatní státy'];
			$array_categories_english = ['Czech republic', 'Slovak republic', 'European Union', 'Other countries'];
			$array_czech = [$array_categories_czech, [], [], [], []];
			$array_english = [$array_categories_english, [], [], [], []];
			while(($data = fgetcsv($handle_countries, 10000, ';')) !== FALSE) {
				if ($row == 0) {
					$row++;
					continue;
				}
				
				$this->addCountryOrShipping($data, $array_czech, $array_english);
				$row++;
			}
			return [$array_czech, $array_english];
		}
	}
	
	private function addCountryOrShipping($data, &$array_czech, &$array_english){
		$category = empty($data[8]) ? 4 : intval($data[8]);
		$abbreviation = $data[1];
		$czech_country_title =  iconv("windows-1250", "utf-8", $data[2]);
		$country_czech_find = $this->findCountryWithCode($abbreviation, $array_czech[$category]);
		$country_english_find = $this->findCountryWithCode($abbreviation, $array_english[$category]);
		$country_czech_new = new Country($czech_country_title, $abbreviation);
		$country_english_new = new Country($data[0], $abbreviation);
		$country_czech = $country_czech_find === FALSE ? $country_czech_new : $country_czech_find;
		$country_english = $country_english_find === FALSE ? $country_english_new : $country_english_find;
		if ($country_czech_find === FALSE) {
			array_push($array_czech[$category], $country_czech);
			array_push($array_english[$category], $country_english);
		}
		
		$this->addTransportationToCountry($data, $country_czech, true);
		$this->addTransportationToCountry($data, $country_english, false);
	}
	
	private function addTransportationToCountry($data, $country, $czech) {
		$companyName = $czech === true ? iconv("windows-1250", "utf-8", $data[3]) : $data[4];
		if (!empty($companyName)) {
			$company = $companyName;
			$delivery_time = intval($data[5]);
			$cost = $this->currency->format(intval($data[6]));
			$cash_on_delivery_time = empty($data[7]) ? $this->currency->format(0) : $this->currency->format(intval($data[7]));
			$transportation = new Transportation($company, $delivery_time, $cost, $cash_on_delivery_time);
			$country->addTransportation($transportation);
		}
	}
	
	private function findCountryWithCode($abbreviation, $countries) {
		foreach($countries as $country) {
			if ($country->getAbbreviation() == $abbreviation) {
				return $country;
			}
		}
		return FALSE;
	}
}
?>