<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use \Bitrix\Main\EventManager;
use Module\CustomTab\InfoTable;

Loc::loadMessages(__FILE__);

/**
 * Класс инсталяции модуля
 */
class saleordertab_whynot extends CModule
{
    /**
     * Конструктор
     */
    public function __construct()
    {
        $arModuleVersion = array();
        include __DIR__ . '/version.php';
        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        $this->MODULE_ID = 'saleordertab.whynot';
        $this->MODULE_NAME = Loc::getMessage('MYMODULE_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MYMODULE_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('MYMODULE_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = 'http://87.249.53.237/';
    }

    /**
     * Инсталяция модуля
     */
    public function doInstall()
    {
        /**
         * Регистрируем модуль
         */
        ModuleManager::registerModule($this->MODULE_ID);

        /**
         * Создаем таблицу
         */
        $this->installDB();

        /**
         * Добавляем события
         */
        EventManager::getInstance()->registerEventHandler(
            'main',
            'OnAdminListDisplay',
            $this->MODULE_ID,
            'Module\CustomTab\Events',
            'CustomSaleOrderList'
        );
        EventManager::getInstance()->registerEventHandler(
            'sale',
            'OnSaleOrderSaved',
            $this->MODULE_ID,
            'Module\CustomTab\Events',
            'CustomAddSaleOrder'
        );
    }
    /**
     * Деинсталяция модуля
     */
    public function doUninstall()
    {
        /**
         * Удаляем события
         */
        EventManager::getInstance()->unRegisterEventHandler(
            'main',
            'OnAdminListDisplay',
            $this->MODULE_ID,
            'Module\CustomTab\Events',
            'CustomSaleOrderList'
        );
        EventManager::getInstance()->unRegisterEventHandler(
            'sale',
            'OnSaleOrderSaved',
            $this->MODULE_ID,
            'Module\CustomTab\Events',
            'CustomSaleOrderList'
        );

        /**
         * Удаляем таблицу
         */
        $this->uninstallDB();

        /**
         * Деинсталируем модуль
         */
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    /**
     * Создание таблицы
     */
    public function installDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            InfoTable::getEntity()->createDbTable();
        }
    }

    /**
     * Удаление таблицы
     */
    public function uninstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            if (Application::getConnection()->isTableExists(Base::getInstance('\Module\CustomTab\InfoTable')->getDBTableName())) {
                $connection = Application::getInstance()->getConnection();
                $connection->dropTable(InfoTable::getTableName());
            }
        }
    }
}