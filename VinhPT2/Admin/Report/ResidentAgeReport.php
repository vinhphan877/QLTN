<?php

namespace Samples\Newbie\VinhPT2\Admin\Report;

use Data\CRUD;

/**
 * @property lib\ResidentAgeReport $model Model tương ứng
 */
class ResidentAgeReport extends CRUD {
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
    ];

}
