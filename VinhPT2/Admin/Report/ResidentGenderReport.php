<?php

namespace Samples\Newbie\VinhPT2\Admin\Report;

use Core\Enum\lib\Gender;
use Service;

class ResidentGenderReport extends Service {
    public static string $type = 'Newbie.VinhptHousehold';
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
    ];

    public function statistic(array $filters = []): array {
        $return = [
            'items' => [],
            'genderCount' => [
                'male' => 0,
                'female' => 0,
                'other' => 0
            ]
        ];

        $filters['site'] = portal()->id;

        $members = Data(static::$type)->match($filters)->select([
            'name' => 1,
            'age' => 1,
            'gender' => 1
        ]);

        if ($members) {
            $return['items'] = $members;

            foreach ($members as $member) {
                $gender = $member['gender'] ?? null;

                switch ($gender) {
                    case Gender::MALE->value:
                        $return['genderCount']['male']++;
                        break;
                    case Gender::FEMALE->value:
                        $return['genderCount']['female']++;
                        break;
                    case Gender::OTHER->value:
                    default:
                        $return['genderCount']['other']++;
                        break;
                }
            }
        }

        return $return;
    }

}
