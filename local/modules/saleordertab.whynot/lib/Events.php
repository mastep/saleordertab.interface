<?php

namespace Module\CustomTab;

use Module\CustomTab\InfoTable;

/**
 * Класс для работы с событиями заказов
 */
class Events
{
    private static string $cname='IP';

    /**
     * Метод кастомизации списка заказов
     *
     * добавляется дополнительная колонка IP
     * @param $list
     */
    function CustomSaleOrderList(&$list)
    {
        if ($list->table_id=="tbl_sale_order") {
            foreach ($list->aRows as $row){

                $list->aVisibleHeaders[self::$cname] =
                    array(
                        "id" => self::$cname,
                        "content" => self::$cname,
                        "sort" => self::$cname,
                        "default" => true,
                        "align" => "left",
                    );

                $list->arVisibleColumns[]= self::$cname;

                foreach ($list->aRows as $row) {

                    $row->addField(
                        self::$cname,
                        ($data=InfoTable::getByPrimary(['order_id'=>$row->id],['select'=>['data'=>'data']])->fetch()['data'])?
                            '<div style="height: 200px; overflow: auto"><pre>'.print_r(json_decode($data,true),true).'</pre></div>' :'-'
                    );
                }
            }
        }
    }

    /**
     * Метод сохранения детальной информации по IP
     *
     * @param $event
     */

    function CustomAddSaleOrder($event)
    {
        if(is_object($event)) {
            $order=$event->getParameter("ENTITY");
            $isNew = $event->getParameter("IS_NEW");
            if ($isNew) {
                $id=$order->getId();
                $data = RequestRipe::GetInfo(\Bitrix\Main\Service\GeoIp\Manager::getRealIp());
                InfoTable::add([
                   'order_id' => $id,
                   'data' => $data,
                   'created_at' => new \Bitrix\Main\Type\DateTime()
                ]);
            }
        }
    }
}