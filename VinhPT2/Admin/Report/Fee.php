<?php

namespace Samples\Newbie\VinhPT2\Admin\Report;

use Service;
use Samples\Newbie\VinhPT2\Enum\lib\FeeStatus;

class Fee extends Service {
    public static string $type = 'Newbie.VinhptFee';
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
    ];

    public function statistic(array $filters = []): array {
        $return = [];
        $filters['site'] = portal()->id;
        if ($data = Data(static::$type)->match($filters)->group('status', [
            'totalAmount' => ['$sum' => '$amount']
        ])->selectAll()) {
            FeeStatus::addTitle($data, '_id');
            $return['items'] = $data;
        }
        return $return;
    }

}
