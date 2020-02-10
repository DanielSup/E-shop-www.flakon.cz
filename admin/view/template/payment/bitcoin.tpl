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
  
  <?php if ($max_order_amount) { ?>

  <div class="warning"><?php echo $max_order_amount; ?></div>

  <?php } ?>

  <div class="box">

    <div class="heading">

      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>

      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>

    </div>

    <div class="content">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        	<table class="form">

          <tr>

            <td><?php echo $text_merchant_id; ?></td>

            <td><input type="text" name="bitcoin_merchant_id" value="<?php echo $bitcoin_merchant_id; ?>" placeholder="<?php echo $text_merchant_id; ?>" id="input-bitcoin_merchant_id" class="form-control" /></td>

          </tr>

          <tr>

            <td><?php echo $text_merchant_vector; ?></td>

            <td><input type="text" name="bitcoin_merchant_vector" value="<?php echo $bitcoin_merchant_vector; ?>" placeholder="<?php echo $text_merchant_vector; ?>" id="input-bitcoin_merchant_id" class="form-control" /></td>

          </tr>

          <tr>

            <td><?php echo $text_merchant_key; ?></td>

            <td><input type="text" name="bitcoin_merchant_key" value="<?php echo $bitcoin_merchant_key; ?>" placeholder="<?php echo $text_merchant_key; ?>" id="input-bitcoin_merchant_key" class="form-control" /></td>

          </tr>

          <tr>

            <td><?php echo $text_bitcoin_currency; ?></td>

            <td><input type="text" name="bitcoin_currency" value="<?php echo $bitcoin_currency; ?>" placeholder="<?php echo $text_bitcoin_currency; ?>" id="input-bitcoin_currency" class="form-control" /></td>

          </tr>

          <tr>

            <td><?php echo $entry_total; ?></td>

            <td><input type="text" name="bitcoin_total" value="<?php echo $bitcoin_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" /></td>

          </tr>

          <tr>

            <td><?php echo $entry_order_status_fail; ?></td>

            <td><select name="bitcoin_order_status_fail_id" id="input-order-status-fail" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $bitcoin_order_status_fail_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>

          </tr>          

          <tr>

            <td><?php echo $entry_order_status_success; ?></td>

            <td><select name="bitcoin_order_status_success_id" id="input-order-status-success" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $bitcoin_order_status_success_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>

          </tr>

          <tr>

            <td><?php echo $entry_geo_zone; ?></td>

            <td><select name="bitcoin_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $bitcoin_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>

          </tr>

          <tr>

            <td><?php echo $entry_status; ?></td>

            <td><select name="bitcoin_status" id="input-status" class="form-control">
                <?php if ($bitcoin_status) { ?>
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

            <td><input type="text" name="bitcoin_sort_order" value="<?php echo $bitcoin_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>

          </tr>

        </table>
        </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>