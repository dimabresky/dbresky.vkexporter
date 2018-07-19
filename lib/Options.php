<?php

namespace dki\vkexporter;

/**
 * Класс настроек модуля
 *
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
class Options {

    public function __construct() {
        if (!isset($_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"])) {
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
                "app_secrect" => NULL
            );
        }
        
        $_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"]->app_id = \Bitrix\Main\Config\Option::get("dki.vkexporter", "APP_ID");
        $_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"]->app_secrect = \Bitrix\Main\Config\Option::get("dki.vkexporter", "APP_SECRET");
    }
    
    public function get() {
        return $_SESSION["dki_VKEXPORTER_EXPORT_OPTIONS"];
    }
    
    /**
     * Сохраняет значение параметров выгрузки
     * @param array $options
     */
    public function save (array $options) {
        
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
    }
}
