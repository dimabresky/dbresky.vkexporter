<?php

use Bitrix\Main\Localization\Loc;

if (!strlen($options->get()->access_token)):
    ?>
<tr>
    <td>
    <?= Loc::getMessage("dki_VKEXPORTER_GETTING_ACCESS_TOKEN")?>
    </td>
</tr>
    <script>window.jsUtils.OpenWindow('<?= \dki\vkexporter\Tools::getVkAuthorizationURL($options->get()->app_id) ?>', 700, 600);</script>
<?
else:
    
    if (!empty(\dki\vkexporter\Tools::checkFields(array("iblock_id" => $options->get()->iblock_id)))) {
        \LocalRedirect($APPLICATION->GetCurPageParam("step=1", \dki\vkexporter\Tools::getURLParametersForDel()));
    }

    if (check_bitrix_sessid()) {

        $arFieldsForCheck = array(
            "name" => $request->get("name"),
            "picture" => $request->get("picture"),
            "description" => $request->get("description"),
            "price" => $request->get("price"),
            "category" => $request->get("category"),
            "album" => $request->get("album")
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
    
    
    
    if (!isset($_SESSION["dki_VKEXPORTER_MARKET_CATEGORIES"]) || !is_array($_SESSION["dki_VKEXPORTER_MARKET_CATEGORIES"]) || empty($_SESSION["dki_VKEXPORTER_MARKET_CATEGORIES"])) {
        $gateway = new dki\vkexporter\Gateway($options->get()->access_token);
        $_SESSION["dki_VKEXPORTER_MARKET_CATEGORIES"] = $gateway->getCategories();
    }

    $arAlbums = \dki\vkexporter\tables\Albums::getTable()->getList([
        "select" => ["ID", "UF_NAME"] 
    ])->fetchAll();
            
    foreach ($options->get() as $name => $value):

        if (in_array($name, array("iblock_id", "currency", "access_token", "app_id", "app_secret", "category", "album", "album_create_from_parent_section"))) {
            continue;
        }
        ?>
        <tr>
            <td width="40%"><label><?= Loc::getMessage("dki_VKEXPORTER_" . strtoupper($name) . "_FIELD_TITLE") ?>:</label></td>
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
        <td width="40%"><label><?= Loc::getMessage("dki_VKEXPORTER_CURRENCY_FIELD_TITLE") ?>:</label></td>
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
        <td width="40%"><label><?= Loc::getMessage("dki_VKEXPORTER_CATEGORY_FIELD_TITLE") ?>:</label></td>
        <td width="60%">
            <select name="category">
                <option value="">...</option>
                <?foreach ($_SESSION["dki_VKEXPORTER_MARKET_CATEGORIES"] as $id => $name):?>
                <option <?if ((int)$options->get()->category === (int)$id):?>selected=""<?endif?> value="<?= $id?>"><?= $name?></option>
                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="40%"><label><?= Loc::getMessage("dki_VKEXPORTER_ALBUM_FIELD_TITLE") ?>:</label></td>
        <td width="60%">
            <select name="album">
                <option value="">...</option>
                <?foreach ($arAlbums as $arAlbum):?>
                <option <?if ((int)$options->get()->album === (int)$arAlbum["ID"]):?>selected=""<?endif?> value="<?= $arAlbum["ID"]?>"><?= $arAlbum["UF_NAME"]?></option>
                <?endforeach;?>
            </select> &nbsp; <a onclick="window.jsUtils.OpenWindow('/bitrix/admin/dki_vkexporter_add_album.php', 700, 600);" href="javascript:void(0)">добавить</a>
        </td>
    </tr>
    <tr>
        <td width="40%"><label><?= Loc::getMessage("dki_VKEXPORTER_ALBUM_CREATE_FROM_PARENT_SECTION_FIELD_TITLE") ?>:</label></td>
        <td width="60%">
            <input value="0" type="hidden" name="album_create_from_parent_section">
            <input <?if ($options->get()->album_create_from_parent_section):?>checked=""<?endif?> value="1" type="checkbox" name="album_create_from_parent_section">
        </td>
    </tr>
    <? $o_tab->Buttons();
    ?>
    <input type="button" onclick="location = '?step=1&lang=<?= LANGUAGE_ID ?>'" name="prev" value="<?= Loc::getMessage("dki_VKEXPORTER_PREV_BTN_TITLE") ?>" title="<?= Loc::getMessage("dki_VKEXPORTER_PREV_BTN_TITLE") ?>">
    <input type="submit" name="next" value="<?= Loc::getMessage("dki_VKEXPORTER_NEXT_BTN_TITLE") ?>" title="<?= Loc::getMessage("dki_VKEXPORTER_NEXT_BTN_TITLE") ?>" class="adm-btn-save">


<?endif;

