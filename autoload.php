<?php

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(
    'r3ct4lan.property_time',
    [
        '\\R3ct4lan\\Property\\Time' => 'classes/Time.php', //свое условие для ПРСК
    ]
);
