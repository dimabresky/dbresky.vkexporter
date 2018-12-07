<?php

$classes = array(
    
    "dbresky\\vkexporter\\Gateway" => "lib/Gateway.php",
    "dbresky\\vkexporter\\Options" => "lib/Options.php",
    "dbresky\\vkexporter\\EventsHandlers" => "lib/EventsHandlers.php",
    "dbresky\\vkexporter\\Tools" => "lib/Tools.php",
    "dbresky\\vkexporter\\tables\\Options" => "lib/tables/Options.php",
    "dbresky\\vkexporter\\tables\\Albums" => "lib/tables/Albums.php",
    "dbresky\\vkexporter\\tables\\Table" => "lib/tables/Table.php",
    
);


CModule::AddAutoloadClasses("dbresky.vkexporter", $classes);

\Bitrix\Main\Loader::includeModule("iblock");
\Bitrix\Main\Loader::includeModule("highloadblock");
