<?

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/modules/dbresky.vkexporter/admin/dbresky_vk_access_token.php")) {
    $_SERVER["DOCUMENT_ROOT"] . "/local/modules/dbresky.vkexporter/admin/dbresky_vk_access_token.php";
} else {
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/dbresky.vkexporter/admin/dbresky_vk_access_token.php");
}
