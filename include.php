<?php

$classes = array(
    
    "dky\\vkexporter\\Connector" => "lib/Connector.php",
    "dky\\vkexporter\\Options" => "lib/Options.php",
    "dky\\vkexporter\\Tools" => "lib/Tools.php",
    
);


CModule::AddAutoloadClasses("dky.vkexporter", $classes);
