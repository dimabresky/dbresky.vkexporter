<?

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/modules/dbresky.vkexporter/admin/dbresky_vkexporter_add_album.php")) {
    require($_SERVER["DOCUMENT_ROOT"] . "/local/modules/dbresky.vkexporter/admin/dbresky_vkexporter_add_album.php");
} else {
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/dbresky.vkexporter/admin/dbresky_vkexporter_add_album.php");
}
?>
