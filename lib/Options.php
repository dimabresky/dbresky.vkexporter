<?php

namespace dki\vkexporter;

/**
 * Класс настроек модуля
 *
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
class Options {

    protected $_table = NULL;
    
    protected $_row_id = NULL;

    public function __construct() {

        $this->_table = tables\Options::getTable();
        
        if (!isset($_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"])) {

            $arRow = $this->_table->getList(array("filter" => array("UF_USER_ID" => $GLOBALS["USER"]->GetID())))->fetch();
            
            if (isset($arRow["ID"]) && $arRow["ID"] > 0) {
                $this->_row_id = $arRow["ID"];
            }
            
            if (isset($arRow["UF_OPTIONS"]) && strlen($arRow["UF_OPTIONS"])) {
                $_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"] = unserialize($arRow["UF_OPTIONS"]);
            } else {
                $_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"] = (object) array(
                            "iblock_id" => NULL,
                            "name" => "NAME",
                            "picture" => "DETAIL_PICTURE",
                            "description" => "DETAIL_TEXT",
                            "price" => NULL,
                            "currency" => NULL,
                            "update_exists" => 1,
                            "access_token" => NULL,
                            "app_id" => NULL,
                            "app_secret" => NULL
                );
            }
        }

        $_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"]->app_id = \Bitrix\Main\Config\Option::get("dki.vkexporter", "APP_ID");
        $_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"]->app_secret = \Bitrix\Main\Config\Option::get("dki.vkexporter", "APP_SECRET");
        
    }

    public function get() {
        return $_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"];
    }

    /**
     * Сохраняет значение параметров выгрузки
     * @param array $options
     */
    public function save(array $options) {

        $o = &$_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"];

        foreach ($options as $fcode => $fval) {

            switch ($fcode) {

                case "iblock_id":
                case "name":
                case "picture":
                case "description":
                case "price":
                case "access_token":
                case "currency":
                    $o->$fcode = $fval;
                    break;

                case "update_exists":
                    $o->$fcode = boolval($fval);
                    break;
            }
        }
        
        if ($this->_row_id > 0) {
            $this->_table->update($this->_row_id, array("UF_OPTIONS" => serialize($o)));
        } else {
            $this->_row_id = $this->_table->add(array("UF_USER_ID" => $GLOBALS["USER"]->GetID(), "UF_OPTIONS" => serialize($o)));
        }
    }

}
