<?php

// Heading
$_['admin_title'] = 'Borgun platba kartou';
$_['heading_title'] = 'Credit Card Payment (Borgun)';
$_['text_borgun'] = '<a onclick="window.open(\'http://www.b-payment.cz\');"><img width="140" height="123" src="view/image/payment/borgun.png" alt="Borgun" title="Borgun" style="border: 1px solid #EEEEEE;" /></a>';

$_['entry_enable'] = 'Umožnit';
$_['text_enabled'] = 'Ano';
$_['text_disabled'] = 'Ne';

$_['entry_sort_order'] = 'Uspořádání';

$_['entry_merchantemail'] = 'Email obchodníka<br /><span class="help">V případě vyplnění budete dostávat emaily o platbách.</span>';
$_['entry_merchantlogo'] = 'Logo eshopu na platební bráně<br /><span class="help">Obrázek který se zobrazí na horní straně platební brány vlevo nad identifikaci obchodníka.</span>';
$_['entry_forwardcustomersname'] = 'Přeposlání jména zákazníka<br /><span class="help">V případě volby ne, bude muset zákazník vyplnit svoje jméno v rámci platební brány. V případě volby ano  bude předvyplněné, ale nemůže se změnit.</span>';
$_['entry_pagetype'] = 'Sbírání dat zákazníka<br /><span class="help">V případě volby ano musí Váš zákazník vyplnit email, číslo telefonu a adresu. V tomto případě, máte-li vyplněný email obchodníka, tak na něj tyto data budou přeposílány.</span>';
$_['entry_skipreceiptpage'] = 'Přeskočit potvrzení o přijení<br /><span class="help">V případě volby ano, bude zákazník po platbě přesměrován do eshopu.</span>';
$_['entry_showadditionalbrands'] = 'Zobrazení dalších brandů<br /><span class="help">Volbou ano zobrazíte další karetní značky. V případě zobrazení volby Ne se na platební bráně zobrazí jen MasterCard a VISA. Doporučujeme nastavení volby Ne, aby kienti viděli jen podporované značky.</span>';
$_['entry_completed_status'] = 'Status úspěšné platby<br /><span class="help">Volba výchozího stavu pro úspěšnou platbu.</span>';
$_['entry_failed_status'] = 'Status neúspěšné platby<br /><span class="help">Volba výchozího stavu pro neúspěšnou platbu.</span>';
$_['entry_canceled_status'] = 'Statuc zrušené platby<br /><span class="help">Volba výchozího stavu pro zrušenou platbu</span>';
$_['entry_pending_status'] = 'Pending Status';
$_['entry_test'] = 'Testovací režim<br /><span class="help">V případě volby ano budete provádět testovací transakce. Berte na vědomí, že v případě testovacího prostředí musíte použit nastavení testovacích parametrů integrace. | Merchant ID: 9275444 | Secret key: 99887766 | Payment gateway ID: 16</span>';
$_['entry_merchantid'] = 'Merchant ID<br /><span class="help">Číslo obchodníka od společnosti Borgun</span>';
$_['entry_secretkey'] = 'Secret key<br /><span class="help">Tajný klíč vygenerovaný společností Borgun</span>';
$_['entry_paymentgatewayid'] = 'Payment gateway ID<br /><span class="help">Identifikační číslo platební brány od společnosti Borgun</span>';
$_['entry_total_only'] = 'Sent total only<br /><span class="help">Borgun will receive only the total of the order and no detailed info of products, delivery, discounts, etc. will be sent.</span>';

// Text 
$_['text_payment'] = 'Payment';
$_['text_success'] = 'Success: You have modified Borgun Credit Card Payment account details!';

// Entry
$_['entry_total'] = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active. For example: 0.01</span>';
$_['entry_geo_zone'] = 'Geo Zone:<br /><span class="help">The Geo zones the order must reach before this payment method becomes active.</span>';

$_['entry_status_return'] = 'Return to checkout';

// Tab
$_['tab_general'] = 'Obecné nastavení';
$_['tab_account'] = 'Nastavení účtu';
$_['tab_about'] = 'Informace';

$_['heading_account_title'] = 'Nastavení měny';
$_['available_configuration'] = 'K dispozici měna: ';
$_['unavailable_configurations'] = 'Nedostupné měna: ';

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
$_['text_borgun_general_information'] = '<div style="float: right;"><a onclick="window.open(\'http://www.b-payment.cz/\');">
    <img width="140" height="123" src="view/image/payment/borgun.png" alt="Borgun" title="Borgun" style="border: 1px solid #EEEEEE;" /></a></div>
    <p>Plugin integruje platební bránu Borgun do Vašeho eshopu. Abyste mohli přijímat platby kartou, musíte mít podepsanou smlouvu se společností Borgun</p>
                                       <p>Chtěli byste přijímat platby kartami ve Vašem obchodě, ale nemáte podklady od Borgunu? <a href="mailto:info@b-payment.cz">Kontaktujte nás!</a></p>';
$_['text_borgun_account_information'] = '<p>Plugin integruje platební bránu Borgun do Vašeho eshopu. Abyste mohli přijímat platby kartou, musíte mít podepsanou smlouvu se společností Borgun</p>
                                       <p>Chtěli byste přijímat platby kartami ve Vašem obchodě, ale nemáte podklady od Borgunu? <a href="mailto:info@b-payment.cz">Kontaktujte nás!</a></p>';
$_['button_notification'] = 'Send debug information';
?>