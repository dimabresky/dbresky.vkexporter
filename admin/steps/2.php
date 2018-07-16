<?php
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

    if (empty($arErrors)) {
        LocalRedirect($APPLICATION->GetCurPageParam("step=3", \dki\vkexporter\Tools::getURLParametersForDel()));
    } else {
        $Loc = Loc;
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
    "NAME" => "Название",
    "DETAIL_TEXT" => "Детальное описание",
    "DETAIL_PICTURE" => "Детальная картинка",
    "PREVIEW_TEXT" => "Анонс",
    "PREVIEW_PICTURE" => "Картинка анонса",
        ), \dki\vkexporter\Tools::getIblockProperties($options->get()->iblock));
?>


<?
foreach ($options->get() as $name => $value):

    if (in_array($name, array("iblock_id", "currency", "update_exists", "access_token"))) {
        continue;
    }
    ?>
    <tr>
        <td width="40%"><label><?= $name ?>:</label></td>
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
    <td width="40%"><label>Укажите валюту поля цены<br>( <b><small>цены должны быть предварительно сконвертированы в указанную валюту</small></b> ):</label></td>
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
    <td width="40%"><label>Обновлять ранее выгруженные элементы:</label></td>
    <td width="60%">
        <input <? if (1 === $options->get()->update_exists): ?>checked=""<? endif ?> type="checkbox" value="1" name="update_exists">
    </td>
</tr>
<? $o_tab->Buttons();
?>
<input type="button" onclick="location = '?step=1&lang=<?= LANGUAGE_ID ?>'" name="prev" value="Назад" title="Назад">
<input type="submit" name="next" value="Начать выгрузку" title="Начать выгрузку" class="adm-btn-save">
