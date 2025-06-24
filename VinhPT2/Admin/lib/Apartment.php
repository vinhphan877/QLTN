<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:48 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data\lib\CRUD;
use Samples\Newbie\VinhPT2\Enum\lib\ApartmentStatus;

class Apartment extends CRUD {
    public static string $type = 'Newbie.VinhptApartment';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];

    protected function checkItem(array &$item): bool {
        $item['statusTitle'] = ApartmentStatus::getTitle($item['status'] ?? '');
        return parent::checkItem($item);
    }

    protected static function addFields(array &$items): void {
        foreach ($items as &$item) {
            $item['statusTitle'] = ApartmentStatus::getTitle($item['status'] ?? '');
        }
        \Data::getMoreFields('Newbie.VinhptBuilding', $items, [
            'buildingId' => ['title' => 'buildingTitle']
        ]);
    }

    protected function prepareList(array &$return): void {
        if (!empty($return['items'])) {
            ApartmentStatus::addTitle($return['items'], 'status');
        }
        static::addFields($return['items']);
        parent::prepareList($return);
    }

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        ApartmentEdit::setDefaultStatus($fields);
        return ApartmentEdit::checkRequired($fields, $return)
            && ApartmentEdit::checkFloor($fields, $oldItem)
            && ApartmentEdit::checkExists($fields, $return, $oldItem)
            && ApartmentEdit::checkBuilding($fields, $return)
            && ApartmentEdit::checkRoom($fields, $return)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

}
