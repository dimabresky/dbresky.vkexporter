<?

IncludeModuleLangFile(__FILE__);


$aMenu = array(
    "parent_menu" => "global_menu_services",
    "section" => "vkexporter",
    "sort" => 10000,
    "text" => GetMessage("DKY_VKEXPORTER_MENU_TITLE"),
    "title" => GetMessage("DKY_VKEXPORTER_MENU_TITLE"),
    "icon" => "",
    "page_icon" => "",
    "items_id" => "menu_vkexporter",
    "url" => "dky_vkexporter.php?lang=" . LANGUAGE_ID
);

return $aMenu;
?>