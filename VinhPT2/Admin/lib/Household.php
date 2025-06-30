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
    function getHouseholdMembers(array $household): array {
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
    #[\Service]
    public function getResidentReportByAgeGroup(): array {
        $pipeline = [
            ['$unwind' => '$members'],
            ['$replaceRoot' => ['newRoot' => '$members']],
            [
                '$facet' => [
                    'group_0_6' => [
                        ['$match' => ['age' => ['$gt' => 0, '$lte' => 6]]],
                        ['$sort' => ['age' => 1]]
                    ],
                    'group_7_12' => [
                        ['$match' => ['age' => ['$gt' => 6, '$lte' => 12]]],
                        ['$sort' => ['age' => 1]]
                    ],
                    'group_13_18' => [
                        ['$match' => ['age' => ['$gt' => 12, '$lte' => 18]]],
                        ['$sort' => ['age' => 1]]
                    ],
                    'group_19_24' => [
                        ['$match' => ['age' => ['$gt' => 18, '$lte' => 24]]],
                        ['$sort' => ['age' => 1]]
                    ],
                    'group_25_60' => [
                        ['$match' => ['age' => ['$gt' => 24, '$lte' => 60]]],
                        ['$sort' => ['age' => 1]]
                    ],
                    'group_over_60' => [
                        ['$match' => ['age' => ['$gt' => 60]]],
                        ['$sort' => ['age' => 1]]
                    ]
                ]
            ]
        ];

        $aggregationResult = Data(static::$type)->aggregate($pipeline);

        $result = $aggregationResult[0] ?? [];

        $finalReport = [
            '0-6 tuổi' => $result['group_0_6'] ?? [],
            '7-12 tuổi' => $result['group_7_12'] ?? [],
            '13-18 tuổi' => $result['group_13_18'] ?? [],
            '19-24 tuổi' => $result['group_18_24'] ?? [],
            '25-60 tuổi' => $result['group_25_60'] ?? [],
            'Trên 60 tuổi' => $result['group_over_60'] ?? [],
        ];

        return $finalReport;
    }

    #[\Service]
    public function getResidentReportByGender(): array {
        $pipeline = [
            ['$unwind' => '$members'],
            [
                '$group' => [
                    '_id' => '$members.gender',
                    'count' => ['$sum' => 1]
                ]
            ],
            [
                '$sort' => [
                    '_id' => 1
                ]
            ]
        ];

        $aggregationResult = Data(static::$type)->aggregate($pipeline);

        $finalReport = [];
        if (!empty($aggregationResult)) {
            foreach ($aggregationResult as $item) {
                $genderTitle = Gender::getTitle($item['_id']);

                if ($item['_id'] === '' || $genderTitle === '') {
                    continue;
                }

                $finalReport[] = [
                    'gender' => $genderTitle,
                    'count' => $item['count']
                ];
            }
        }

        return $finalReport;
    }

}
