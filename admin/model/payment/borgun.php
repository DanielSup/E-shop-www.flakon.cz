<?php

class ModelPaymentBorgun extends Model {

    public function getCurrencyValidate($currency) {

        $this->load->model('localisation/currency');
        $results = $this->model_localisation_currency->getCurrencies();

        if (isset($results[$currency])) {
            return true;
        }

        return false;
    }

}

?>