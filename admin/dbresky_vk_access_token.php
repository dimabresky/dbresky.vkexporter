<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_popup_admin.php");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Bitrix\Main\Loader::includeModule("dbresky.vkexporter");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$options = new \dbresky\vkexporter\Options;

(new \dbresky\vkexporter\Gateway($options))->getAccessToken();

CAdminMessage::ShowMessage(array(
    "MESSAGE" => Loc::getMessage("dbresky_VKEXPORTER_ACCESS_TOKEN_ERROR"),
    "TYPE" => "ERROR",
    "HTML" => true
));
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_popup_admin.php");
