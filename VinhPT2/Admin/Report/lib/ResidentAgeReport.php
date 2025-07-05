<?php
/**
 *
 * @author vinhpt
 * @date 7/4/2025
 * @time 4:47 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\Report\lib;

use Data\lib\Listing;
use Data;

class ResidentAgeReport extends Listing {
    public static string $type = 'Newbie.VinhptHousehold';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];
    public static function getResidentReportByAge(): array {
        $residents = Data('Newbie.VinhptHousehold')->select([
            'fields' => [
                'site' => portal()->id,
                '_id' => Data::objectId($fields['householdId'] ?? ''),
                'age' => $fields['age'] ?? ''
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

}
