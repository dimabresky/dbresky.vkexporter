<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

\Bitrix\Main\Loader::includeModule("dki.vkexporter");

$options = new dki\vkexporter\Options;
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

$step = $request->get("step") > 1 ? intVal($request->get("step")) : 1;

$o_tab = new CAdminTabControl("dkiTabControl", array(
    array(
        "DIV" => "vkexporter",
        "TAB" => Loc::getMessage("dki_VKEXPORTER_TAB_TITLE"),
        "ICON" => "",
        "TITLE" => Loc::getMessage("dki_VKEXPORTER_TAB_SUBTITLE", array("#step#" => $step))
    )
        ));
$APPLICATION->ShowViewContent('errors');
?>
<form action="<? $APPLICATION->GetCurPage() ?>" method="get">
    <input type="hidden" value="<?= LANGUAGE_ID ?>" name="lang">
    <input type="hidden" value="<?= $step ?>" name="step">
    <?
    echo bitrix_sessid_post();
    $o_tab->Begin();
    $o_tab->BeginNextTab();
    include_once "steps/$step.php";
    $o_tab->End();
    ?>

</form>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
