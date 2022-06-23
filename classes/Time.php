<?php

namespace R3ct4lan\Property;

use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Localization\Loc;
use \DateTime;
use DateTimeZone;

class Time
{
    const USER_TYPE = 'Time';

    /**
     * @return array
     */
    public static function GetUserTypeDescription()
    {
        $result = array(
            "PROPERTY_TYPE" => PropertyTable::TYPE_STRING,
            "USER_TYPE" => self::USER_TYPE,
            "DESCRIPTION" => Loc::getMessage("RPT_IBPROP_TI_TYPENAME")
        );

        /** @see Time::GetPropertyFieldHtml(); */
        $result["GetPropertyFieldHtml"] = [__CLASS__, "GetPropertyFieldHtml"];

        /** @see Time::CheckFields() */
        $result["CheckFields"] = [__CLASS__, "CheckFields"];

        /** @see Time::ConvertToDB(); */
        $result["ConvertToDB"] = [__CLASS__, "ConvertToDB"];

        /** @see Time::ConvertFromDB(); */
        $result["ConvertFromDB"] = [__CLASS__, "ConvertFromDB"];
        return $result;
    }

    /**
     * Вывод свойства в панели
     * @param $arProperty
     * @param $value
     * @param $strHTMLControlName
     * @return string
     */
    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        ob_start();
        require __DIR__ . "/../templates/Time/field_html.php";
        return ob_get_clean();
    }


    /**
     * Проверяет введенное значение
     * @param $arProperty
     * @param $value
     * @return array
     */
    public static function CheckFields($arProperty, $value)
    {
        $result = array();
        if ($value["VALUE"] <> '') {
            $regex = '/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/';
            if (!preg_match($regex, $value['VALUE'])) {
                $result[] = Loc::getMessage(
                    "RPT_IBPROP_TI_ERROR_FORMAT",
                    array("#FIELD_NAME#" => $arProperty["NAME"])
                );
            }
        }
        return $result;
    }


    /**
     * Cохранение свойства в БД
     * @param $arProperty
     * @param $value
     * @return mixed
     */
    public static function ConvertToDB($arProperty, $value)
    {
        $midnight = (new DateTime('today midnight'))->getTimestamp();
        if ($value['VALUE'] <> "") {
            $val = DateTime::createFromFormat('H:i', $value['VALUE'])->getTimestamp();
            $value['VALUE'] = $val - $midnight;
        }
        return $value;
    }

    /**
     * Извлечение значения из БД
     * @param $arProperty
     * @param $value
     * @return mixed
     */
    public static function ConvertFromDB($arProperty, $value)
    {
        return ($value['VALUE'] <> "") ? [
            'VALUE' => (new DateTime)->setTimestamp($value['VALUE'])->setTimezone(new DateTimeZone('+0'))->format(
                "H:i"
            ),
            'DESCRIPTION' => $value['DESCRIPTION']
        ] : [];
    }

}
