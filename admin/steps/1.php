<?php
if (empty(\dky\vkexporter\Tools::checkFields(array("iblock_id" => $request->get("iblock_id")))) && check_bitrix_sessid()) {

    $options->save(array("iblock_id" => $request->get("iblock_id")));
    LocalRedirect($APPLICATION->GetCurPageParam("step=2", \dky\vkexporter\Tools::getURLParametersForDel()));
}
?>
<tr>
    <td width="40%"><label>Выберите инфоблок для выгрузки:</label></td>
    <td width="60%">
        <select name="iblock_id">
            <option value="">...</option>
            <? foreach (\dky\vkexporter\Tools::getAvailIblocks() as $arIblock): ?>
                <option <? if ((int) $arIblock["ID"] === (int) $options->get()->iblock_id): ?>selected=""<? endif ?> value="<?= $arIblock["ID"] ?>"><?= $arIblock["NAME"] ?></option>
            <? endforeach; ?>
        </select>
    </td>
</tr>
<? $o_tab->Buttons();
?>
<input type="submit" name="next" value="Далее" title="Далее" class="adm-btn-save">