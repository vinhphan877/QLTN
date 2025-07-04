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

    protected function editSuccess(array &$return, array $fields, array $oldItem): void {
        if (!empty($fields['apartmentId'])) {
            Data('Newbie.VinhptApartment')->update(
                ['status' => ApartmentStatus::RENTED->value],
                ['_id' => $fields['apartmentId']]
            );
        }
        parent::editSuccess($return, $fields, $oldItem);
    }

    protected function deleteSuccess(array &$return, array &$item): void {
        if (!empty($item['apartmentId'])) {
            Data('Newbie.VinhptApartment')->update(
                ['status' => ApartmentStatus::NOTRENT->value],
                ['_id' => $item['apartmentId']]
            );
        }
        parent::deleteSuccess($return, $item);
    }

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        return HouseholdEdit::checkRequired($fields, $return)
            && HouseholdEdit::checkValidApartment($fields, $return, $oldItem)
            && HouseholdEdit::checkTime($fields, $return)
            && HouseholdEdit::checkExists($fields, $return, $oldItem)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function prepareList(array &$return): void {
        if (!empty($return['items'])) {
            static::addFields($return['items']);
            Gender::addTitle($return['items'], 'gender');
        }

        parent::prepareList($return);
    }

    protected static function addFields(array &$items): void {
        Data::getMoreFields('Newbie.VinhptApartment', $items, [
                'apartmentId' => ['title' => 'apartmentTitle']
            ]
        );
    }

    protected function checkItem(array &$item): bool {
        if (!empty($item['members']) && is_array($item['members'])) {
            foreach ($item['members'] as &$member) {
                if (isset($member['gender'])) {
                    $member['genderTitle'] = Gender::getTitle((string)$member['gender']);
                }
            }
        }

        return parent::checkItem($item);
    }

}
