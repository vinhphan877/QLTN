<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:48 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Core\Enum\lib\Gender;
use Data;
use Data\lib\CRUD;
use Samples\Newbie\VinhPT2\Enum\lib\ApartmentStatus;

class Household extends CRUD {
    public static string $type = 'Newbie.VinhptHousehold';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];

    protected function checkDelete(array &$item, array &$return): bool {
        return HouseholdEdit::checkExits($return, $item)
            && parent::checkDelete($item, $return);
    }

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        return HouseholdEdit::checkRequired($fields, $return)
            && HouseholdEdit::checkValidApartment($fields, $return)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function prepareList(array &$return): void {
        if (!empty($return['items'])) {
            static::addFields($return['items']);
        }
        if (!empty($return['items'])) {
            Gender::addTitle($return['items'], 'gender');
        }
        parent::prepareList($return);

    }

    protected function checkItem(array &$item): bool {
        $item['genderTitle'] = Gender::getTitle($item['gender'] ?? '');
        return parent::checkItem($item);
    }

    public static function addFields(array &$items): void {
        foreach ($items as &$item) {
            $item['gender'] = ApartmentStatus::getTitle($item['gender'] ?? '');
        }
        Data::getMoreFields('Newbie.VinhptApartment', $items, [
            'apartmentId' => ['title' => 'apartmentTitle'],
        ]);

        Data::getMoreFields('Newbie.VinhptBuilding', $items, [
            'buildingId' => ['title' => 'buildingTitle'],
        ]);
    }
}
