<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_popup_admin.php");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Bitrix\Main\Loader::includeModule("dki.vkexporter");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$options = new \dki\vkexporter\Options;

if (strlen($request->get("code")) > 0) {

    $arResponse = json_decode(file_get_contents(\dki\vkexporter\Tools::getVkAccessTokenURL($request->get("code"), $options->get()->app_id, $options->get()->app_secret)), true);

    if (strlen($arResponse["access_token"]) > 0) {

        $options->save(array("access_token" => $arResponse["access_token"]));
        ?><script>window.opener.location.reload();window.close();</script><?
        exit;
    }
}
CAdminMessage::ShowMessage(array(
    "MESSAGE" => Loc::getMessage("dki_VKEXPORTER_ACCESS_TOKEN_ERROR"),
    "TYPE" => "ERROR",
    "HTML" => true
));
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_popup_admin.php");
