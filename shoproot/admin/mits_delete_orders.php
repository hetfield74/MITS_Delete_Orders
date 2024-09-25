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

require_once('includes/application_top.php');

if (defined('MODULE_MITS_DELETE_ORDERS_STATUS') && MODULE_MITS_DELETE_ORDERS_STATUS == 'true') {
  require_once (DIR_FS_INC . 'xtc_remove_order.inc.php');

  $fehler = 0;
  $timestamp_now = time();
  $dateselect = "";

  if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    if (isset($_POST['startyear']) && isset($_POST['startmonth']) && isset($_POST['startday']) && isset($_POST['starthour']) && isset($_POST['startminute'])
          && isset($_POST['endyear']) && isset($_POST['endmonth']) && isset($_POST['endday']) && isset($_POST['endhour']) && isset($_POST['endminute'])) {
      $start_minute = $_POST['startminute'];
      $start_hour = $_POST['starthour'];
      $start_day = $_POST['startday'];
      $start_month = $_POST['startmonth'];
      $start_year = $_POST['startyear'];
      $end_minute = $_POST['endminute'];
      $end_hour = $_POST['endhour'];
      $end_day = $_POST['endday'];
      $end_month = $_POST['endmonth'];
      $end_year = $_POST['endyear'];
      $start = $_POST['startyear'] . '-' . $_POST['startmonth'] . '-' . $_POST['startday'] . ' ' . $_POST['starthour'] . ':' . $_POST['startminute'] . ':00';
      $end = $_POST['endyear'] . '-' . $_POST['endmonth'] . '-' . $_POST['endday'] . ' ' . $_POST['endhour'] . ':' . $_POST['endminute'] . ':00';
      $dateselect = "(date_purchased BETWEEN '" . xtc_db_input($start) . "' AND '" . xtc_db_input($end) . "')";
    }

    if (isset($_POST['status']) && !empty($_POST['status'])) {
      $statuslist_query_array = array();
      foreach ($_POST['status'] as $statusid) {
        if (is_numeric($statusid)) {
          $statuslist_query_array[] = (int)$statusid;
        }
      }
      $orderstatus = ' AND orders_status IN ("' . implode('", "', $statuslist_query_array) . '") ';
    }
    if (isset($_POST['payment_art']) && !empty($_POST['payment_art'])) {
      $paymentlist_query_array = array();
      foreach ($_POST['payment_art'] as $paymentclass) {
        $paymentlist_query_array[] = xtc_db_input(trim($paymentclass));
      }
      $payment = ' AND payment_class IN ("' . implode('", "', $paymentlist_query_array) . '") ';
    }
    if (isset($_POST['shipping_art']) && !empty($_POST['shipping_art'])) {
      $shippinglist_query_array = array();
      foreach ($_POST['shipping_art'] as $shippingclass) {
        $shippinglist_query_array[] = xtc_db_input(trim($shippingclass));
      }
      $shipping = ' AND shipping_class IN ("' . implode('", "', $shippinglist_query_array) . '") ';
    }

    if (isset($_POST['orderlist']) && !empty($_POST['orderlist'])) {
      $orderlist_array = explode("\r\n", trim($_POST['orderlist']));
      $orderlist_query_array = array();
      foreach ($orderlist_array as $orderid) {
        if (is_numeric($orderid)) {
          $orderlist_query_array[] = (int)$orderid;
        }
      }
      $orderwhere = 'orders_id IN ("' . implode('", "', $orderlist_query_array) . '") ';
    } elseif ((!empty($_POST['fromorderid']) && is_numeric($_POST['fromorderid'])) || (!empty($_POST['toorderid']) && is_numeric($_POST['toorderid']))) {
      if (!empty($_POST['toorderid']) && is_numeric($_POST['toorderid'])) {
        if (!empty($_POST['fromorderid']) && is_numeric($_POST['fromorderid'])) {
          $orderwhere = '(orders_id >= ' . (int)$_POST['fromorderid'] . ' AND orders_id <= ' . (int)$_POST['toorderid'] . ')';
        } else {
          $orderwhere = '(orders_id <= ' . (int)$_POST['toorderid'] . ')';
        }
      } else {
        $orderwhere = 'orders_id = ' . (int)$_POST['fromorderid'];
      }
    } else {
      $orderwhere = $dateselect;
    }

    if (!empty($_POST['country_id']) && is_numeric($_POST['country_id']) && $_POST['country_id'] != 0) {
      $country_query = xtc_db_query("SELECT countries_name FROM " . TABLE_COUNTRIES . " WHERE countries_id = " . (int)$_POST['country_id']);
      $country = xtc_db_fetch_array($country_query);
      $countrywhere = ' AND delivery_country = "' . xtc_db_input($country['countries_name']) . '"' ;
    }

    $orders_query_raw = 'SELECT * FROM ' . TABLE_ORDERS . ' WHERE ' . $orderwhere . $payment . $shipping . $orderstatus . $countrywhere . ' ORDER BY orders_id ASC';
    $orders_query = xtc_db_query($orders_query_raw);
    if (xtc_db_num_rows($orders_query)) {
      while ($order = xtc_db_fetch_array($orders_query)) {
        xtc_remove_order($order['orders_id'], false, false);
      }
    } else {
      echo $orders_query_raw;
      $fehler = 1;
    }
  } else {
    $first_query = xtc_db_query("SELECT date_purchased FROM " . TABLE_ORDERS . " ORDER BY orders_id ASC LIMIT 1");
    $first = xtc_db_fetch_array($first_query);
    $timestamp_first = strtotime($first['date_purchased']);
    $start_minute = date("i", $timestamp_first);
    $start_hour = date("H", $timestamp_first);
    $start_day = date("d", $timestamp_first);
    $start_month = date("m", $timestamp_first);
    $start_year = date("Y", $timestamp_first);
    $end_minute = date("i", $timestamp_now);
    $end_hour = date("H", $timestamp_now);
    $end_day = date("d", $timestamp_now);
    $end_month = date("m", $timestamp_now);
    $end_year = date("Y", $timestamp_now);
  }
}
require(DIR_WS_INCLUDES . 'head.php');
?>
  <style type="text/css">
    label {
      cursor: pointer;
    }
  </style>
  </head>
  <body>
  <!-- header //-->
  <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
  <!-- header_eof //-->

  <!-- body //-->
  <table class="tableBody">
    <tr>
      <?php //left_navigation
      if (USE_ADMIN_TOP_MENU == 'false') {
        echo '<td class="columnLeft2">' . PHP_EOL;
        echo '<!-- left_navigation //-->' . PHP_EOL;
        require_once(DIR_WS_INCLUDES . 'column_left.php');
        echo '<!-- left_navigation eof //-->' . PHP_EOL;
        echo '</td>' . PHP_EOL;
      }
      ?>
      <!-- body_text //-->
      <td class="boxCenter">
        <div class="pageHeadingImage"><?php echo xtc_image(DIR_WS_ICONS . 'heading/icon_statistic.png'); ?></div>
        <div class="flt-l">
          <div class="pageHeading"><?php echo HEADING_TITLE_DELETE_ORDERS; ?></div>
          <div class="main pdg2 flt-l"><?php echo HEADING_SUBTITLE_DELETE_ORDERS; ?></div>
        </div>
        <table border="0" width="100%" cellspacing="0" cellpadding="0" class="tableCenter">
          <tr>
            <td class="main">
              <!-- inhalt //--><br />
              <?php
              if (defined('MODULE_MITS_DELETE_ORDERS_STATUS') && MODULE_MITS_DELETE_ORDERS_STATUS == 'true') {
                if ($fehler == 1) {
                  ?>
                  <h2><?php echo ERROR_NO_ORDERS_FOUND; ?></h2>
                  <div><a href="<?php xtc_href_link(FILENAME_MITS_DELETE_ORDERS); ?>" class="button"><?php echo TEXT_NEW_SEARCH; ?></a></div>
                  <?php
                } else {
                  ?>
                  <br />
                  <?php echo xtc_draw_form('delete_orders', FILENAME_MITS_DELETE_ORDERS, '', 'post', ''); ?>
                  <fieldset>
                    <legend><strong> <?php echo TEXT_DELETE_ORDERS; ?> </strong></legend>
                    <?php
                    echo '<table border="0"><tr><td><label for="orderlist">' . TEXT_ORDERID_LIST . ': </label></td></tr><tr><td>' . xtc_draw_textarea_field('orderlist', 'soft', '40', '20', $_POST['orderlist'], 'id="orderlist"') . '</td></tr></table>';
                    echo '<br /><br />' . TEXT_OR_BETWEEN_OIDS . '<br /><br />';

                    echo '<label for="fromorderid">' . TEXT_FROMORDERID . ': </label> ' . xtc_draw_input_field('fromorderid', $_POST['fromorderid'], 'id="fromorderid"');
                    echo ' <label for="toorderid">' . TEXT_TOORDERID . ': </label> ' . xtc_draw_input_field('toorderid', $_POST['toorderid'], 'id="toorderid"');
                    echo '<br /><br />' . TEXT_OR_DATE . '<br /><br />';

                    $startday = array();
                    for ($z = 1, $m = 32; $z < $m; $z++) $startday[] = array('id' => str_pad($z, 2, '0', STR_PAD_LEFT), 'text' => str_pad($z, 2, '0', STR_PAD_LEFT));
                    echo ' <label for="startday">' . TEXT_DAY . ': </label> ' . xtc_draw_pull_down_menu('startday', $startday, $start_day, 'id="startday"');

                    $startmonth = array();
                    for ($z = 1, $m = 13; $z < $m; $z++) $startmonth[] = array('id' => str_pad($z, 2, '0', STR_PAD_LEFT), 'text' => str_pad($z, 2, '0', STR_PAD_LEFT));
                    echo ' <label for="startmonth">' . TEXT_MONTH . ': </label> ' . xtc_draw_pull_down_menu('startmonth', $startmonth, $start_month, 'id="startmonth"');

                    $year = date('Y', $timestamp_now);
                    $startyear = array();
                    for ($z = $start_year, $m = $year+1; $z < $m; $z++) $startyear[] = array('id' => $z, 'text' => $z);
                    echo ' <label for="startyear">' . TEXT_YEAR . ': </label> ' . xtc_draw_pull_down_menu('startyear', $startyear, $start_year, 'id="startyear"');

                    $starthour = array();
                    for ($z = 0, $m = 23; $z <= $m; $z++) $starthour[] = array('id' => str_pad($z, 2, '0', STR_PAD_LEFT), 'text' => str_pad($z, 2, '0', STR_PAD_LEFT));
                    echo ' <label for="starthour">' . TEXT_HOUR . ': </label> ' . xtc_draw_pull_down_menu('starthour', $starthour, $start_hour, 'id="starthour"');

                    $startminute = array();
                    for ($z = 0, $m = 59; $z <= $m; $z++) $startminute[] = array('id' => str_pad($z, 2, '0', STR_PAD_LEFT), 'text' => str_pad($z, 2, '0', STR_PAD_LEFT));
                    echo ' <label for="startminute">' . TEXT_MINUTE . ': </label> ' . xtc_draw_pull_down_menu('startminute', $startminute, $start_minute, 'id="startminute"');

                    echo '<br /><br />';

                    $endday = array();
                    for ($z = 1, $m = 32; $z < $m; $z++) $endday[] = array('id' => str_pad($z, 2, '0', STR_PAD_LEFT), 'text' => str_pad($z, 2, '0', STR_PAD_LEFT));
                    echo ' <label for="endday">' . TEXT_DAY . ': </label> ' . xtc_draw_pull_down_menu('endday', $endday, $end_day, 'id="endday"');

                    $endmonth = array();
                    for ($z = 1, $m = 13; $z < $m; $z++) $endmonth[] = array('id' => str_pad($z, 2, '0', STR_PAD_LEFT), 'text' => str_pad($z, 2, '0', STR_PAD_LEFT));
                    echo ' <label for="endmonth">' . TEXT_MONTH . ': </label>' . xtc_draw_pull_down_menu('endmonth', $endmonth, $end_month, 'id="endmonth"');

                    $endyear = array();
                    $diff_years = $year - $start_year;
                    for ($z = $year - $diff_years, $m = $year+1; $z < $m; $z++) $endyear[] = array('id' => $z, 'text' => $z);
                    echo ' <label for="endyear">' . TEXT_YEAR . ': </label>' . xtc_draw_pull_down_menu('endyear', $endyear, $end_year, 'id="endyear"');

                    $endhour = array();
                    for ($z = 0, $m = 23; $z <= $m; $z++) $endhour[] = array('id' => str_pad($z, 2, '0', STR_PAD_LEFT), 'text' => str_pad($z, 2, '0', STR_PAD_LEFT));
                    echo ' <label for="endhour">' . TEXT_HOUR . ': </label> ' . xtc_draw_pull_down_menu('endhour', $endhour, $end_hour, 'id="endhour"');

                    $endminute = array();
                    for ($z = 0, $m = 59; $z <= $m; $z++) $endminute[] = array('id' => str_pad($z, 2, '0', STR_PAD_LEFT), 'text' => str_pad($z, 2, '0', STR_PAD_LEFT));
                    echo ' <label for="endminute">' . TEXT_MINUTE . ': </label> ' . xtc_draw_pull_down_menu('endminute', $endminute, $end_minute, 'id="endminute"');

                    echo '<br /><br /><hr /><br />';
                    if (defined('MODULE_PAYMENT_INSTALLED')) {
                      $payments = explode(';', MODULE_PAYMENT_INSTALLED);
                      echo '<table border="0"><tr><td><label for="payment_art"><b>' . TEXT_PAYMENT . ': </b></label></td></tr><tr><td>';
                      $pay_art = array();
                      $pay_art[] = array('id' => '1', 'text' => 'alle');
                      for ($i = 0; $i < count($payments); $i++) {
                        $pay = substr($payments[$i], 0, strrpos($payments[$i], '.'));
                        if (file_exists(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $payments[$i]) && is_file(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $payments[$i])) {
                          require(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $payments[$i]);
                          $payment_text = constant('MODULE_PAYMENT_' . strtoupper($pay) . '_TEXT_TITLE');
                        } else {
                          $payment_text = $pay;
                        }
                        $pay_art[] = array('id' => $pay, 'text' => $payment_text);
                        echo '<label>' . xtc_draw_checkbox_field('payment_art[]', $pay) . ' ' . $payment_text . '</label><br />';
                      }
                      echo '</td></tr></table>';
                    }

                    if (defined('MODULE_SHIPPING_INSTALLED')) {
                      echo '<br /><br />';
                      $shippings = explode(';', MODULE_SHIPPING_INSTALLED);
                      echo '<table border="0"><tr><td><label for="shipping_art"><b>' . TEXT_SHIPPING . ': </b></label></td></tr><tr><td>';
                      $ship_art = array();
                      $ship_art[] = array('id' => '1', 'text' => 'alle');
                      for ($i = 0; $i < count($shippings); $i++) {
                        $ship = substr($shippings[$i], 0, strrpos($shippings[$i], '.'));
                        if (file_exists(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $shippings[$i]) && is_file(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $shippings[$i])) {
                          require(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $shippings[$i]);
                          $shipping_text = constant('MODULE_SHIPPING_' . strtoupper($ship) . '_TEXT_TITLE');
                        } else {
                          $shipping_text = $ship;
                        }
                        $ship_art[] = array('id' => $ship, 'text' => $shipping_text);
                        echo '<label>' . xtc_draw_checkbox_field('shipping_art[]', $ship . '_' . $ship) . ' ' . $shipping_text . '</label><br />';
                      }
                      echo '</td></tr></table>';
                    }

                    echo '<br /><br />';
                    echo '<table border="0"><tr><td><label for="status"><b>' . TEXT_ORDER_STATUS . ': </b></label></td></tr><tr><td>';
                    $statusarray = array();
                    $statusarray[] = array('id' => '-1', 'text' => 'alle');
                    $status_query = xtc_db_query('SELECT orders_status_id, orders_status_name FROM ' . TABLE_ORDERS_STATUS . ' WHERE language_id = ' . (int)$_SESSION['languages_id']);
                    if (xtc_db_num_rows($status_query)) {
                      while ($statuse = xtc_db_fetch_array($status_query)) {
                        $statusarray[] = array('id' => $statuse['orders_status_id'], 'text' => $statuse['orders_status_name']);
                        echo '<label>' . xtc_draw_checkbox_field('status[]', $statuse['orders_status_id']) . ' ' . $statuse['orders_status_name'] . '</label><br />';
                      }
                    }
                    echo '</td></tr></table>';
                    ?>
                    <br /><br />
                    <input type="hidden" name="action" value="delete" />
                    <input type="submit" value="<?php echo TEXT_DELETE_BUTTON; ?>" class="button" onclick="self.document.forms[0].submit()" />
                  </fieldset></form>
                  <?php
                }
              } else {
                echo '<h2>' . ERROR_DELETE_ORDERS_NOT_ACTIVE . '</h2>';
              }
              ?>
              <!-- inhalt //-->
            </td>
          </tr>
        </table>
      </td>
      <!-- body_text_eof //-->
    </tr>
  </table>
  <!-- body_eof //-->
  <!-- footer //-->
  <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
  <!-- footer_eof //-->
  </body></html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>