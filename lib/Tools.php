<?php

namespace dki\vkexporter;

\Bitrix\Main\Loader::includeModule("iblock");

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

        return array("iblock_id", "step", "sessid", "autosave_id", "next", "dkiTabControl_active_tab", "name", "picture", "description", "price", "currency", "update_exists");
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
                    if ($fval <= 0) {
                        $arErrors[] = strtoupper($fcode) . "_ERROR";
                    }
                    break;

                case "name":
                case "picture":
                case "description":
                case "price":
                case "access_token":
                    if (!strlen($fval)) {
                        $arErrors[] = strtoupper($fcode) . "_ERROR";
                    }
                    break;

                case "currency":
                    if (!isset(self::getAvailCurrency()[$fval])) {
                        $arErrors[] = strtoupper($fcode) . "_ERROR";
                    }
                    break;
            }
        }

        return $arErrors;
    }

}
