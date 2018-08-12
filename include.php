<?php

$classes = array(
    
    "dki\\vkexporter\\Gateway" => "lib/Gateway.php",
    "dki\\vkexporter\\Options" => "lib/Options.php",
    "dki\\vkexporter\\EventsHandlers" => "lib/EventsHandlers.php",
    "dki\\vkexporter\\Tools" => "lib/Tools.php",
    "dki\\vkexporter\\tables\\Options" => "lib/tables/Options.php",
    "dki\\vkexporter\\tables\\Albums" => "lib/tables/Albums.php",
    "dki\\vkexporter\\tables\\Table" => "lib/tables/Table.php",
    
);


CModule::AddAutoloadClasses("dki.vkexporter", $classes);

\Bitrix\Main\Loader::includeModule("iblock");
\Bitrix\Main\Loader::includeModule("highloadblock");
