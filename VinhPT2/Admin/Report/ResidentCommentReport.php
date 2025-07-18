<?php

namespace Samples\Newbie\VinhPT2\Admin\Report;

use Service;

class ResidentCommentReport extends Service {
    public static string $type = 'Newbie.VinhptResidentComment';
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
    ];

    public function statistic(array $filters = []): array {
        $return = [];
        $filters['site'] = portal()->id;
        if ($data = Data(static::$type)->match($filters)->group('status', [
            'total' => ['$count' => '$status']
        ])->selectAll()) {
            $return['items'] = $data;
        }
        return $return;
    }

}
