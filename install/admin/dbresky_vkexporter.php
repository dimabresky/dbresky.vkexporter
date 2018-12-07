<?

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/modules/dbresky.vkexporter/admin/dbresky_vkexporter.php")) {
    require($_SERVER["DOCUMENT_ROOT"] . "/local/modules/dbresky.vkexporter/admin/dbresky_vkexporter.php");
} else {
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/dbresky.vkexporter/admin/dbresky_vkexporter.php");
}
?>
