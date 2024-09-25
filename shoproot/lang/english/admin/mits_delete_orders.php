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

defined('HEADING_TITLE_DELETE_ORDERS') or define('HEADING_TITLE_DELETE_ORDERS', 'MITS Delete Orders <small style="font-weight:normal;font-size:0.6em;">&copy; 2010-' . date('Y') . ' by <a href="https://www.merz-it-service.de/" target="_blank">Hetfield</a></small>');
defined('HEADING_SUBTITLE_DELETE_ORDERS') or define('HEADING_SUBTITLE_DELETE_ORDERS', '<a href="https://www.merz-it-service.de/" target="_blank">' . xtc_image(DIR_WS_IMAGES . 'merz-it-service.png', '', '', '', ' style="display:block;max-width:100%;height:auto;max-height:40px;margin-top:6px;margin-bottom:6px;"') . '</a>');
defined('TEXT_DELETE_ORDERS') or define('TEXT_DELETE_ORDERS', 'Delete orders:');
defined('TEXT_ORDERID_LIST') or define('TEXT_ORDERID_LIST', '<b>The following order numbers</b><br />(an order number per line, no further characters)');
defined('TEXT_FROMORDERID') or define('TEXT_FROMORDERID', '<b>from the order number</b>');
defined('TEXT_TOORDERID') or define('TEXT_TOORDERID', '<b>up to order number</b>');
defined('TEXT_OR_DATE') or define('TEXT_OR_DATE', 'or by date:');
defined('TEXT_OR_BETWEEN_OIDS') or define('TEXT_OR_BETWEEN_OIDS', 'or order number area:');
defined('TEXT_MINUTE') or define('TEXT_MINUTE', 'Minute');
defined('TEXT_HOUR') or define('TEXT_HOUR', 'Hour');
defined('TEXT_DAY') or define('TEXT_DAY', 'Day');
defined('TEXT_MONTH') or define('TEXT_MONTH', 'Month');
defined('TEXT_YEAR') or define('TEXT_YEAR', 'Year');
defined('TEXT_PAYMENT') or define('TEXT_PAYMENT', 'Payment');
defined('TEXT_SHIPPING') or define('TEXT_SHIPPING', 'Shipping');
defined('TEXT_ORDER_STATUS') or define('TEXT_ORDER_STATUS', 'Order status');
defined('TEXT_DELETE_BUTTON') or define('TEXT_DELETE_BUTTON', 'Delete');
defined('TEXT_NEW_SEARCH') or define('TEXT_NEW_SEARCH', 'New search &raquo;');
defined('ERROR_NO_ORDERS_FOUND') or define('ERROR_NO_ORDERS_FOUND', 'No orders found!');
defined('ERROR_DELETE_ORDERS_NOT_ACTIVE') or define('ERROR_DELETE_ORDERS_NOT_ACTIVE', 'Modul "MITS Delete Orders" is not active!');
