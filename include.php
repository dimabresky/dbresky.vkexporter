<?php

$classes = array(
    
    "dki\\vkexporter\\Connector" => "lib/Connector.php",
    "dki\\vkexporter\\Options" => "lib/Options.php",
    "dki\\vkexporter\\Tools" => "lib/Tools.php",
    
);


CModule::AddAutoloadClasses("dki.vkexporter", $classes);
