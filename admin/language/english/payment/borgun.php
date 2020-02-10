<?php

// Heading
$_['admin_title'] = 'Borgun Credit Card Payment';
$_['heading_title'] = 'Credit Card Payment (Borgun)';
$_['text_borgun'] = '<a onclick="window.open(\'http://www.b-payment.hu\');"><img width="140" height="123" src="view/image/payment/borgun.png" alt="Borgun" title="Borgun" style="border: 1px solid #EEEEEE;" /></a>';

$_['entry_enable'] = 'Enable';
$_['text_enabled'] = 'Yes';
$_['text_disabled'] = 'No';

$_['entry_sort_order'] = 'Sort order';

$_['entry_merchantemail'] = 'Merchant email<br /><span class="help">If not empty, you will get emails about payments.</span>';
$_['entry_merchantlogo'] = 'Webshop logo on payment page<br /><span class="help">Image that will be displayed in top left position on the payment page above Merchant details.</span>';
$_['entry_forwardcustomersname'] = 'Forward customer\'s name<br /><span class="help">If set no, your customer will have to write down his name in the payment form. Otherwise it will be filled in, but cannot be changed.</span>';
$_['entry_pagetype'] = 'Collect customer details<br /><span class="help">Your customer has to enter its email address, cell number and address if Collect customer details is set to Yes. In this case, if Mechant e-mail is not empty, you will get the customer\'s details to that e-mail address.</span>';
$_['entry_skipreceiptpage'] = 'Skip receipt page<br /><span class="help">If set to yes, the customer will be returned directly after payment to the webshop.</span>';
$_['entry_showadditionalbrands'] = 'Show additional brands<br /><span class="help">You show additional brands if you choose Yes. If you choose No, only Mastercard and Visa brands will be shown on the payment page. It is recommended to turn it off, so your customers will only see the accepted cards.</span>';
$_['entry_completed_status'] = 'Successful payment status<br /><span class="help">Set default status for Successful payment.</span>';
$_['entry_failed_status'] = 'Unsuccessful payment status<br /><span class="help">Set default status for Unsuccessful payment.</span>';
$_['entry_canceled_status'] = 'Canceled payment status<br /><span class="help">Set default status for Canceled payment.</span>';
$_['entry_pending_status'] = 'Pending Status';
$_['entry_test'] = 'Test mode<br /><span class="help">You will be sending TEST transactions if you choose Yes. Please note, that in TEST environment, you need to use test credentials. | Merchant ID: 9275444 | Secret key: 99887766 | Payment gateway ID: 16</span>';
$_['entry_merchantid'] = 'Merchant ID<br /><span class="help">Merchant ID provided by Borgun.</span>';
$_['entry_secretkey'] = 'Secret key<br /><span class="help">Secret key provided by Borgun.</span>';
$_['entry_paymentgatewayid'] = 'Payment gateway ID<br /><span class="help">Payment gateway ID provided by Borgun.</span>';
$_['entry_total_only'] = 'Sent total only<br /><span class="help">Borgun will receive only the total of the order and no detailed info of products, delivery, discounts, etc. will be sent.</span>';

// Text 
$_['text_payment'] = 'Payment';
$_['text_success'] = 'Success: You have modified Borgun Credit Card Payment account details!';

// Entry
$_['entry_total'] = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active. For example: 0.01</span>';
$_['entry_geo_zone'] = 'Geo Zone:<br /><span class="help">The Geo zones the order must reach before this payment method becomes active.</span>';

$_['entry_status_return'] = 'Return to checkout';

// Tab
$_['tab_general'] = 'General';
$_['tab_account'] = 'Account Settings';
$_['tab_about'] = 'About';

$_['heading_account_title'] = 'Account Settings';
$_['available_configuration'] = 'Available Configuration for ';
$_['unavailable_configurations'] = 'Unavailable Configurations: ';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify payment Borgun!';
$_['error_vqmod'] = 'Warning: vQmod does not seem to be installed. <a href="http://code.google.com/p/vqmod/">Get vQmod!</a>';
$_['error_required_merchantid'] = 'Warning: If enabled the payment module <i>Merchant Id</i> by %s Account field can not be empty';
$_['error_required_secretkey'] = 'Warning: If enabled the payment module <i>Secret Key</i> by %s Account field can not be empty';
$_['error_required_paymentgatewayid'] = 'Warning: If enabled the payment module <i>Payment Gateway Id</i> by %s Account field can not be empty';
$_['error_required_merchantemail'] = 'Warning: If enabled the payment module <i>Merchant email</i> by %s Account field can not be empty';
$_['error_borgun_total'] = 'Warning: If enabled the payment module <i>Total</i> field can not be empty';
$_['error_required'] = 'Warning: This field is required';

// Tab text
$_['text_borgun_general_information'] = '<div style="float: right;"><a onclick="window.open(\'http://www.b-payment.hu/\');">
    <img width="140" height="123" src="view/image/payment/borgun.png" alt="Borgun" title="Borgun" style="border: 1px solid #EEEEEE;" /></a></div>
    <p>This plugin integrates Borgun payment page to your webshop. You need to have a contract with Borgun if you would like to accept payments.</p>
                                       <p>Would you like to accept credit cards in your webshop, but you do not have credentials from Borgun? <a href="mailto:info@b-payment.hu">Contact us!</a></p>';
$_['text_borgun_account_information'] = '<p>This plugin integrates Borgun payment page to your webshop. You need to have a contract with Borgun if you would like to accept payments.</p>
                                       <p>Would you like to accept credit cards in your webshop, but you do not have credentials from Borgun? <a href="mailto:info@b-payment.hu">Contact us!</a></p>
									   <p><strong>Please note, that in TEST environment, you need to use test credentials. | Merchant ID: 9275444 | Secret key: 99887766 | Payment gateway ID: 16</strong></p>
									   ';
$_['button_notification'] = 'Send debug information';
?>