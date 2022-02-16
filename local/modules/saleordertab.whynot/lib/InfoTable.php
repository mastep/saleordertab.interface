<?php

namespace Module\CustomTab;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\TextField;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type;
Loc::loadMessages(__FILE__);

/**
 * Класс для работы с доп.параметрами заказа
 */
class InfoTable extends DataManager
{
    /**
     * Метод получения названия таблицы
     * @return string
     */
    public static function getTableName()
    {
        return 'wnt_saleordertab';
    }

    /**
     * Метод описания модели
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            new IntegerField('id', array(
                'autocomplete' => true,
                'primary' => true
            )),
            new IntegerField('order_id', array(
                'primary' => true
            )),
            new TextField('data', array(
                'required' => true,
                'title' => Loc::getMessage('MYMODULE_ADRESS'),
                'default_value' => function () {
                    return 'NULL';
                }
            )),
            new DatetimeField('created_at',array(
                'required' => true))
        );
    }
}