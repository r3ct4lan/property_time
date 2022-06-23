<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

global $APPLICATION;

if (!Loader::includeModule("iblock")) {
    $APPLICATION->ThrowException(Loc::getMessage('RPT_ERROR_IBLOCK_NOT_INSTALLED'));
    return false;
}

require_once __DIR__ . '/autoload.php';
