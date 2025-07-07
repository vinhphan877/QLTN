<?php

namespace Samples\Newbie\VinhPT2\Admin\Report;

use Service;

class ResidentAgeReport extends Service {
    public static string $type = 'Newbie.VinhptHousehold';
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
    ];

    public function statistic(array $filters = []): array {
        $return = [];
        $filters['site'] = portal()->id;
        if ($data = Data(static::$type)->match($filters)->group('age', [
            'total' => ['$sum' => '$']
        ])->selectAll()) {

            $return['items'] = $data;
        }
        return $return;
    }

}
