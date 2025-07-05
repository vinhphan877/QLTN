<?php

namespace Samples\Newbie\VinhPT2\Admin\Report;

use Data\CRUD;

/**
 * @property lib\ResidentGenderReport $model Model tương ứng
 */
class ResidentGenderReport extends CRUD {
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
    ];

}
