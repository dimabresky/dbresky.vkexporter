<?php

namespace dki\vkexporter;

/**
 * Класс настроек модуля
 *
 * @author ИП Бреский Дмитрий Игоревич <dimabresky@gmail.com>
 */
class Options {
    
    protected $_table = NULL;
    
    /**
     * @var int
     */
    protected $_row_id = NULL;
    
    /**
     * @var \stdClass
     */
    protected $_options = NULL;

    public function __construct() {

        $this->_table = tables\Options::getTable();

        $arRow = $this->_table->getList(array("filter" => array("UF_USER_ID" => $GLOBALS["USER"]->GetID())))->fetch();

        if (isset($arRow["ID"]) && $arRow["ID"] > 0) {
            $this->_row_id = $arRow["ID"];
        }

        if (isset($arRow["UF_OPTIONS"]) && strlen($arRow["UF_OPTIONS"])) {
            $this->_options = unserialize($arRow["UF_OPTIONS"]);
        } else {
            $this->_options = (object) array(
                        "iblock_id" => NULL,
                        "name" => "NAME",
                        "picture" => "DETAIL_PICTURE",
                        "description" => "DETAIL_TEXT",
                        "price" => NULL,
                        "currency" => NULL,
                        "category" => NULL,
                        "access_token" => NULL,
                        "app_id" => NULL,
                        "app_secret" => NULL
            );
        }

        $this->_options->app_id = \Bitrix\Main\Config\Option::get("dki.vkexporter", "APP_ID");
        $this->_options->app_secret = \Bitrix\Main\Config\Option::get("dki.vkexporter", "APP_SECRET");
        
    }

    public function get() {
        return $this->_options;
    }

    /**
     * Сохраняет значение параметров выгрузки
     * @param array $options
     */
    public function save(array $options) {

        foreach ($options as $fcode => $fval) {

            switch ($fcode) {

                case "iblock_id":
                case "name":
                case "picture":
                case "description":
                case "price":
                case "access_token":
                case "currency":
                case "category":
                    $this->_options->$fcode = $fval;
                    break;
            }
        }
        
        if ($this->_row_id > 0) {
            $this->_table->update($this->_row_id, array("UF_OPTIONS" => serialize($this->_options)));
        } else {
            $this->_row_id = $this->_table->add(array("UF_USER_ID" => $GLOBALS["USER"]->GetID(), "UF_OPTIONS" => serialize($this->_options)));
        }
    }

}
