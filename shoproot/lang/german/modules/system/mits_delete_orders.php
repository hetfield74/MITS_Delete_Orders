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

define('MODULE_MITS_DELETE_ORDERS_TEXT_TITLE', 'MITS Delete Orders <span style="white-space:nowrap;">&copy; by <span style="padding:2px;background:#ffe;color:#6a9;font-weight:bold;">Hetfield (MerZ IT-SerVice)</span></span>');
define('MODULE_MITS_DELETE_ORDERS_TEXT_DESCRIPTION', '
    <a href="https://www.merz-it-service.de/" target="_blank">
      <img src="' . (ENABLE_SSL === true ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG . DIR_WS_IMAGES . 'merz-it-service.png" border="0" alt="MerZ IT-SerVice" style="display:block;max-width:100%;height:auto;" />
    </a><br />
    <p><strong>Bestellungen aus dem modified Shopsystem l&ouml;schen</strong></p>
    <div style="text-align:center;">
      <small>Nur auf Github gibt es immer die aktuellste Version des Moduls!</small><br />
      <a style="background:#6a9;color:#444" target="_blank" href="https://github.com/hetfield74/MITS_Delete_Orders" class="button" onclick="this.blur();">MITS Delete Orders on Github</a>
    </div>
    <p>Bei Fragen, Problemen oder W&uuml;nschen zu diesem Modul oder auch zu anderen Anliegen rund um die modified eCommerce Shopsoftware nehmen Sie einfach Kontakt zu uns auf:</p> 
    <div style="text-align:center;"><a style="background:#6a9;color:#444" target="_blank" href="https://www.merz-it-service.de/Kontakt.html" class="button" onclick="this.blur();">Kontaktseite auf MerZ-IT-SerVice.de</strong></a></div>
');
define('MODULE_MITS_DELETE_ORDERS_STATUS_TITLE', 'Modul aktivieren?');
define('MODULE_MITS_DELETE_ORDERS_STATUS_DESC', 'Das Modul aktivieren?');
