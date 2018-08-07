<?php

$classes = array(
    
    "dki\\vkexporter\\Gateway" => "lib/Gateway.php",
    "dki\\vkexporter\\Options" => "lib/Options.php",
    "dki\\vkexporter\\Tools" => "lib/Tools.php",
    "dki\\vkexporter\\tables\\Options" => "lib/tables/Options.php",
    
);


CModule::AddAutoloadClasses("dki.vkexporter", $classes);

\Bitrix\Main\Loader::includeModule("iblock");
\Bitrix\Main\Loader::includeModule("highloadblock");
