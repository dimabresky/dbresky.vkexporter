<?php

namespace dki\vkexporter\tables;

use Bitrix\Highloadblock\HighloadBlockTable as HL;

/**
 * Абстрактный класс таблиц
 *
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
abstract class Table {
    
    public static function getTable() {
        
        static $table = NULL;
        
        if (!$table) {
            
            $class = get_called_class();
            $table = HL::compileEntity(HL::getById(\Bitrix\Main\Config\Option::get("dki.vkexporter", $class::$_option_name))->fetch())->getDataClass();
        }
        
        return new $table;
    }
}
