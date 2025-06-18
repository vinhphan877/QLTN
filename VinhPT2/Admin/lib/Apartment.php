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

    protected function checkDelete(array &$item, array &$return): bool {
        if (!empty($item['status']) && $item['status'] == 1) {
            $return['message'] = 'Căn hộ đã có người thuê, không được xóa';
            return false;
        }
        return parent::checkDelete($item, $return);
    }

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
        return ApartmentEdit::checkRequired($fields, $return)
            && ApartmentEdit::checkFloor($fields, $oldItem)
            && ApartmentEdit::checkExists($fields, $return, $oldItem)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

}
