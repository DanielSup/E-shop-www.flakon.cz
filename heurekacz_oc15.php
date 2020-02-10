<?php

	/* debug
	ini_set('error_reporting', 6143);
	ini_set('display_errors', 1);
	*/
class Product {
	function description($product_description) {
		$product_description = str_replace('&amp;', '&', $product_description);
		$product_description = htmlspecialchars(strip_tags(html_entity_decode($product_description, ENT_QUOTES, 'UTF-8')));
		$product_description = str_replace('&amp;nbsp;', '', $product_description);
		/*$product_description = str_replace('&;', '&amp;', $product_description);*/
		if (strlen($product_description) > 5080) {
			$print_description = substr($product_description, 0, 5080);
			$pos = strrpos($print_description, ' ');
			$print_description = substr($product_description, 0, $pos) . ' ...';
		} else {
			$print_description = $product_description; 
		}
		return $print_description;
	}

	function name($product_name) {
		$product_name = htmlspecialchars(strip_tags(html_entity_decode($product_name, ENT_QUOTES, 'UTF-8')));
		if (strlen($product_name) > 160) {
			$print_product_name = substr($product_name, 0, 160);
			$pos = strrpos($print_product_name, ' ');
			$print_product_name = substr($product_name, 0, $pos) . ' ...';
		} else {
			$print_product_name = $product_name;
		}
		return $print_product_name;
	}
}

require_once("./config.php");
require_once(DIR_SYSTEM . 'startup.php');
require_once(DIR_DATABASE . 'mysql.php');
$need_configs = array(
	'config_url',
	'config_ssl',
	'config_customer_group_id',
	'config_language'
);

// Config
$config = new Config();
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$setting_query = $db->query("SELECT * FROM " . DB_PREFIX . "setting s WHERE s.key IN('".implode("','",$need_configs)."')");
foreach ($setting_query->rows as $setting) {
	$config->set($setting['key'], $setting['value']);
}
unset($setting_query);

$curr_factor = 1;

// Cache
header('Content-Type: text/xml');
	$items = new Product();

	$url_query = $db->query("SELECT query,keyword FROM " . DB_PREFIX . "url_alias ORDER BY url_alias_id");
	$urls = array();
	foreach($url_query->rows as $url) {
		$data = array();
		parse_str($url['query'], $data);
		if(key($data) == 'product_id') {
			$urls[$data['product_id']] = $url['keyword'];
		}
	}
	unset($url_query);
	$datum = date("Y-m-d");
	$SQL = "SELECT p.product_id,p.quantity,p.image,p.date_available,p.sku,pd.language_id,pd.name,pd.description,pd.meta_description,
                p.stock_status_id,m.name AS manufacturer,
		IF(ps.price,ps.price,p.price) AS price,cd.name AS categorytext,pc.category_id

		FROM " . DB_PREFIX . "product p
		LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id=pd.product_id) 
		LEFT JOIN " . DB_PREFIX . "product_to_category pc ON (p.product_id=pc.product_id) 
		LEFT JOIN " . DB_PREFIX . "category_description cd ON (pc.category_id=cd.category_id) 
		LEFT JOIN " . DB_PREFIX . "language l ON (l.language_id = pd.language_id )
		LEFT JOIN " . DB_PREFIX . "manufacturer m ON (m.manufacturer_id = p.manufacturer_id )
		LEFT JOIN (SELECT * FROM  " . DB_PREFIX . "product_special WHERE (date_start = '0000-00-00' OR date_start <= '$datum') AND (date_end = '0000-00-00' OR date_end >= '$datum')) 
    ps ON (ps.product_id = p.product_id AND ps.customer_group_id=".$config->get('config_customer_group_id').")
		WHERE p.quantity>0 AND l.code='".$config->get('config_language')."' AND p.status=1 GROUP BY p.product_id";

	$head = "<?xml version=\"1.0\" encoding=\"utf-8\"?".">\r";
	$head .= "<SHOP xmlns=\"http://www.zbozi.cz/ns/offer/1.0\">\n";
	echo $head;
        
	$body = "";
	$query_products = $db->query($SQL);
	foreach ($query_products->rows as $product) {
		$shopitem = "";
		$shopitem .= "<SHOPITEM>\n";
		$shopitem .= "<ITEM_ID>".$product['product_id']."</ITEM_ID>\n";
		$shopitem .= "<PRODUCTNAME>".trim($items->name($product['name']))."</PRODUCTNAME>\n";
		$shopitem .= "<DESCRIPTION>".$items->description($product['description'])."</DESCRIPTION>\n";
		$shopitem .= "<URL>";
		if(isset($urls[$product['product_id']]) && $urls[$product['product_id']]) {
			$shopitem .= "http://www.flakon.cz/". $urls[$product['product_id']];
		} else {
			$shopitem .= "http://www.flakon.cz/". "index.php?route=product/product&amp;product_id=". $product['product_id'];
		}
		$shopitem .= "</URL>\n";
		$shopitem .= "<DELIVERY_DATE>0</DELIVERY_DATE>\n";
		if (!$product['image']==0) {
			$shopitem .= "<IMGURL>http://www.flakon.cz/image/".str_replace('%2F','/',rawurlencode($product['image']))."</IMGURL>\n";
		}
		$shopitem .= "<PRICE_VAT>".round($product['price'], 0)."</PRICE_VAT>\n";
		$shopitem .= "</SHOPITEM>\n";
		$body .= $shopitem;
		echo $shopitem;
	}
	unset($query_products);
	$footer = "</SHOP>\n";
	echo $footer;
?>
