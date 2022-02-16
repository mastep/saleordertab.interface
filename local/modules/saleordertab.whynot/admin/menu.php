<?php

use Bitrix\Main\Localization\Loc;

/**
 * Подгрузка локализации
 */
Loc::loadMessages(__FILE__);

/**
 * Добавление пункта меню
 */
$menu = array(
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 100,//
        'text' => Loc::getMessage('MYMODULE_MENU_TITLE'),
        'title' => Loc::getMessage('MYMODULE_MENU_TITLE'),
        'url' => 'mymodule_index.php',
        'items_id' => 'menu_references',
        'items' => array(
            array(
                'text' => Loc::getMessage('MYMODULE_SUBMENU_TITLE'),
                'url' => 'mymodule_index.php?lang=' . LANGUAGE_ID,
                'more_url' => array('mymodule_index.php?lang=' . LANGUAGE_ID),
                'title' => Loc::getMessage('MYMODULE_SUBMENU_TITLE'),
            ),
        ),
    ),
);

return $menu;