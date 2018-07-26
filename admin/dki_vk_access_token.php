<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_popup_admin.php");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$options = new \dki\vkexporter\Options;

if ($request->get("action") === "get") {
    header("Location: " . \dki\vkexporter\Connector::getAutorizationUrl($options->get()->app_id, $options->get()->app_secret));
    exit;
} elseif ($request->get("action") === "set") {
    
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_popup_admin.php");