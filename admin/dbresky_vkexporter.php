<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$mid = "dbresky.vkexporter";

\Bitrix\Main\Loader::includeModule($mid);

dbresky\vkexporter\Tools::loadCss("/$mid/admin/css/styles.css");

$options = new dbresky\vkexporter\Options;
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

$step = $request->get("step") > 1 ? intVal($request->get("step")) : 1;

$o_tab = new CAdminTabControl("dbreskyTabControl", array(
    array(
        "DIV" => "vkexporter",
        "TAB" => Loc::getMessage("dbresky_VKEXPORTER_TAB_TITLE"),
        "ICON" => "",
        "TITLE" => Loc::getMessage("dbresky_VKEXPORTER_TAB_SUBTITLE", array("#step#" => $step))
    )
        ));
$APPLICATION->ShowViewContent('errors');

if ($step !== 3):
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
<?else: include_once "steps/3.php"; endif;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
