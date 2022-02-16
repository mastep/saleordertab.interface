<?php
use Bitrix\Main\Loader;

/**
 * Подгружаем классы для корректной работы модуля
 */
Loader::registerAutoLoadClasses('saleordertab.whynot', [
    'Module\CustomTab\InfoTable' => 'lib/InfoTable.php',
    'Module\CustomTab\Events' => 'lib/Events.php',
    'Module\CustomTab\RequestRipe' => 'lib/RequestRipe.php',
]);