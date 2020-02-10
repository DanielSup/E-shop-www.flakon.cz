<?php

// Heading
$_['admin_title'] = 'Borgun kártyás fizetés';
$_['heading_title'] = 'Kártyás fizetés (Borgun)';
$_['text_borgun'] = '<a onclick="window.open(\'http://www.b-payment.hu\');"><img width="140" height="123" src="view/image/payment/borgun.png" alt="Borgun" title="Borgun" style="border: 1px solid #EEEEEE;" /></a>';

$_['entry_enable'] = 'Engedélyezés';
$_['text_enabled'] = 'Igen';
$_['text_disabled'] = 'Nem';

$_['entry_sort_order'] = 'Sorrend';

$_['entry_merchantemail'] = 'Kereskedő email<br /><span class="help">Ha ki van töltve, e-maileket fogsz kapni a fizetésekről.</span>';
$_['entry_merchantlogo'] = 'Webshop logo a fizetési oldalon<br /><span class="help">Ez a kép fog megjelenni a fizetési oldal bal felső sarkában a kereskedői adatoknál.</span>';
$_['entry_forwardcustomersname'] = 'Vásárló nevének továbbítása<br /><span class="help">Ha ki van kapcsolva, akkor a vásárlónak meg kell adnia a nevét a fizetési oldalon. Ha be van kapcsolva, akkor ki van töltve automatikusan, viszont nem lehet azt megváltoztatni.</span>';
$_['entry_pagetype'] = 'Vásárló adatainak begyűjtése<br /><span class="help">Ha be van kapcsolva, akkor a vásárlónak meg kell adni az email címét, telefonszámát és címet a fizetési oldalon. Ebben az esetben, ha a kereskedői email cím ki van töltve, akkor ezek az adatok belekerülnek az értesítő emailekbe.</span>';
$_['entry_skipreceiptpage'] = 'Elismervény oldal kihagyása<br /><span class="help">Ha be van kapcsolva, akkor a vásárló automatikusan visszairányítódik a webshopba a fizetés után.</span>';
$_['entry_showadditionalbrands'] = 'Extra kártyatípusok mutatása<br /><span class="help">Ha be van kapcsolva, akkor az összes kártyatársaság logója megjelenik a fizetési oldalon. Ha nincs, akkor csak a Mastercard és Visa brandek. Javasolt kikapcsolni, mert egyéb esetben félrevezető lehet az elfogadott kártyákról adott információ.</span>';
$_['entry_completed_status'] = 'Sikeres fizetés státusza<br /><span class="help">Válaszd ki, mi legyen sikeres fizetés esetén a rendelések státusza.</span>';
$_['entry_failed_status'] = 'Sikertelen fizetés státusza<br /><span class="help">Válaszd ki, mi legyen sikertelen fizetés esetén a rendelések státusza.</span>';
$_['entry_canceled_status'] = 'Megszakított fizetés státusza<br /><span class="help">Válaszd ki, mi legyen megszakított fizetés esetén a rendelések státusza.</span>';
$_['entry_pending_status'] = 'Pending Status';
$_['entry_test'] = 'Teszt mód<br /><span class="help">Teszt módban nem valós tranzakciók történnek, a vásárlási folyamat kipróbálása a cél. Teszt módban teszt azonosítókat kell használni. | Kereskedő AZ: 9275444 | Titkos kulcs: 99887766 | Fizetési átjáró AZ: 16</span>';
$_['entry_merchantid'] = 'Kereskedő azonosító<br /><span class="help">Borguntól kapott kereskedő azonosító</span>';
$_['entry_secretkey'] = 'Titkos kulcs<br /><span class="help">Borguntól kapott titkos kulcs</span>';
$_['entry_paymentgatewayid'] = 'Fizetési árjáró azonosító<br /><span class="help">Borguntól kapott fizetési átjáró azonosító</span>';
$_['entry_total_only'] = 'Sent total only<br /><span class="help">Borgun will receive only the total of the order and no detailed info of products, delivery, discounts, etc. will be sent.</span>';

// Tab
$_['tab_general'] = 'Általános';
$_['tab_account'] = 'Kereskedői kulcsok';
$_['tab_about'] = 'Információ';
$_['heading_account_title'] = 'Devizák beállítása';
$_['available_configuration'] = 'Elérhető deviza: ';
$_['unavailable_configurations'] = 'Nem elérhető deviza: ';

// Error
$_['error_permission'] = 'Figyelmeztetés: Nincs jogosultsága módosítani a Borgun fizetési modult!';
$_['error_vqmod'] = 'Figyelmeztetés: vQmod úgy tűnik nincs telepítve. <a href="http://code.google.com/p/vqmod/">vQmod telepítése!</a>';
$_['error_required_merchantid'] = 'Figyelmeztetés: a <i>Kereskedő azonosító</i> mező nem lehet üres';
$_['error_required_secretkey'] = 'Figyelmeztetés: a <i>Titkos kulcs</i> mező nem lehet üres';
$_['error_required_paymentgatewayid'] = 'Figyelmeztetés: a <i>Fizetési átjáró azonosító</i> mező nem lehet üres';
$_['error_required_merchantemail'] = 'Figyelmeztetés: a <i>Kereskedő email</i> mező nem lehet üres';
$_['error_borgun_total'] = 'Figyelmeztetés: If enabled the payment module <i>Total</i> field can not be empty';
$_['error_required'] = 'Figyelmeztetés: A mező kitöltése kötelező';

// Tab text
$_['text_borgun_general_information'] = '<div style="float: right;"><a onclick="window.open(\'http://www.b-payment.hu/\');">
    <img width="140" height="123" src="view/image/payment/borgun.png" alt="Borgun" title="Borgun" style="border: 1px solid #EEEEEE;" /></a></div>
    <p>Ez a plugin a Borgun fizetési oldalát integrálja a webshophoz. Fizetések elfogadásához szükséges egy szerződés a Borgunnal.</p>
                                       <p>Szeretnéd ha tudnának kártyával fizetni a webshopodban, de nincsenek Borgun azonosítóid? <a href="mailto:info@b-payment.hu">Vedd fel velünk a kapcsolatot!</a></p>';
$_['text_borgun_account_information'] = '<p>Ez a plugin a Borgun fizetési oldalát integrálja a webshophoz. Fizetések elfogadásához szükséges egy szerződés a Borgunnal.</p>
                                       <p>Szeretnél ha tudnának kártyával fizetni a webshopodban, de nincsenek Borgun azonosítóid? <a href="mailto:info@b-payment.hu">Vedd fel velünk a kapcsolatot!</a></p>';
$_['button_notification'] = 'Debug infromáció küldése';
?>