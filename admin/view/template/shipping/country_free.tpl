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
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="country_free_status">
                <?php if ($country_free_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="country_free_sort_order" value="<?php echo $country_free_sort_order; ?>" size="1" /></td>
          </tr>
          <tr>
          	<td><?php echo $entry_debug; ?></td>
          	<td><select name="country_free_debug">
                <?php if ($country_free_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_show_teaser; ?></td>
            <td>
            <?php $i = 0; while($i < 3) { $i++; $key = 'teaser_' . $i; $var = 'country_free_'.$key;   $text = 'text_teaser_' . $i; ?>
            <input type="checkbox" name="country_free_<?php echo $key; ?>" <?php echo(isset($$var) ? 'checked' : ''); ?> /><?php echo $$text; ?><br />
            <? } ?>
            </td>
          </tr>
          
          <tr>
          <td>v1.1.6</td>
          <td><a href="http://jorimvanhove.com" target="_blank">Jorim van Hove</a> &copy; 2014-2015 - <a href="http://jorimvanhove.com/plugins/cbfs/" target="_blank">Online documentation</a> - <a href="http://www.geoplugin.com/" target="_new" title="geoPlugin for IP geolocation">Geolocation by geoPlugin</a></td>
          </tr>
        </table>
        
        <table id="country-free-shipping" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_country; ?></td>
              <td class="left"><?php echo $entry_total; ?></td>
              <td class="left"><?php echo $entry_customer_group; ?></td>
              <td></td>
            </tr>
          </thead>
       		<?php $row = 0; ?>
            <?php if (is_array($country_free_shipping)) { ?>
	          <?php foreach ($country_free_shipping as $cfs) { ?>
	          <tbody id="country-free-shipping<?php echo $row; ?>">
	            <tr>
	              <td class="left"><select name="cfs[<?php echo $row; ?>][country_id]" id="country<?php echo $row; ?>">
	                  <?php foreach ($countries as $country) { ?>
	                    <?php  if ($country['country_id'] == $cfs['country_id']) { ?>
	                      <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
	                    <?php } else { ?>
	                      <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
	                    <?php } ?>
	                  <?php } ?>
	                </select></td>                
	              <td><input type="text" size="10" name="cfs[<?php echo $row; ?>][total]" value="<?php echo $cfs['total']; ?>" />
	              	<select name="cfs[<?php echo $row; ?>][type]" id="minimum_order_total">
            			<option value="subtotal" <?php echo $cfs['type'] == 'subtotal' ? 'selected="selected"' : '' ; ?> ><?php echo $text_subtotal; ?></option>
            			<option value="total" <?php echo $cfs['type'] == 'total' ? 'selected="selected"' : '' ; ?> ><?php echo $text_total; ?></option>
            		</select>
            	  </td>
	              <td class="left">
	              	<div class="scrollbox">
                  	<?php $class = 'even'; ?>
	              	<?php foreach ($customer_groups as $customer_group) { ?>
	              		<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  		<div class="<?php echo $class; ?>">
                  		<?php if (in_array($customer_group['customer_group_id'], $cfs['customer_group_id'])) { ?>
						<input type="checkbox" name="cfs[<?php echo $row; ?>][customer_group_id][]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" /><?php echo $customer_group['name']; ?>
						<?php } else { ?>
						<input type="checkbox" name="cfs[<?php echo $row; ?>][customer_group_id][]" value="<?php echo $customer_group['customer_group_id']; ?>"/><?php echo $customer_group['name']; ?>
						<?php } ?>
					  </div>
					  <?php } ?>
					</div>
                  	<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>

	              <td class="left"><a onclick="$('#country-free-shipping<?php echo $row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
	              
	            </tr>
	          </tbody>
	          <?php $row++; ?>
	          <?php } ?>
	        <?php } ?>
          <tfoot>
            <tr>
              <td colspan="2"></td>
              <td class="left"><a onclick="addRow();" class="button"><?php echo $button_add; ?></a></td>
            </tr>
          </tfoot>
        </table>
         <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_freeshippingno; ?></td>
                <td><input type="text" name="country_free_msg[<?php echo $language['language_id']; ?>][no]" size="100" value="<?php echo isset($country_free_msg[$language['language_id']]) ? $country_free_msg[$language['language_id']]['no'] : ''; ?>"/>
              	<?php if (isset($error_no[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_no[$language['language_id']]; ?></span>
                  <?php } ?>
              	</td>
              	<td class=""><div class="attention" id="construct-no-<?php echo $language['language_id']; ?>"></div></td>
              </tr>
              
              <tr>
                <td><span class="required">*</span> <?php echo $entry_freeshippingyes; ?></td>
                <td><input type="text" name="country_free_msg[<?php echo $language['language_id']; ?>][yes]" size="100" value="<?php echo isset($country_free_msg[$language['language_id']]) ? $country_free_msg[$language['language_id']]['yes'] : ''; ?>"/>
              	<?php if (isset($error_yes[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_yes[$language['language_id']]; ?></span>
                  <?php } ?>
              	</td>
              	<td class=""><div class="success" id="construct-yes-<?php echo $language['language_id']; ?>"><div></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_to_country; ?></td>
                <td><input type="text" name="country_free_msg[<?php echo $language['language_id']; ?>][to]" size="100" value="<?php echo isset($country_free_msg[$language['language_id']]) ? $country_free_msg[$language['language_id']]['to'] : ''; ?>" value=""/>
              	<?php if (isset($error_to[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_to[$language['language_id']]; ?></span>
                  <?php } ?>
              	</td>
              </tr>
            </table>
          </div>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
	$('input[name=\'country_free_msg[<?php echo $language['language_id']; ?>][no]\']').keyup(function() {
			fill = $('input[name=\'country_free_msg[<?php echo $language['language_id']; ?>][no]\']').val();
			to = $('input[name=\'country_free_msg[<?php echo $language['language_id']; ?>][to]\']').val();
			$('#construct-no-<?php echo $language['language_id']; ?>').replaceWith('<div class="attention" id="construct-no-<?php echo $language['language_id']; ?>">' + fill.replace('%s', $('input[name=\'cfs[0][total]\']').val()) + ' ' + to.replace('%s', $('select[name=\'cfs[0][country_id]\'] option:selected').text()) + '</div>');
	});
	$('input[name=\'country_free_msg[<?php echo $language['language_id']; ?>][yes]\']').keyup(function() {
			fill = $('input[name=\'country_free_msg[<?php echo $language['language_id']; ?>][yes]\']').val();
			to = $('input[name=\'country_free_msg[<?php echo $language['language_id']; ?>][to]\']').val();
			$('#construct-yes-<?php echo $language['language_id']; ?>').replaceWith('<div class="success" id="construct-yes-<?php echo $language['language_id']; ?>">' + fill + ' ' + to.replace('%s', $('select[name=\'cfs[0][country_id]\'] option:selected').text()) + '</div>');
	});
<?php } ?>
var row = <?php echo $row; ?>;

function addRow() {
	html  = '<tbody id="country-free-shipping' + row + '">';
	html += '<tr>';
	html += '<td class="left"><select name="cfs[' + row + '][country_id]" id="country' + row + '">';
	<?php foreach ($countries as $country) { ?>
	html += '<option value="<?php echo $country['country_id']; ?>"><?php echo addslashes($country['name']); ?></option>';
	<?php } ?>   
	html += '</select></td>';
	html += '<td><input size="10" type="text" name="cfs['+row+'][total]" value="0.00" /> ';
	html += '<select name="cfs['+ row +'][type]" id="minimum_order_total">';
    html += '<option value="subtotal"><?php echo $text_subtotal; ?></option>';
    html += '<option value="total" selected="selected"><?php echo $text_total; ?></option>';
    html += '</select></td>';
	html += '<td class="left"><div class="scrollbox"><?php $class = 'even'; ?>';
	<?php foreach ($customer_groups as $customer_group) { ?>
	html += '<?php $class = ($class == 'even' ? 'odd' : 'even'); ?><div class="<?php echo $class; ?>">';
	html += '<input type="checkbox" name="cfs[' + row + '][customer_group_id][]" value="<?php echo $customer_group['customer_group_id']; ?>"/><?php echo $customer_group['name']; ?></div>';
	<?php } ?>   
	html += '<a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a></td>';
	html += '<td class="left"><a onclick="$(\'#country-free-shipping' + row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '</tr>';
	html += '</tbody>';
	
	$('#country-free-shipping > tfoot').before(html);
	
	row++;
}

$('#languages a').tabs(); 

//--></script> 

<?php echo $footer; ?> 