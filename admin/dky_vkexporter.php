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
        "CURRENCY" => NULL,
        "UPDATE_EXISTS" => 0,
        "FIELDS" => array(
            "NAME" => array("VALUE" => "NAME", "TITLE" => "Укажите поле для выгрузки в качестве названия"),
            "PICTURE" => array("VALUE" => "DETAIL_PICTURE", "TITLE" => "Укажите поле для выгрузки в качестве картинки"),
            "DESCRIPTION" => array("VALUE" => "DETAIL_TEXT", "TITLE" => "Укажите поле для выгрузки в качестве описания"),
            "PRICE" => array("VALUE" => NULL, "TITLE" => "Укажите поле для выгрузки в качестве цены")
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

            if ($_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"]["IBLOCK_ID"] === NULL) {
                LocalRedirect($APPLICATION->GetCurPageParam("step=1", $url_params_for_del));
            }

            $arFields = array(
                "NAME" => "Название",
                "DETAIL_TEXT" => "Детальное описание",
                "DETAIL_PICTURE" => "Детальная картинка",
                "PREVIEW_TEXT" => "Анонс",
                "PREVIEW_PICTURE" => "Картинка анонса",
            );
            
            $dbList = Bitrix\Iblock\PropertyTable::getList(array("filter" => array("IBLOCK_ID" => $_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"]["IBLOCK_ID"])));
            while ($arProperty = $dbList->fetch()) {
                $arFields["PROPERTY_" . $arProperty["CODE"]] = $arProperty["NAME"];
            }
            ?>


            <? foreach ($_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"]["FIELDS"] as $name => $arValue): ?>
                <tr>
                    <td width="40%"><label><?= $arValue["TITLE"]?>:</label></td>
                    <td width="60%">
                        <select name="FIELDS[<?= $name ?>]">
                            <option value="">...</option>
            <? foreach ($arFields as $code => $fname): ?>
                                <option <? if ($code === $arValue["VALUE"]): ?>selected=""<? endif ?> value="<?= $code ?>"><?= $fname ?></option>
                            <? endforeach; ?>
                        </select>
                    </td>
                </tr>
        <? endforeach ?>
         <tr>
                    <td width="40%"><label>Укажите валюту поля цены<br>( <b><small>цены должны быть предварительно сконвертированы в указанную валюту</small></b> ):</label></td>
                    <td width="60%">
                        <select name="CURRENCY">
            <? foreach (array(
                "USD" => "USD",
                "RUB" => "RUB",
                "EUR" => "EUR",
                "BYN" => "BYN",
            ) as $code => $name): ?>
                                <option <? if ($code === $_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"]["CURRENCY"]): ?>selected=""<? endif ?> value="<?= $code ?>"><?= $name ?></option>
                            <? endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="40%"><label>Обновлять ранее выгруженные элементы:</label></td>
                    <td width="60%">
                        <input <?if(1 === (int)$_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"]["UPDATE_EXISTS"]):?>checked=""<?endif?> type="checkbox" value="1" name="UPDATE_EXISTS">
                    </td>
                </tr>
        <?
        break;
    case 3:
        break;

    case 1:
    default:

        if ($_REQUEST["IBLOCK_ID"] > 0 && isset($arIblocks[$_REQUEST["IBLOCK_ID"]]) && check_bitrix_sessid()) {

            $_SESSION["DKY_VKEXPORTER_EXPORT_OPTIONS"]["IBLOCK_ID"] = intVal($_REQUEST["IBLOCK_ID"]);
            LocalRedirect($APPLICATION->GetCurPageParam("step=2", $url_params_for_del));
        }
        ?>
            <tr>
                <td width="40%"><label>Выберите инфоблок для выгрузки:</label></td>
                <td width="60%">
                    <select name="IBLOCK_ID">
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
    