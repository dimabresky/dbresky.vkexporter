<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

\Bitrix\Main\Loader::includeModule("iblock");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

$arIblocks = array();
$dbIblockList = Bitrix\Iblock\IblockTable::getList(array("filter" => array("ACTIVE" => "Y")));
while ($arIblock = $dbIblockList->fetch()) {
    $arIblocks[$arIblock["ID"]] = $arIblock;
}

$step = isset($_REQUEST["step"]) && $_REQUEST["step"] > 1 ? intVal($_REQUEST["step"]) : 1;

if (!isset($_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"])) {
    $_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"] = array(
        "IBLOCK_ID" => NULL,
        "CURRENCY" => "BYN",
        "UPDATE_EXISTS" => 0,
        "FIELDS" => array(
            "NAME" => "NAME",
            "PICTURE" => "DETAIL_PICTURE",
            "DESCRIPTION" => "DETAIL_TEXT",
            "PRICE" => NULL
        )
    );
}

$url_params_for_del = array("iblock_id", "step", "sessid", "autosave_id", "next", "DKYTabControl_active_tab");

$o_tab = new CAdminTabControl("DKYTabControl", array(
    array(
        "DIV" => "vkexporter",
        "TAB" => "Экспорт элементов инфоблока в vk",
        "ICON" => "",
        "TITLE" => "Шаг $step"
    )
        ));
?>
<form action="<? $APPLICATION->GetCurPage() ?>" method="get">
    <input type="hidden" value="<?= LANGUAGE_ID ?>" name="lang">
    <?= bitrix_sessid_post() ?>
    <?
    $o_tab->Begin();
    $o_tab->BeginNextTab();
    switch ($step) {

        case 2:
            break;
        case 3:
            break;

        case 1:
        default:

            if ($_REQUEST["iblock_id"] > 0 && isset($arIblocks[$_REQUEST["iblock_id"]]) && check_bitrix_sessid()) {
                
                $_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"]["IBLOCK_ID"] = intVal($_REQUEST["iblock_id"]);
                LocalRedirect($APPLICATION->GetCurPageParam("step=2", $url_params_for_del));
                
            }
            ?>
            <tr>
                <td width="40%"><label>Выберите инфоблок для выгрузки:</label></td>
                <td width="60%">
                    <select name="iblock_id">
                        <option value="">...</option>
                        <? foreach ($arIblocks as $arIblock): ?>
                            <option <? if ((int) $arIblock["ID"] === (int) $_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"]["IBLOCK_ID"]): ?>selected=""<? endif ?> value="<?= $arIblock["ID"] ?>"><?= $arIblock["NAME"] ?></option>
                        <? endforeach; ?>
                    </select>
                </td>
            </tr>
            <? $o_tab->Buttons();
            ?>
            <input type="submit" name="next" value="Далее" title="Далее" class="adm-btn-save">
        <?
    }
    $o_tab->End();
    ?>

</form>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
