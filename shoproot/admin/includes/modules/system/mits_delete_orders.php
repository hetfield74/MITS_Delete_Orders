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

class mits_delete_orders
{

    public $code;
    public $name;
    public $version;
    public $sort_order;
    public $title;
    public $description;
    public $enabled;
    private $_check;

    function __construct()
    {
        $this->code = 'mits_delete_orders';
        $this->version = '1.01';
        $this->name = 'MODULE_' . strtoupper($this->code);
        $this->title = defined($this->name . '_TITLE') ? constant($this->name . '_TITLE') . ' - v' . $this->version : $this->code . ' - v' . $this->version;
        $this->description = defined($this->name . '_DESCRIPTION') ? constant($this->name . '_DESCRIPTION') : '';
        $this->sort_order = defined($this->name . '_SORT_ORDER') ? constant($this->name . '_SORT_ORDER') : 0;
        $this->enabled = defined($this->name . '_STATUS') && constant($this->name . '_STATUS') == 'true' ? true : false;

        $version_query = xtc_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = '" . $this->name . "_VERSION'");
        if (xtc_db_num_rows($version_query)) {
            xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '" . $this->version . "' WHERE configuration_key = '" . $this->name . "_VERSION'");
        } elseif (defined($this->name . '_STATUS')) {
            xtc_db_query(
              "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . $this->name . "_VERSION', '" . $this->version . "', 6, 99, NULL, now())"
            );
            xtc_db_query("UPDATE " . TABLE_ADMIN_ACCESS . " SET `" . strtolower($this->code) . "` = 0 WHERE customers_id = 'groups'");
        }
    }

    function process($file)
    {
        if (defined(constant($this->name . '_VERSION'))) {
            xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '" . $this->version . "' WHERE configuration_key = '" . $this->name . "_VERSION'");
        } else {
            xtc_db_query(
              "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . $this->name . "_VERSION', '" . $this->version . "', 6, 99, NULL, now())"
            );
        }
    }

    function display()
    {
        return array(
          'text' => '<br>' . xtc_button(BUTTON_SAVE) . '&nbsp;' .
            xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $this->code))
        );
    }

    function check()
    {
        if (!isset($this->_check)) {
            if (defined($this->name . '_STATUS')) {
                $this->_check = true;
            } else {
                $check_query = xtc_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = '" . $this->name . "_STATUS'");
                $this->_check = xtc_db_num_rows($check_query);
            }
        }
        return $this->_check;
    }

    function install()
    {
        xtc_db_query(
          "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . $this->name . "_STATUS', 'true', 6, 1, 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())"
        );
        xtc_db_query(
          "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . $this->name . "_VERSION', '" . $this->version . "', 6, 99, NULL, now())"
        );
        xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " ADD `" . $this->code . "` INT(1) NOT NULL DEFAULT '0'");
        xtc_db_query("UPDATE " . TABLE_ADMIN_ACCESS . " SET `" . $this->code . "` = 1");
    }

    function remove()
    {
        xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key in ('" . implode("', '", $this->keys()) . "')");
        xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " DROP COLUMN `" . $this->code . "`");
    }

    function keys()
    {
        $key = array(
          $this->name . '_STATUS'
        );

        return $key;
    }
}
