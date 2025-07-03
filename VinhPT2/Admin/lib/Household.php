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

    #[\Service]
    public static function getResidentReportByAge(): array {
        $residents = Data('Newbie.VinhptHousehold')->select([
            'fields' => [
                'site' => portal()->id,
                '_id' => Data::objectId($fields['householdId'] ?? ''),
                'age' => $fields['age'] ?? '',
            ]
        ]);

        $ageGroups = [
            '0-6' => 0,
            '6-12' => 0,
            '12-18' => 0,
            '18-24' => 0,
            '24-60' => 0,
            '60+' => 0
        ];

        foreach ($residents as $resident) {
            $age = $resident['age'] ?? '';

            if (!is_numeric($age)) {
                continue;
            }

            if ($age >= 0 && $age < 6) {
                $ageGroups['0-6']++;
            } elseif ($age < 12) {
                $ageGroups['6-12']++;
            } elseif ($age < 18) {
                $ageGroups['12-18']++;
            } elseif ($age < 24) {
                $ageGroups['18-24']++;
            } elseif ($age < 60) {
                $ageGroups['24-60']++;
            } else {
                $ageGroups['60+']++;
            }
        }

        return $ageGroups;
    }

    #[\Service]
    public static function getResidentReportByGender(): array {
        $residents = Data('Newbie.VinhptHousehold')->select([
            'fields' => [
                'site' => portal()->id,
                '_id' => Data::objectId($fields['householdId'] ?? ''),
                'name' => $fields['name'] ?? '',
                'gender' => $fields['gender'] ?? '',
            ]
        ]);

        $result = [
            'male' => [],
            'female' => [],
            'other' => []
        ];

        foreach ($residents as $resident) {
            switch ($resident['gender'] ?? '') {
                case Gender::MALE->value:
                    $result['male'][] = $resident;
                    break;
                case Gender::FEMALE->value:
                    $result['female'][] = $resident;
                    break;
                default:
                    $result['other'][] = $resident;
                    break;
            }
        }

        return $result;
    }
//Mảng trả về kết quả như sau:Array
//(
//    [rules] => Array
//        (
//        )
//
//    [messages] => Array
//        (
//        )
//
//    [service] => Samples.Newbie.VinhPT2.Admin.Household.select
//    [layout] => Samples.Newbie.VinhPT2.Admin.Household.detail
//    [itemId] => 686498205bce3e3713010b14
//    [colomboDebug2] => 0
//    [gridModuleParentId] => 1
//    [xPopup] => backdrop:'static',keyboard: false
//    [popup] => 1
//    [modalClass] => modal-fullscreen
//    [module] => Content.Form
//    [region] => center
//    [position] => 1
//    [index] => 0
//    [modulePosition] => 0
//    [id] => 2001
//    [path] => Content
//    [moduleParentId] => -1
//    [_entityTitle] => bản ghi
//    [_id] => MongoDB\BSON\ObjectId Object
//        (
//            [oid] => 686498205bce3e3713010b14
//        )
//
//    [createdTime] => 1751423008
//    [lastUpdateTime] => 1751423008
//    [sortOrder] => 1751423008
//    [creatorId] => 5912582
//    [site] => 2005948
//    [type] => Newbie.VinhptHousehold
//    [apartmentId] => 685a7d41526ad02f230ff969
//    [title] => rthrhr
//    [members] => Array
//        (
//            [1] => Array
//                (
//                    [name] => etge
//                    [age] => 32
//                    [gender] => 2
//                )
//
//        )
//
//    [startTime] => 2194621200
//    [endTime] => 2320246799
//    [suggestTitle] => rthrhr||rthrhr||rthrhr||rthrhr||Rthrhr
//    [type1] => Newbie
//    [type2] => Newbie.VinhptHousehold
//    [genderTitle] =>
//    [rootURL] => https://newbie.coquan.vn/
//    [staticURL] => /
//    [currency] => VND
//    [mid] => 2001
//)
//1
// Vấn đề đặt ra là genderTitle sẽ chỉ trar về cho 1 members và không truy xuất được do không nằm trong members
// Và nếu có nhiều members thì sẽ không xử lý được.
//Sửa lôỗi này
}
