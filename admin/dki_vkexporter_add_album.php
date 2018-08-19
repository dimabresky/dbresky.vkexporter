<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_popup_admin.php");

use Bitrix\Main\Localization\Loc;
use dki\vkexporter\tables\Albums;

Loc::loadMessages(__FILE__);

Bitrix\Main\Loader::includeModule("dki.vkexporter");

global $USER_FIELD_MANAGER;

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$from_form = false;
if ($request->isPost() && strlen($request->getPost("save")) && check_bitrix_sessid()) {
    $from_form = true;
    $data = [];
    $USER_FIELD_MANAGER->EditFormAddFields("HLBLOCK_" . Albums::getTableId(), $data);
    $table = Albums::getTable();
    $result = $table->add($data);
    $ID = $result->getId();
    if ($ID > 0) {
        ?>
        <script>
            var pd = window.opener.document;
            var option = document.createElement("option");
            var select = pd.querySelector("select[name=album]");
            option.value = <?= $ID ?>;
            option.selected = true;
            option.innerText = "<?= $data["UF_NAME"] ?>";
            console.log(select);
            select.appendChild(option);
            select.dispatchEvent(new Event("change"));
            window.close();
        </script>
        <?
        die;
    }
}

$o_tab = new CAdminTabControl("dkiTabControl", array(
    array(
        "DIV" => "vkexporter",
        "TAB" => Loc::getMessage("dki_VKEXPORTER_ALBUM_TAB_TITLE"),
        "ICON" => "",
        "TITLE" => Loc::getMessage("dki_VKEXPORTER_ALBUM_TAB_SUBTITLE")
    )
        ));
?>
<form action="<? $APPLICATION->GetCurPage() ?>" method="post" enctype="multipart/form-data">
    <?
    echo bitrix_sessid_post();
    $o_tab->Begin();
    $o_tab->BeginNextTab();
    $arFields = $USER_FIELD_MANAGER->getUserFieldsWithReadyData("HLBLOCK_" . Albums::getTableId(), null, LANGUAGE_ID);
    unset($arFields["UF_VK_ID"]);
    foreach ($arFields as $arField) {
        echo $USER_FIELD_MANAGER->GetEditFormHTML($from_form, [], $arField);
    }
    $o_tab->Buttons();
    ?>
    <input type="submit" name="save" value="23234<?= Loc::getMessage("dki_VKEXPORTER_SAVE_BTN_TITLE") ?>" title="<?= Loc::getMessage("dki_VKEXPORTER_SAVE_BTN_TITLE") ?>" class="adm-btn-save">
    <? $o_tab->End();
    ?>
</form>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_popup_admin.php");
