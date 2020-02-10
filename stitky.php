
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <?php
    require_once 'config.php';
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
    if (isset($_GET["order"])) {
        $query = $db->query("SELECT * FROM ". DB_PREFIX ."order WHERE order_id=".$_GET["order"]);
        echo "<p style=\"padding: 0; margin: 0 0 0 12%; border:0\">Marcel Šup – www.flakon.cz</p>";
		echo "<p style=\"padding: 0; margin: 0 0 0 12%; border:0\">Ke Kapli 258</p>";
		echo "<p style=\"padding: 0; margin: 0 0 0 12%; border:0\">267 18 Bubovice</p>";
		foreach($query->rows as $row){
			$name = $row["shipping_firstname"]." ".$row["shipping_lastname"];
			$comp = $row["shipping_company"];
			$add1 = $row["shipping_address_1"];
			$add2 = $row["shipping_address_2"];
			$city = $row["shipping_postcode"]." ".$row["shipping_city"];
			$country = $row["shipping_country"];
			$shipping_method1=explode("(", $row["shipping_method"])[0];
			$shipping_method=explode("\n", $shipping_method1)[0];
			if($row["shipping_code"] == "DPD.DPD") {
				$shipping_method = "DPD";
			}
			$maxName = 160;
			if(mb_strlen($name) > 21){
				$maxName = 3360/mb_strlen($name);
			}
			if(mb_strlen($comp) > 25){
				if($maxName > 4000/mb_strlen($comp)){
					$maxName = 4000/mb_strlen($comp);
				}
			}
			if(mb_strlen($add1) > 25){
				if($maxName > 4000/mb_strlen($add1)){
					$maxName = 4000/mb_strlen($add1);
				}
			}
			if(mb_strlen($add2) > 25){
				if($maxName > 4000/mb_strlen($add2)){
					$maxName = 4000/mb_strlen($add2);
				}
			}
			if(mb_strlen($city) > 25){
				if($maxName > 4000/mb_strlen($city)){
					$maxName = 4000/mb_strlen($city);
				}
			}
			if(mb_strlen($country) > 25){
				if($maxName > 4000/mb_strlen($country)){
					$maxName = 4000/mb_strlen($country);
				}
			}
			
			$czech_string_len = strlen("Dobírka");
			$english_string_len = strlen("Cash On Delivery");
			if(substr($row["payment_method"], 0, $czech_string_len) != "Dobírka" && substr($row["payment_method"], 0, $english_string_len) != "Cash On Delivery" ){
				if($row["shipping_country"] != "Czech Republic"){
					echo "<p style=\"padding: 0; margin: 0 0 0 12%; border:0\">Czech Republic</p>";
					echo "<p style=\" padding: 0; margin: 5% 0 0 12%;\">".$shipping_method."</p>";
					if(empty($comp)){
						if(empty($add2)){
						echo "<p style=\" padding: 0; margin: 17% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						} else {
							echo "<p style=\" padding: 0; margin: 10% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						}
					} else {
						if(empty($add2)){
						echo "<p style=\" padding: 0; margin: 11% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						} else {
							echo "<p style=\" padding: 0; margin: 4% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						}
						echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$comp."</p>";
					}
					echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$add1."</p>";
					echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$add2."</p>";
					echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$city."</p>";
					echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$country."</p>";
					echo "<p style=\" padding: 0; margin: 0 0 0 55%;\">".$row["email"]."</p>";
					echo "<p style=\" padding: 0; margin: 0 0 0 55%;\">".$row["telephone"]."</p>";
				} else {
					echo "<p style=\" padding: 0; margin: 5% 0 0 12%;\">".$shipping_method."</p>";
					if(empty($comp)){
						if(empty($add2)){
						echo "<p style=\" padding: 0; margin: 23% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						} else {
							echo "<p style=\" padding: 0; margin: 16% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						}
					} else {
						if(empty($add2)){
						echo "<p style=\" padding: 0; margin: 17% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						} else {
							echo "<p style=\" padding: 0; margin: 14% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						}
						echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$comp."</p>";
					}
					echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$add1."</p>";
					echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$add2."</p>";
					echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$city."</p>";
					echo "<p style=\" padding: 0; margin: 0 0 0 55%;\">".$row["email"]."</p>";
					echo "<p style=\" padding: 0; margin: 0 0 0 55%;\">".$row["telephone"]."</p>";
				}
			} else {
				echo "<p style=\" padding: 0; margin: 3% 0 0 12%;\">".$shipping_method."</p>";
				if($row["total"]-intval($row["total"]) >= 0.5){
					echo "<p style=\"padding: 0; margin: 3% 0 0 12%; border:0\">Dobírka: ".(intval($row["total"])+1)." Kč</p>";
					echo "<p style=\"padding: 0; margin: 0 0 0 12%; border:0\">".byWords(intval($row["total"])+1, TRUE)."</p>";
				} else {
					echo "<p style=\"padding: 0; margin: 3% 0 0 12%; border:0\">Dobírka: ".intval($row["total"])." Kč</p>";
					echo "<p style=\"padding: 0; margin: 0 0 0 12%; border:0\">".byWords(intval($row["total"]), TRUE)."</p>";
				}

				if(empty($comp)){
						if(empty($add2)){
						echo "<p style=\" padding: 0; margin: 19% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						} else {
							echo "<p style=\" padding: 0; margin: 12% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						}
					} else {
						if(empty($add2)){
						echo "<p style=\" padding: 0; margin: 13% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						} else {
							echo "<p style=\" padding: 0; margin: 6% 0 0 55%; font-weight: bold; font-size:".$maxName."%\">".$name."</p>";
						}
						echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$comp."</p>";
					}
				echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$add1."</p>";
				echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$add2."</p>";
				echo "<p style=\" padding: 0; margin: 0 0 0 55%; font-size:".$maxName."%\">".$city."</p>";
				echo "<p style=\" padding: 0; margin: 0 0 0 55%;\">".$row["email"]."</p>";
				echo "<p style=\" padding: 0; margin: 0 0 0 55%;\">".$row["telephone"]."</p>";
			}
		}
    }
	function byWords($value, $bool){
		$arr00 = array("jedna","dvě","tři","čtyři","pět","šest","sedm","osm","devět");
		$arr001 = array("jedenáct","dvanáct","třináct","čtrnáct","patnáct","šestnáct","sedmnáct","osmnáct","devatenáct");
		if($value < 10){
			if($value==0){
				return "";
			}
			return $arr00[$value-1];
		}
		if($value < 20){
			if($value == 10){
				return "deset";
			}
			return $arr001[$value - 11];
		}
		$arr01 = array("deset","dvacet","třicet","čtyřicet","padesát","šedesát","sedmdesát","osmdesát","devadesát");
		if($value < 100){
			if($value%10 == 2){
				return $arr01[intval($value/10-1)]."dva";
			} else {
				return $arr01[intval($value/10-1)].byWords(intval($value%10), FALSE);
			}
		}
		if($value < 1000){
			if(intval($value/100) == 1){
				if($bool == TRUE){
					return "jednosto".byWords(intval($value%100), FALSE);
				} else {
					return "sto".byWords(intval($value%100), FALSE);
				}
			}
			if(intval($value/100) == 2){
				return "dvěstě".byWords(intval($value%100), FALSE);
			}
			if(intval($value/100) < 5){
				return $arr00[intval($value/100-1)]."sta".byWords(intval($value%100), FALSE);
			} else {
				return $arr00[intval($value/100-1)]."set".byWords(intval($value%100), FALSE);
			}
		} else if ($value < 1000000){
			if(intval($value/1000) == 1){
				if($bool == TRUE){
					return "jedentisíc".byWords(intval($value%1000), FALSE);
				} else {
					return "tisíc".byWords(intval($value%1000), FALSE);
				}
			}
			if(intval($value/1000) == 2){
				return "dvatisíce".byWords(intval($value%1000), FALSE);
			}
			if(intval($value/1000) < 5){
				return $arr00[intval($value/1000-1)]."tisíce".byWords(intval($value%1000), FALSE);
			} else {
				return byWords(intval($value/1000), FALSE)."tisíc".byWords(intval($value%1000), FALSE);
			}
		}  else if ($value < 1000000000){
			if(intval($value/1000000) == 1){
				if($bool == TRUE){
					return "jedenmilion".byWords(intval($value%1000000), FALSE);
				} else {
					return "milion".byWords(intval($value%1000000), FALSE);
				}
			}
			if(intval($value/1000000) == 2){
				return "dvamiliony".byWords(intval($value%1000), FALSE);
			}
			if(intval($value/1000000) < 5){
				return $arr00[intval($value/1000000-1)]."miliony".byWords(intval($value%1000000), FALSE);
			} else {
				return byWords(intval($value/1000000), FALSE)."milionů".byWords(intval($value%1000000), FALSE);
			}
		} else {
			if(intval($value/1000000000) == 1){
				return "jednamiliarda".byWords(intval($value%1000000000), FALSE);
			}
			if(intval($value/1000000000) == 2){
				return "dvěmiliardy".byWords(intval($value%1000000000), FALSE);
			}
			if(intval($value/1000000000) < 5){
				return $arr00[intval($value/1000000000-1)]."miliardy".byWords(intval($value%1000000000), FALSE);
			} else {
				return byWords(intval($value/1000000000), FALSE)."miliard".byWords(intval($value%1000000000), FALSE);
			}
		}
	}
    ?>
</body>
</html>

