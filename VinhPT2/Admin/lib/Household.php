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
        }
        parent::prepareList($return);
    }

    protected static function addFields(array &$items): void {
        Data::getMoreFields('Newbie.VinhptApartment', $items, [
            'apartmentId' => ['title' => 'apartmentTitle']
        ]);
    }

    #[\Service]
    public function getHouseholdMembers(): array {
        return Data('Newbie.VinhptHousehold')->select([
            'site' => portal()->id,
            '_id' => Data::objectId($fields['householdId'] ?? ''),
        ]);
    }

    #[\Service]
    public static function getResidentReportByAge(): array {
        $citizens = Data('Newbie.VinhptHousehold')->select([
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

        foreach ($citizens as $citizen) {
            $age = $citizen['age'] ?? '';

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
        $citizens = Data('Newbie.VinhptHousehold')->select([
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

        foreach ($citizens as $citizen) {
            switch ($citizen['gender'] ?? '') {
                case Gender::MALE->value:
                    $result['male'][] = $citizen;
                    break;
                case Gender::FEMALE->value:
                    $result['female'][] = $citizen;
                    break;
                default:
                    $result['other'][] = $citizen;
                    break;
            }
        }

        return $result;
    }

}
