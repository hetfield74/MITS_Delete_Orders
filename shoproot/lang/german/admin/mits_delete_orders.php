<?php
/**
 * --------------------------------------------------------------
 * File: mits_delete_orders.php
 * Date: 30.05.2022
 * Time: 08:50
 *
 * Author: Hetfield
 * Copyright: (c) 2022 - MerZ IT-SerVice
 * Web: https://www.merz-it-service.de
 * Contact: info@merz-it-service.de
 * --------------------------------------------------------------
 */

defined('HEADING_TITLE_DELETE_ORDERS') or define('HEADING_TITLE_DELETE_ORDERS', 'MITS Bestellungen l&ouml;schen <small style="font-weight:normal;font-size:0.6em;">&copy; 2010-' . date('Y') . ' by <a href="https://www.merz-it-service.de/" target="_blank">Hetfield</a></small>');
defined('HEADING_SUBTITLE_DELETE_ORDERS') or define('HEADING_SUBTITLE_DELETE_ORDERS', '<a href="https://www.merz-it-service.de/" target="_blank">' . xtc_image(DIR_WS_IMAGES . 'merz-it-service.png', '', '', '', ' style="display:block;max-width:100%;height:auto;max-height:40px;margin-top:6px;margin-bottom:6px;"') . '</a>');
defined('TEXT_DELETE_ORDERS') or define('TEXT_DELETE_ORDERS', 'L&ouml;sche die Bestellungen aus folgendem Zeitraum:');
defined('TEXT_ORDERID_LIST') or define('TEXT_ORDERID_LIST', '<b>Folgende Bestellnummern</b><br />(pro Zeile eine Bestellnummer, keine weiteren Zeichen einf&uuml;gen)');
defined('TEXT_FROMORDERID') or define('TEXT_FROMORDERID', '<b>ab Bestellnummer</b>');
defined('TEXT_TOORDERID') or define('TEXT_TOORDERID', '<b>bis Bestellnummer</b>');
defined('TEXT_OR_DATE') or define('TEXT_OR_DATE', 'oder nach Datum:');
defined('TEXT_OR_BETWEEN_OIDS') or define('TEXT_OR_BETWEEN_OIDS', 'oder Bestellnummernbereich:');
defined('TEXT_MINUTE') or define('TEXT_MINUTE', 'Minute');
defined('TEXT_HOUR') or define('TEXT_HOUR', 'Stunde');
defined('TEXT_DAY') or define('TEXT_DAY', 'Tag');
defined('TEXT_MONTH') or define('TEXT_MONTH', 'Monat');
defined('TEXT_YEAR') or define('TEXT_YEAR', 'Jahr');
defined('TEXT_PAYMENT') or define('TEXT_PAYMENT', 'Zahlungsart');
defined('TEXT_SHIPPING') or define('TEXT_SHIPPING', 'Versandart');
defined('TEXT_ORDER_STATUS') or define('TEXT_ORDER_STATUS', 'Bestellstatus');
defined('TEXT_DELETE_BUTTON') or define('TEXT_DELETE_BUTTON', 'L&ouml;schen');
defined('TEXT_NEW_SEARCH') or define('TEXT_NEW_SEARCH', 'Neue Suche &raquo;');
defined('ERROR_NO_ORDERS_FOUND') or define('ERROR_NO_ORDERS_FOUND', 'Keine Bestellungen gefunden!');
defined('ERROR_DELETE_ORDERS_NOT_ACTIVE') or define('ERROR_DELETE_ORDERS_NOT_ACTIVE', 'Modul "MITS Bestellungen l&ouml;schen" ist nicht aktiviert!');
