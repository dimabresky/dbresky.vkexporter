<?php

namespace dki\vkexporter\tables;

use Bitrix\Highloadblock\HighloadBlockTable as HL;

/**
 * Таблица настроек выгрузки
 * 
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
class Options {
    
    public static function getTable() {
        
        static $table = NULL;
        
        if (!$table) {
            
            $table = HL::compileEntity(HL::getById(\Bitrix\Main\Config\Option::get("dki.vkexporter", "VKEXPORTER_OPTIONS_STORAGE_ID"))->fetch())->getDataClass();
        }
        
        return new $table;
    }
    
}