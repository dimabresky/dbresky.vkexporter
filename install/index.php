<?php

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ModuleManager,
    Bitrix\Main\Loader,
    Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

class dki_vkexporter extends CModule {

    public $MODULE_ID = "dki.vkexporter";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_GROUP_RIGHTS = "N";
    public $namespaceFolder = "dki";
    public $adminFilesList = array(
        "dki_vkexporter.php",
        "dki_vk_access_token.php",
        "dki_vkexporter_add_album.php"
    );
    public $highloadblocksFiles = array();

    function __construct() {
        $arModuleVersion = array();
        $path_ = str_replace("\\", "/", __FILE__);
        $path = substr($path_, 0, strlen($path_) - strlen("/index.php"));
        include($path . "/version.php");
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
        $this->MODULE_NAME = Loc::getMessage("dki_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("dki_MODULE_DESC");
        $this->PARTNER_NAME = Loc::getMessage("dki_PARTNER_NAME");
        $this->PARTNER_URI = "https://github.com/dimabresky/";

        Loader::includeModule("highloadblock");
        $this->__loadHigloadblockFiles();
        set_time_limit(0);
    }

    public function copyFiles() {
        
        foreach ($this->adminFilesList as $file) {
            CopyDirFiles(
                    $_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/admin/" . $file, $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin/" . $file, true, true
            );
        }
    }

    public function deleteFiles() {
        foreach ($this->adminFilesList as $file) {
            DeleteDirFilesEx("/bitrix/admin/" . $file);
        }
        
        return true;
    }

    public function DoInstall() {
        try {
            
            # регистрируем модуль
            ModuleManager::registerModule($this->MODULE_ID);

            # создание higloadblock модуля
            $this->createHighloadblockTables();

            # копирование файлов
            $this->copyFiles();
            
            # добавление зависимостей модуля
            $this->addModuleDependencies();
            
            # добавление параметров выбора для модуля
            $this->addOptions();
        } catch (Exception $ex) {

            $GLOBALS["APPLICATION"]->ThrowException($ex->getMessage());

            $this->DoUninstall();

            return false;
        }

        return true;
    }

    public function DoUninstall() {
        
        # удаляем зависимости модуля
        $this->deleteModuleDependencies();

        # удаление таблиц higloadblock
        $this->deleteHighloadblockTables();
        
        # удаление файлов
        $this->deleteFiles();

        # удаление параметров модуля
        $this->deleteOptions();

        ModuleManager::unRegisterModule($this->MODULE_ID);

        return true;
    }
    
    public function addModuleDependencies () {
        RegisterModuleDependences("", "DKIVKEXPORTERALBUMSOnAfterAdd", $this->MODULE_ID, "\\dki\\vkexporter\\EventsHandlers", "onAfterAddAlbum");
        RegisterModuleDependences("", "DKIVKEXPORTERALBUMSOnBeforeUpdate", $this->MODULE_ID, "\\dki\\vkexporter\\EventsHandlers", "onAfterUpdateAlbum");
    }
    
    public function deleteModuleDependencies () {
        UnRegisterModuleDependences("", "DKIVKEXPORTERALBUMSOnAfterAdd", $this->MODULE_ID, "\\dki\\vkexporter\\EventsHandlers", "onAfterAddAlbum");
        UnRegisterModuleDependences("", "DKIVKEXPORTERALBUMSOnAfterUpdate", $this->MODULE_ID, "\\dki\\vkexporter\\EventsHandlers", "onAfterUpdateAlbum");
    }
    
    public function addOptions() {}
    

    public function deleteOptions() {}
  
    public function createHighloadblockTables() {

        foreach ($this->highloadblocksFiles as $file) {

            $arr = include "highloadblocks/" . $file;

            $result = Bitrix\Highloadblock\HighloadBlockTable::add(array(
                        'NAME' => $arr["table_data"]["NAME"],
                        'TABLE_NAME' => $arr["table"]
            ));

            if (!$result->isSuccess()) {
                throw new Exception($arr["table_data"]['ERR'] . "<br>" . implode("<br>", (array) $result->getErrorMessages()));
            }

            $table_id = $result->getId();

            Option::set($this->MODULE_ID, $arr["table_data"]["OPTION_PARAMETER"], $table_id);

            $arr_fields = $arr["fields"];

            $oUserTypeEntity = new CUserTypeEntity();

            foreach ($arr_fields as $arr_field) {

                $arr_field["ENTITY_ID"] = str_replace("{{table_id}}", $table_id, $arr_field["ENTITY_ID"]);

                if (!$oUserTypeEntity->Add($arr_field)) {
                    throw new Exception(Loc::getMessage("dki_HL_ADD_ERROR") . $arr_field["ENTITY_ID"] . "[" . $arr_field["FIELD_NAME"] . "]" . $oUserTypeEntity->LAST_ERROR);
                }
            }
            
            if (isset($arr["items"]) && !empty($arr["items"])) {
                
                $entity   = Bitrix\Highloadblock\HighloadBlockTable::compileEntity( 
                        Bitrix\Highloadblock\HighloadBlockTable::getById($table_id)->fetch());
                $class = $entity->getDataClass();
                foreach ($arr["items"] as $item) {
                    $class::add($item);
                }
            }
        }
    }

    public function deleteHighloadblockTables() {

        foreach ($this->highloadblocksFiles as $file) {

            $arr = include "highloadblocks/" . $file;

            $table_id = Option::get($this->MODULE_ID, $arr["table_data"]["OPTION_PARAMETER"]);
            if ($table_id > 0) {
                Bitrix\Highloadblock\HighloadBlockTable::delete($table_id);
            }
            Option::delete($this->MODULE_ID, array("name" => $arr["table_data"]["OPTION_PARAMETER"]));
        }
    }

    public function getSiteId() {

        static $arSites = array();

        if (!empty($arSites)) {
            return $arSites;
        }

        $dbSites = CSite::GetList($by = "sort", $order = "asc");

        while ($arSite = $dbSites->Fetch()) {
            $arSites[] = $arSite['ID'];
        }

        return $arSites;
    }

    private function __loadHigloadblockFiles() {

        $this->highloadblocksFiles = $this->__loadFiles("highloadblocks");
    }

    private function __loadFiles($dirName) {

        $directory = __DIR__ . "/" . $dirName;
        return array_diff(scandir($directory), array('..', '.'));
    }
}
