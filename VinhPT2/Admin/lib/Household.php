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

class Household extends CRUD {
    public static string $type = 'Newbie.VinhptHousehold';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'orderBy' => 'createdTime DESC'
    ];

    protected function editSuccess(array &$return, array $fields, array $oldItem): void {
        if (!empty($fields['apartmentId'])) {
            Data('Newbie.VinhptApartment')->update(['status' => 1],
                ['_id' => $fields['apartmentId']]);
        }
        parent::editSuccess($return, $fields, $oldItem);
    }

    protected function deleteSuccess(array &$return, array &$item): void {
        if (!empty($item['apartmentId'])) {
            Data('Newbie.VinhptApartment')->update(['status' => 0],
                ['_id' => $item['apartmentId']]);
        }
        parent::deleteSuccess($return, $item);
    }

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        return HouseholdEdit::checkRequired($fields, $return)
            && HouseholdEdit::checkValidApartment($fields, $return)
            && HouseholdEdit::checkTime($fields, $return)
            && HouseholdEdit::checkExists($fields, $return, $oldItem)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function prepareList(array &$return): void {
        if (!empty($return['items'])) {
            Gender::addTitle($return['items'], 'gender');
            static::addFields($return['items']);
        }
        parent::prepareList($return);
    }

    protected function checkItem(array &$item): bool {
        Gender::addTitle($item, 'gender');
        return parent::checkItem($item);
    }

    protected static function addFields(array &$items): void {
        Data::getMoreFields('Newbie.VinhptApartment', $items, [
            'apartmentId' => ['title' => 'apartmentTitle']
        ]);
    }

    /**
     * Lấy thông tin danh sách thành viên của một hộ gia đình
     *
     * @param array $household Mảng dữ liệu hộ gia đình
     * @return array Danh sách thành viên với tên, tuổi và giới tính hiển thị
     */
    #[\Service]
    function getHouseholdMembers(array $household): array {
        $members = [];

        if (!empty($household['members']) && is_array($household['members'])) {
            foreach ($household['members'] as $member) {
                $name = $member['name'] ?? 'Không rõ';
                $age = $member['age'] ?? 'Không rõ';
                $gender = $member['gender'] ?? '';

                if ($gender === 0 || $gender === '0' || Gender::getTitle($gender) === 'Nam') {
                    $genderText = 'Nam';
                } elseif ($gender === 1 || $gender === '1' || Gender::getTitle($gender) === 'Nữ') {
                    $genderText = 'Nữ';
                } else {
                    $genderText = 'Khác';
                }

                $members[] = [
                    'name' => $name,
                    'age' => $age,
                    'gender' => $genderText
                ];
            }
        }

        return $members;
    }


}
