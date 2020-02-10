<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
  <meta charset="windows-1250"> 
    <title></title> 
</head> 
<body>
    <?php
    
    require_once 'config.php';
    

            $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
            mysqli_query("SET NAMES 'cp1250'");
            $query = mysqli_query($con, "SELECT  `oc_product`.`product_id` ,  `oc_product`.`image` ,  `oc_product`.`price` ,  `oc_product_description`.`name` ,  `oc_product_description`.`description` 
FROM  `oc_product` ,  `oc_product_description` 
WHERE  `oc_product_description`.`product_id` =  `oc_product`.`product_id` 
AND  `oc_product_description`.`language_id` =2
AND  `oc_product`.`quantity` >=1
AND  `oc_product`.`status` =1");
            foreach ($query as $row) {
                $product_description = str_replace('&amp;', '&', $row["description"]);
		$product_description = str_replace('&amp;nbsp;', '', $product_description);
		$product_description = strip_tags(html_entity_decode(stripslashes(nl2br($product_description)),ENT_NOQUOTES,"windows-1250"));
                echo "$product_description";
            }
    ?>
?> 
</BODY> 
</HTML> 