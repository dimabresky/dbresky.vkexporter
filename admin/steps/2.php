<?php

use Bitrix\Main\Localization\Loc;

if (!empty(\dki\vkexporter\Tools::checkFields(array("iblock_id" => $options->get()->iblock_id)))) {
    \LocalRedirect($APPLICATION->GetCurPageParam("step=1", \dki\vkexporter\Tools::getURLParametersForDel()));
}

if (check_bitrix_sessid()) {

    $arFieldsForCheck = array(
        "name" => $request->get("name"),
        "picture" => $request->get("picture"),
        "description" => $request->get("description"),
        "price" => $request->get("price"),
        "update_exists" => $request->get("update_exists")
    );

    $arErrors = \dki\vkexporter\Tools::checkFields($arFieldsForCheck);
    $options->save($arFieldsForCheck);
    if (empty($arErrors)) {
        LocalRedirect($APPLICATION->GetCurPageParam("step=3", \dki\vkexporter\Tools::getURLParametersForDel()));
    } else {
        
        ob_start();
        CAdminMessage::ShowMessage(array(
            "MESSAGE" => implode('<br>', array_map(function ($error_code) {
                                return \Bitrix\Main\Localization\Loc::getMessage("dki_VKEXPORTER_" . $error_code);
                            }, $arErrors)),
            "TYPE" => "ERROR",
            "HTML" => true
        ));
        $errors = ob_get_clean();
        $APPLICATION->AddViewContent("errors", $errors);
    }
}

$arFields = array_merge(array(
    "NAME" => Loc::getMessage("dki_VKEXPORTER_NAME_FIELD"),
    "DETAIL_TEXT" => Loc::getMessage("dki_VKEXPORTER_DETAIL_TEXT_FIELD"),
    "DETAIL_PICTURE" => Loc::getMessage("dki_VKEXPORTER_DETAIL_PICTURE_FIELD"),
    "PREVIEW_TEXT" => Loc::getMessage("dki_VKEXPORTER_PREVIEW_TEXT_FIELD"),
    "PREVIEW_PICTURE" => Loc::getMessage("dki_VKEXPORTER_PREVIEW_PICTURE_FIELD")
        ), \dki\vkexporter\Tools::getIblockProperties($options->get()->iblock_id));
?>


<?
foreach ($options->get() as $name => $value):

    if (in_array($name, array("iblock_id", "currency", "update_exists", "access_token"))) {
        continue;
    }
    ?>
    <tr>
        <td width="40%"><label><?= Loc::getMessage("dki_VKEXPORTER_". strtoupper($name) ."_FIELD_TITLE") ?>:</label></td>
        <td width="60%">
            <select name="<?= $name ?>">
                <option value="">...</option>
                <? foreach ($arFields as $code => $fname): ?>
                    <option <? if ($code === $value): ?>selected=""<? endif ?> value="<?= $code ?>"><?= $fname ?></option>
                <? endforeach; ?>
            </select>
        </td>
    </tr>
<? endforeach ?>
<tr>
    <td width="40%"><label><?= Loc::getMessage("dki_VKEXPORTER_CURRENCY_FIELD_TITLE")?>:</label></td>
    <td width="60%">
        <select name="currency">
            <?
            foreach (\dki\vkexporter\Tools::getAvailCurrency() as $code => $name):
                ?>
                <option <? if ($code === $options->get()->currency): ?>selected=""<? endif ?> value="<?= $code ?>"><?= $name ?></option>
            <? endforeach; ?>
        </select>
    </td>
</tr>
<tr>
    <td width="40%"><label><?= Loc::getMessage("dki_VKEXPORTER_UPDATE_EXISTS_FIELD_TITLE")?>:</label></td>
    <td width="60%">
        <input <? if (1 === (int)$options->get()->update_exists): ?>checked=""<? endif ?> type="checkbox" value="1" name="update_exists">
    </td>
</tr>
<? $o_tab->Buttons();
?>
<input type="button" onclick="location = '?step=1&lang=<?= LANGUAGE_ID ?>'" name="prev" value="<?= Loc::getMessage("dki_VKEXPORTER_PREV_BTN_TITLE")?>" title="<?= Loc::getMessage("dki_VKEXPORTER_PREV_BTN_TITLE")?>">
<input type="submit" name="next" value="<?= Loc::getMessage("dki_VKEXPORTER_START_EXPORT_BTN_TITLE")?>" title="<?= Loc::getMessage("dki_VKEXPORTER_START_EXPORT_BTN_TITLE")?>" class="adm-btn-save">
