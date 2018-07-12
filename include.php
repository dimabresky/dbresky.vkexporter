<?php

$classes = array(
    
    "dky\\vkexporter\\Manager" => "lib/Manager.php",
    "dky\\vkexporter\\Validator" => "lib/Validator.php",
    "dky\\vkexporter\\Connector" => "lib/Connector.php",
    
);


CModule::AddAutoloadClasses("dky.vkexporter", $classes);
