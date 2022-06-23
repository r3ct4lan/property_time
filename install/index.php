<?php

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\SystemException;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
IncludeModuleLangFile(__FILE__);

class r3ct4lan_property_time extends CModule
{
    var $MODULE_ID = 'r3ct4lan.property_time';
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $PARTNER_NAME;
    var $PARTNER_URI;

    /**
     * r3ct4lan_property_time constructor.
     */
    function __construct()
    {
        $this->MODULE_NAME = GetMessage("RPT_IBPROP_MODULE_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("RPT_IBPROP_MODULE_DESCRIPTION");
        $this->PARTNER_NAME = GetMessage("RPT_IBPROP_MODULE_PARTNER_NAME");
        $this->PARTNER_URI = GetMessage("RPT_IBPROP_MODULE_PARTNER_URI");
        include(__DIR__ . '/version.php');
        if (isset($arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
    }

    /**
     * Установка модуля
     * @return bool
     */
    function DoInstall()
    {
        global $APPLICATION;
        $result = true;
        try {
            ModuleManager::registerModule($this->MODULE_ID);
            if (Loader::includeModule($this->MODULE_ID)) {
                $this->InstallEvents();
            } else {
                throw new SystemException(GetMessage('RPT_IBPROP_MODULE_NOT_REGISTERED'));
            }
        } catch (Exception $exception) {
            $result = false;
            $APPLICATION->ThrowException($exception->getMessage());
        }
        return $result;
    }

    /**
     * Деинсталяция модуля
     * @throws LoaderException
     */
    function DoUninstall()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            $this->UninstallEvents();
            ModuleManager::unRegisterModule($this->MODULE_ID);
        }
    }


    /** Установка обработчиков событий */
    function InstallEvents()
    {
        RegisterModuleDependences(
            "iblock",
            "OnIBlockPropertyBuildList",
            $this->MODULE_ID,
            "\\R3ct4lan\\Property\\Time",
            "GetUserTypeDescription",
            15000
        );
    }

    /** Удаление обработчиков событий */
    function UninstallEvents()
    {
        UnRegisterModuleDependences(
            "iblock",
            "OnIBlockPropertyBuildList",
            $this->MODULE_ID,
            "\\R3ct4lan\\Property\\Time",
            "GetUserTypeDescription"
        );
    }

}


