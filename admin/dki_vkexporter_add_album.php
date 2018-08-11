<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_popup_admin.php");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Bitrix\Main\Loader::includeModule("dki.vkexporter");
