<?php
class ModelSaleDiscountAndy extends Model {
	public function addDiscount_andy($data,$ids_customer_groups) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "discount_andy SET name = '" . $this->db->escape($data['name']) . "', discount = '" . (float)$data['discount'] . "', type = '" . $this->db->escape($data['type']) . "', total = '" . (float)$data['total'] . "', logged = '" . (int)$data['logged'] . "', shipping = '" . (int)$data['shipping'] . "',groups_id='".$ids_customer_groups."', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', uses_total = '" . (int)$data['uses_total'] . "', uses_customer = '" . (int)$data['uses_customer'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

      	$discount_andy_id = $this->db->getLastId();
		
		if (isset($data['discount_andy_product'])) {
      		foreach ($data['discount_andy_product'] as $product_id) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "discount_andy_product SET discount_andy_id = '" . (int)$discount_andy_id . "', product_id = '" . (int)$product_id . "'");
      		}			
		}
	}
	
	public function editDiscount_andy($discount_andy_id,$ids_customer_groups, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "discount_andy SET name = '" . $this->db->escape($data['name']) . "', discount = '" . (float)$data['discount'] . "', type = '" . $this->db->escape($data['type']) . "', total = '" . (float)$data['total'] . "', logged = '" . (int)$data['logged'] . "', shipping = '" . (int)$data['shipping'] . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', uses_total = '" . (int)$data['uses_total'] . "',groups_id='".$ids_customer_groups."', uses_customer = '" . (int)$data['uses_customer'] . "', status = '" . (int)$data['status'] . "' WHERE discount_andy_id = '" . (int)$discount_andy_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "discount_andy_product WHERE discount_andy_id = '" . (int)$discount_andy_id . "'");
		
		if (isset($data['discount_andy_product'])) {
      		foreach ($data['discount_andy_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "discount_andy_product SET discount_andy_id = '" . (int)$discount_andy_id . "', product_id = '" . (int)$product_id . "'");
      		}
		}		
	}
	
	public function deleteDiscount_andy($discount_andy_id) {
      	$this->db->query("DELETE FROM " . DB_PREFIX . "discount_andy WHERE discount_andy_id = '" . (int)$discount_andy_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "discount_andy_product WHERE discount_andy_id = '" . (int)$discount_andy_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "discount_andy_history WHERE discount_andy_id = '" . (int)$discount_andy_id . "'");		
	}
	
	public function getDiscount_andy($discount_andy_id) {
      	$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "discount_andy WHERE discount_andy_id = '" . (int)$discount_andy_id . "'");
		
		return $query->row;
	}
		
	public function getDiscounts_andy($data = array()) {
		$sql = "SELECT discount_andy_id, name, discount, date_start, date_end, status FROM " . DB_PREFIX . "discount_andy";
		
		$sort_data = array(
			'name',
			'discount',
			'date_start',
			'date_end',
			'status'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}		
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getDiscount_Andy_Products($discount_andy_id) {
		$discount_andy_product_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "discount_andy_product WHERE discount_andy_id = '" . (int)$discount_andy_id . "'");
		
		foreach ($query->rows as $result) {
			$discount_andy_product_data[] = $result['product_id'];
		}
		
		return $discount_andy_product_data;
	}
	
	public function getTotalDiscount_andy() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "discount_andy");
		
		return $query->row['total'];
	}	
	
	public function getDiscount_Andy_Histories($discount_andy_id, $start = 0, $limit = 10) {
		$query = $this->db->query("SELECT ch.order_id, CONCAT(c.firstname, ' ', c.lastname) AS customer, ch.amount, ch.date_added FROM " . DB_PREFIX . "discount_andy_history ch LEFT JOIN " . DB_PREFIX . "customer c ON (ch.customer_id = c.customer_id) WHERE ch.discount_andy_id = '" . (int)$discount_andy_id . "' ORDER BY ch.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}
	
	public function getTotalDiscount_Andy_Histories($discount_andy_id) {
	  	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "discount_andy_history WHERE discount_andy_id = '" . (int)$discount_andy_id . "'");

		return $query->row['total'];
	}		

	public function drop_tables()
	{
	$this->db->query("DROP TABLE " . DB_PREFIX . "discount_andy;");
	$this->db->query("DROP TABLE " . DB_PREFIX . "discount_andy_history;");
	$this->db->query("DROP TABLE " . DB_PREFIX . "discount_andy_product;");
	}
	
	
	public function get_customer_groups()
	{
		$query = $this->db->query("SELECT " . DB_PREFIX . "customer_group.customer_group_id, name FROM " . DB_PREFIX . "customer_group LEFT JOIN " . DB_PREFIX . "customer_group_description ON " . DB_PREFIX . "customer_group.customer_group_id=" . DB_PREFIX . "customer_group_description.customer_group_id WHERE language_id=".$this->config->get('config_language_id')." ORDER BY name ASC");
		$customer_groups=null;
		foreach ($query->rows as $result) 
		{
			$customer_groups[$result['name']] = $result['customer_group_id'];
		}
		
		return $customer_groups;
	}
	

public function getProducts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
		
		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
		}
				
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		//adaugat de mine
		if (!empty($data['filter_category_id'])) {
			$sql .= " AND p2c.category_id = " . $this->db->escape($data['filter_category_id']);
		}
		//

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}
		
		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}
		
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$sql .= " GROUP BY p.product_id";
					
		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY pd.name";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	
	
	
	
	
	public function create_tables() 
	{	
	//CREATE table discount_andy
	$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "discount_andy (`discount_andy_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`type` char(1) COLLATE utf8_bin NOT NULL,
	`discount` decimal(15,4) NOT NULL,
	`logged` tinyint(1) NOT NULL DEFAULT '0',
	`shipping` tinyint(1) NOT NULL DEFAULT '0',
	`total` decimal(15,4) NOT NULL,
	`date_start` date NOT NULL DEFAULT '0000-00-00',
	`date_end` date NOT NULL DEFAULT '0000-00-00',
	`uses_total` int(11) NOT NULL,
	`uses_customer` varchar(11) COLLATE utf8_bin NOT NULL,
	`groups_id` varchar(255) COLLATE utf8_bin NOT NULL,
	`status` tinyint(1) NOT NULL DEFAULT '0',
	`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`discount_andy_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;");

	// ADD TEST DATA TO TABLE
	$this->db->query("INSERT INTO " . DB_PREFIX . "discount_andy (`discount_andy_id`, `name`, `type`, `discount`, `logged`, `shipping`, `total`, `date_start`, `date_end`, `uses_total`, `uses_customer`, `status`, `date_added`) VALUES
(1, '-10% Discount', 'P', 10.0000, 0, 0, 999.0000, '2011-01-01', '2023-11-22', 0, '0', 1, '2013-01-27 13:55:03');");
	
	
	//CREATE table discount_andy_history
	$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "discount_andy_history (
	`discount_andy_history_id` int(11) NOT NULL AUTO_INCREMENT,
	`discount_andy_id` int(11) NOT NULL,
	`order_id` int(11) NOT NULL,
	`customer_id` int(11) NOT NULL,
	`amount` decimal(15,4) NOT NULL,
	`date_added` datetime NOT NULL,
	PRIMARY KEY (`discount_andy_history_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;");
	
	//CREATE table discount_andy_product
	$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "discount_andy_product (
	`discount_andy_product_id` int(11) NOT NULL AUTO_INCREMENT,
	`discount_andy_id` int(11) NOT NULL,
	`product_id` int(11) NOT NULL,
	PRIMARY KEY (`discount_andy_product_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;");
	}
	
}
?>