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

    /**
     * Lấy thông tin cư dân trong hộ gia đình
     * @author vinhpt
     * @param array $household
     * @return array
     */
    #[\Service]
    public function getHouseholdMembers(array $household): array {
        $members = [];

        if (!empty($household['members']) && is_array($household['members'])) {
            foreach ($household['members'] as $member) {
                $genderText = Gender::getTitle($member['gender'] ?? '') ?? '';

                $members[] = [
                    'name' => $member['name'] ?? '',
                    'age' => $member['age'] ?? '',
                    'gender' => $genderText
                ];
            }
        }
        return $members;
    }

    /**
     * Lấy danh sách cư dân theo độ tuổi
     * @author vinhpt
     * @return array|array[]
     */
    public static function getResidentReportByAge($flield, $item): array {}

    /**
     * Lấy danh sách cư dân theo giới tính
     * @author vinhpt
     * @return array
     */

    public static function getResidentReportByGender(): array {
        $pipeline = [
            ['$unwind' => '$members'],
            ['$replaceRoot' => ['newRoot' => '$members']],
            [
                '$facet' => [
                    'group_male' => [
                        ['$match' => ['gender' => Gender::MALE->value]],
                        ['$sort' => ['age' => 1]]
                    ],
                    'group_female' => [
                        ['$match' => ['gender' => Gender::FEMALE->value]],
                        ['$sort' => ['age' => 1]]
                    ],
                    'group_other' => [
                        ['$match' => ['gender' => Gender::OTHER->value]],
                        ['$sort' => ['age' => 1]]
                    ]
                ]
            ]
        ];
        $aggregationResult = Data(static::$type)->aggregate($pipeline);
        $result = $aggregationResult[0] ?? [];
        return [
            'Nam' => $result['group_male'] ?? [],
        ];
    }

}
