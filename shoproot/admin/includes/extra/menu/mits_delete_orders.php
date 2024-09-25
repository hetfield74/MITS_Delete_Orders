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

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
if (defined('MODULE_MITS_DELETE_ORDERS_STATUS') && MODULE_MITS_DELETE_ORDERS_STATUS == 'true') {
    $add_contents[BOX_HEADING_TOOLS][] = array(
      'admin_access_name' => 'mits_delete_orders',
      'filename'          => FILENAME_MITS_DELETE_ORDERS,
      'boxname'           => MITS_BOX_DELETE_ORDERS,
      'parameters'        => '',
      'ssl'               => ''
    );
}
