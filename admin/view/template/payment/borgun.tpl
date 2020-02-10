<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?>
        <a href="<?php echo $breadcrumb['href']; ?>">
            <?php echo $breadcrumb['text']; ?>
        </a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning">
        <?php echo $error_warning; ?>
    </div>
    <?php } else if ($success) { ?>
    <div class="success">
        <?php echo $success; ?>
    </div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/payment.png" alt="" />
                <?php echo $heading_title; ?>
            </h1>
            <div class="buttons">
                <a onclick="$('#form').submit();" class="button">
                    <?php echo $button_save; ?>
                </a>
                <a onclick="location = '<?php echo $cancel; ?>';" class="button">
                    <?php echo $button_cancel; ?>
                </a>
            </div>
        </div>
        <div class="content">
            <div id="tabs" class="htabs">
                <a href="#tab-general">
                    <?php echo $tab_general; ?>
                </a>
                <a href="#tab-account">
                    <?php echo $tab_account; ?>
                </a>
                <a href="#tab-about">
                    <?php echo $tab_about; ?>
                </a>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div id="tab-general">
                    <table class="form">
                        <tr>
                            <td>
                                <?php echo $entry_enable; ?>
                            </td>
                            <td><select name="borgun_status">
                                    <?php if ($borgun_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_test; ?>
                            </td>
                            <td>
                                <?php if ($borgun_sandbox) { ?>
                                <input type="radio" name="borgun_sandbox" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_sandbox" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="borgun_sandbox" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_sandbox" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <!--
                        <tr>
                            <td><?php echo $entry_total; ?></td>
                            <td><input type="text" name="borgun_total" value="<?php echo $borgun_total; ?>" />
                                <span class="error"><?php if (isset($error_required_total)) { echo $error_required;} ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_geo_zone; ?></td>
                            <td><select name="borgun_geo_zone_id">
                                    <option value="0"><?php echo $text_all_zones; ?></option>
                                    <?php foreach ($geo_zones as $geo_zone) { ?>
                                    <?php if ($geo_zone['geo_zone_id'] == $borgun_geo_zone_id) { ?>
                                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        -->
                        <tr>
                            <td>
                                <?php echo $entry_sort_order; ?>
                            </td>
                            <td><input type="text" name="borgun_sort_order" value="<?php echo $borgun_sort_order; ?>" size="1" /></td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_pagetype; ?>
                            </td>
                            <td>
                                <?php if ($borgun_pagetype) { ?>
                                <input type="radio" name="borgun_pagetype" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_pagetype" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="borgun_pagetype" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_pagetype" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_skipreceiptpage; ?>
                            </td>
                            <td>
                                <?php if ($borgun_skipreceiptpage) { ?>
                                <input type="radio" name="borgun_skipreceiptpage" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_skipreceiptpage" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="borgun_skipreceiptpage" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_skipreceiptpage" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_forwardcustomersname; ?>
                            </td>
                            <td>
                                <?php if ($borgun_forwardcustomersname) { ?>
                                <input type="radio" name="borgun_forwardcustomersname" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_forwardcustomersname" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="borgun_forwardcustomersname" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_forwardcustomersname" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_showadditionalbrands; ?>
                            </td>
                            <td>
                                <?php if ($borgun_showadditionalbrands) { ?>
                                <input type="radio" name="borgun_showadditionalbrands" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_showadditionalbrands" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="borgun_showadditionalbrands" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_showadditionalbrands" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_merchantemail; ?>
                            </td>
                            <td><input type="text" name="borgun_merchantemail" value="<?php echo $borgun_merchantemail; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_merchantlogo; ?>
                            </td>
                            <td><input type="text" name="borgun_merchantlogo" value="<?php echo $borgun_merchantlogo; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_pending_status; ?>
                            </td>
                            <td><select name="borgun_pending_status_id">
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if (($borgun_pending_status_id != "") and ($order_status['order_status_id'] == $borgun_pending_status_id)) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else if (($borgun_pending_status_id == "") and (strtolower($order_status['order_status_id']) == '1')) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_completed_status; ?>
                            </td>
                            <td><select name="borgun_completed_status_id">
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if (($borgun_completed_status_id != "") and ($order_status['order_status_id'] == $borgun_completed_status_id)) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else if (($borgun_completed_status_id == "") and (strtolower($order_status['order_status_id']) == '2')) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_canceled_status; ?>
                            </td>
                            <td><select name="borgun_canceled_status_id" id="input-order-status" class="form-control">
                                    <option value="1313"><?php echo $entry_status_return; ?></option>
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if ((isset($borgun_canceled_status_id)) and ($borgun_canceled_status_id != "") and ($order_status['order_status_id'] == $borgun_canceled_status_id)) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else if ((!isset($borgun_canceled_status_id)) and ($order_status['order_status_id'] == '7')) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_failed_status; ?>
                            </td>
                            <td><select name="borgun_failed_status_id">
                                    <option value="1313"><?php echo $entry_status_return; ?></option>
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if ((isset($borgun_failed_status_id)) and ($borgun_failed_status_id != "") and ($order_status['order_status_id'] == $borgun_failed_status_id)) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else if ((!isset($borgun_failed_status_id)) and ($order_status['order_status_id'] == '10')) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $entry_total_only; ?>
                            </td>
                            <td>
                                <?php if ($borgun_sendtotalonly) { ?>
                                <input type="radio" name="borgun_sendtotalonly" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_sendtotalonly" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="borgun_sendtotalonly" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="borgun_sendtotalonly" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="tab-account">
                    <table>
                        <tr>
                            <td width="450">
                                <table class="form">
                                    <tr>
                                        <td colspan="2">
                                            <h2>
                                                <?php echo $heading_account_title; ?>
                                            </h2>
                                        </td>
                                    </tr>
                                    <?php foreach ($supportedCurrencies as $code => $title): ?>
                                    <tr>
                                        <th colspan="2">
                                            <h3>
                                                <?php echo $available_configuration . $title . " [" . $code . "]" ?>
                                            </h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>
                                            <?php echo $title . " - " . $entry_merchantid; ?>
                                        </td>
                                        <td width="200"><input type="text" name="borgun_merchantid_<?= $code ?>" value="<?php $merchantid = 'borgun_merchantid_'.$code; echo $$merchantid ; ?>" />
                                            <span class="error"><?php if (isset($error_required_merchantid) && empty($$merchantid)) { echo $error_required_merchantid;} ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>
                                            <?php echo $title . " - " . $entry_secretkey; ?>
                                        </td>
                                        <td><input type="text" name="borgun_secretkey_<?= $code ?>" value="<?php $secretkey = 'borgun_secretkey_'.$code; echo $$secretkey; ?>" />
                                            <span class="error"><?php if (isset($error_required_secretkey) && empty($$secretkey)) { echo $error_required_secretkey;} ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>
                                            <?php echo $title . " - " . $entry_paymentgatewayid; ?>
                                        </td>
                                        <td><input type="text" name="borgun_paymentgatewayid_<?= $code ?>" value="<?php $paymentgatewayid = 'borgun_paymentgatewayid_'.$code; echo $$paymentgatewayid; ?>" />
                                            <span class="error"><?php if (isset($error_required_paymentgatewayid) && empty($$paymentgatewayid)) { echo $error_required_paymentgatewayid;} ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php foreach ($disabledCurrencies as $code => $title): ?>
                                    <tr>
                                        <th colspan="2">
                                            <h3>
                                                <?php echo $unavailable_configurations; ?>
                                            </h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p>
                                                <?= $title . " [" . $code . "]" ?> - Not supported by Borgun. </p>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </td>
                            <td valign="top">
                                <?php echo $text_borgun_account_information; ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <!--/tab-account-->
                <div id="tab-about">
                    <p>
                        <?php echo $text_borgun_general_information; ?>
                    </p>
                </div>
            </form>
            <a onclick="location = '<?php echo $notification; ?>';" class="button">
                <?php echo $button_notification; ?>
            </a>
        </div>
    </div>
</div>
<script type="text/javascript">
    <!--
    $('#tabs a').tabs();
    //-->
</script>
<?php echo $footer; ?>