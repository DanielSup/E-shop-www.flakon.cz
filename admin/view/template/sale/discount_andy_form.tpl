<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a>
        <?php if ($discount_andy_id) { ?>
        <a href="#tab-history"><?php echo $tab_discount_andy_history; ?></a>
        <?php } ?>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_name; ?></td>
              <td><input name="name" value="<?php echo $name; ?>" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            
            <tr>
              <td><?php echo $entry_type; ?></td>
              <td><select name="type">
                  <?php if ($type == 'P') { ?>
                  <option value="P" selected="selected"><?php echo $text_percent; ?></option>
                  <?php } else { ?>
                  <option value="P"><?php echo $text_percent; ?></option>
                  <?php } ?>
                  <?php if ($type == 'F') { ?>
                  <option value="F" selected="selected"><?php echo $text_amount; ?></option>
                  <?php } else { ?>
                  <option value="F"><?php echo $text_amount; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_discount; ?></td>
              <td><input type="text" name="discount" value="<?php echo $discount; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_total; ?></td>
              <td><input type="text" name="total" value="<?php echo $total; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_logged; ?></td>
              <td><?php if ($logged) { ?>
                <input type="radio" name="logged" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="logged" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="logged" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="logged" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
			
			<tr>
              <td><span class="required">*</span> <?php echo $entry_customer_groups; ?></td>
			  <td>
			   <?php if ($error_customer_group) { ?>
                  <span class="error"><?php echo $error_customer_group; ?></span>
                  <?php } ?>
				  <div class="scrollbox">
			  <?php foreach ($customer_group_ids as $customer_group_id=>$customer_group_name) {
			  $name = array_keys($customer_group_name);
			  $value = array_values($customer_group_name);
			  ?>
              <input type="checkbox" <?php if($value[0]==1){ echo "checked";} ?> onclick="$(this).attr('value', this.checked ? 1 : 0)" name="customer_group_ids[<?php echo (int)$customer_group_id; ?>][<?php echo $name[0]; ?>]" value="<?php echo $value[0]; ?>"  /><label for="customer_group_ids[<?php echo (int)$customer_group_id; ?>][<?php echo $name[0]; ?>]"><?php echo $name[0]; ?></label></br><?php }?></div></td>
            </tr>
			
			
            <tr>
              <td><?php echo $entry_shipping; ?></td>
              <td><?php if ($shipping) { ?>
                <input type="radio" name="shipping" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="shipping" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="shipping" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="shipping" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_category; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="category[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?> </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_product; ?></td>
              <td><input type="text" name="product" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="discount_andy-product" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($discount_andy_product as $discount_andy_product) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="discount_andy-product<?php echo $discount_andy_product['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $discount_andy_product['name']; ?><img src="view/image/delete.png" />
                    <input type="hidden" name="discount_andy_product[]" value="<?php echo $discount_andy_product['product_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_date_start; ?></td>
              <td><input type="text" name="date_start" value="<?php echo $date_start; ?>" size="12" id="date-start" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_date_end; ?></td>
              <td><input type="text" name="date_end" value="<?php echo $date_end; ?>" size="12" id="date-end" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_uses_total; ?></td>
              <td><input type="text" name="uses_total" value="<?php echo $uses_total; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_uses_customer; ?></td>
              <td><input type="text" name="uses_customer" value="<?php echo $uses_customer; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
          </table>
        </div>
        <?php if ($discount_andy_id) { ?>
        <div id="tab-history">
          <div id="history"></div>
        </div>
        <?php } ?>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'category[]\']').bind('change', function() {
	var filter_category_id = this;
	
	$.ajax({
		url: 'index.php?route=sale/discount_andy/autocomplete&token=<?php echo $token; ?>&filter_category_id=' +  filter_category_id.value + '&limit=10000',
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				if ($(filter_category_id).attr('checked') == 'checked') {
					$('#discount_andy-product' + json[i]['product_id']).remove();
					
					$('#discount_andy-product').append('<div id="discount_andy-product' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="view/image/delete.png" /><input type="hidden" name="discount_andy_product[]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					$('#discount_andy-product' + json[i]['product_id']).remove();
				}			
			}
			
			$('#discount_andy-product div:odd').attr('class', 'odd');
			$('#discount_andy-product div:even').attr('class', 'even');			
		}
	});
});

$('input[name=\'product\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#discount_andy-product' + ui.item.value).remove();
		
		$('#discount_andy-product').append('<div id="discount_andy-product' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="discount_andy_product[]" value="' + ui.item.value + '" /></div>');

		$('#discount_andy-product div:odd').attr('class', 'odd');
		$('#discount_andy-product div:even').attr('class', 'even');
		
		$('input[name=\'product\']').val('');
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#discount_andy-product div img').live('click', function() {
	$(this).parent().remove();
	
	$('#discount_andy-product div:odd').attr('class', 'odd');
	$('#discount_andy-product div:even').attr('class', 'even');	
});
//--></script> 
<script type="text/javascript"><!--
$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
//--></script>
<?php if ($discount_andy_id) { ?>
<script type="text/javascript"><!--
$('#history .pagination a').live('click', function() {
	$('#history').load(this.href);
	
	return false;
});			

$('#history').load('index.php?route=sale/discount_andy/history&token=<?php echo $token; ?>&discount_andy_id=<?php echo $discount_andy_id; ?>');
//--></script>
<?php } ?>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script> 
<?php echo $footer; ?>