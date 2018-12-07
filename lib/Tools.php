<?php

namespace dbresky\vkexporter;

use Bitrix\Main\Localization\Loc;

/**
 * Класс "инструментов" модуля
 *
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
class Tools {

    /**
     * Возвращает доступные инфоблоки для выгрузки
     * @return array
     */
    public static function getAvailIblocks() {

        static $arIblocks = array();

        if (empty($arIblocks)) {
            $dbIblockList = \Bitrix\Iblock\IblockTable::getList(array("filter" => array("ACTIVE" => "Y")));

            while ($arIblock = $dbIblockList->fetch()) {
                $arIblocks[$arIblock["ID"]] = $arIblock;
            }
        }

        return $arIblocks;
    }

    /**
     * @return array
     */
    public function getURLParametersForDel() {

        return array_merge(["iblock_id", "step", "sessid", "autosave_id", "next", "dbreskyTabControl_active_tab"], \array_keys((array) (new Options)->get()));
    }

    /**
     * Доступные валюты выгрузки
     * @return array
     */
    public function getAvailCurrency() {

        return array(
            "USD" => "USD",
            "RUB" => "RUB",
            "EUR" => "EUR",
            "BYN" => "BYN",
        );
    }

    public function getIblockProperties($iblock) {

        static $arProperties = array();

        if (empty($arProperties)) {
            $dbList = \Bitrix\Iblock\PropertyTable::getList(array("filter" => array("IBLOCK_ID" => $iblock)));
            while ($arProperty = $dbList->fetch()) {
                $arProperties["PROPERTY_" . $arProperty["CODE"]] = $arProperty["NAME"];
            }
        }

        return $arProperties;
    }

    /**
     * Проверка полей
     * @param array $arFields
     * @return array
     */
    public static function checkFields($arFields) {

        $arErrors = array();

        foreach ($arFields as $fcode => $fval) {

            switch ($fcode) {

                case "iblock_id":
                case "app_id":
                case "owner_id":
                    if ($fval <= 0) {
                        $arErrors[] = strtoupper($fcode) . "_ERROR";
                    }
                    break;

                case "name":
                case "picture":
                case "description":
                case "price":
                case "access_token":
                case "app_secret":
                    if (!strlen($fval)) {
                        $arErrors[] = strtoupper($fcode) . "_ERROR";
                    }
                    break;

                case "currency":
                    if (!isset(self::getAvailCurrency()[$fval])) {
                        $arErrors[] = strtoupper($fcode) . "_ERROR";
                    }
                    break;

                case "category":
                    if (!isset($_SESSION["dbresky_VKEXPORTER_MARKET_CATEGORIES"][$fval])) {
                        $arErrors[] = strtoupper($fcode) . "_ERROR";
                    }
                    break;
            }
        }

        return $arErrors;
    }

    /**
     * @param array $errors_code
     * @return string
     */
    public static function getHTMLErrors(array $errors_code) {
        ob_start();
        \CAdminMessage::ShowMessage(array(
            "MESSAGE" => implode('<br>', array_map(function ($error_code) {
                                return \Bitrix\Main\Localization\Loc::getMessage("dbresky_VKEXPORTER_" . $error_code);
                            }, $errors_code)),
            "TYPE" => "ERROR",
            "HTML" => true
        ));
        return ob_get_clean();
    }

    /**
     * @global \CMain $APPLICATION
     * @param string $rel_path
     */
    public static function loadCss($rel_path) {

        global $APPLICATION;

        if (\file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/modules' . $rel_path)) {
            
            $path = $_SERVER['DOCUMENT_ROOT'] . '/local/modules' . $rel_path;
        } else {

            $path = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules' . $rel_path;
        }

        ob_start();
        include_once $path;
        $styles = ob_get_clean();

        $APPLICATION->AddHeadString("<style>$styles</style>");
    }

}
