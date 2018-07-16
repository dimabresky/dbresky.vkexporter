<?php
if (!$USER->isAdmin())
    return;

$mid = "dki.vkexporter";

//\Bitrix\Main\Loader::includeModule("highloadblock");
//\Bitrix\Main\Loader::includeModule("iblock");
\Bitrix\Main\Loader::includeModule($mid);

global $APPLICATION;

function renderOptions($arOptions, $mid) {

    foreach ($arOptions as $name => $arValues) {

        $cur_opt_val = htmlspecialcharsbx(Bitrix\Main\Config\Option::get($mid, $name));
        $name = htmlspecialcharsbx($name);

        $options .= '<tr>';
        $options .= '<td width="40%">';
        $options .= '<label for="' . $name . '">' . $arValues['DESC'] . ':</label>';
        $options .= '</td>';
        $options .= '<td width="60%">';
        if ($arValues['TYPE'] == 'select') {

            $options .= '<select id="' . $name . '" name="' . $name . '">';
            foreach ($arValues['VALUES'] as $key => $value) {
                $options .= '<option ' . ($cur_opt_val == $key ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
            }
            $options .= '</select>';
        } elseif ($arValues['TYPE'] == 'text') {

            $options .= '<input type="text" name="' . $name . '" value="' . $cur_opt_val . '">';
        }
        $options .= '</td>';
        $options .= '</tr>';
    }
    echo $options;
}



$main_options = array(
    array(
        "APP_ID" => array("DESC" => "ID приложения", "VALUES" => "", 'TYPE' => 'text'),
        "APP_SECRET" => array("DESC" => "Защищенный ключ", "VALUES" => "", 'TYPE' => 'text')
    ),
);


$tabs = array(
    array(
        "DIV" => "edit1",
        "TAB" => "Настройки модуля",
        "ICON" => "",
        "TITLE" => ""
    )
);

$o_tab = new CAdminTabControl("TravelsoftTabControl", $tabs);
if ($REQUEST_METHOD == "POST" && strlen($save . $reset) > 0 && check_bitrix_sessid()) {

    if (strlen($reset) > 0) {
        foreach ($main_options as $name => $desc) {
            \Bitrix\Main\Config\Option::delete($mid, array('name' => $name));
        }
    } else {
        foreach ($main_options as $arBlockOption) {

            foreach ($arBlockOption as $name => $arValues) {
                if (isset($_REQUEST[$name])) {
                    \Bitrix\Main\Config\Option::set($mid, $name, $_REQUEST[$name]);
                }
            }
        }
    }

    LocalRedirect($APPLICATION->GetCurPage() . "?mid=" . urlencode($mid) . "&lang=" . urlencode(LANGUAGE_ID) . "&" . $o_tab->ActiveTabParam());
}
$o_tab->Begin();
?>

<form method="post" action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($mid) ?>&amp;lang=<? echo LANGUAGE_ID ?>">
    <?
    foreach ($main_options as $arOption) {
        $o_tab->BeginNextTab();
        renderOptions($arOption, $mid);
    }
    $o_tab->Buttons();
    ?>
    <input type="submit" name="save" value="Сохранить" title="Сохранить" class="adm-btn-save">
    <input type="submit" name="reset" title="Сбросить" OnClick="return confirm('Сбросить')" value="Сбросить">
    <?= bitrix_sessid_post(); ?>
    <? $o_tab->End(); ?>
</form>
