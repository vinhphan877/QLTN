<?php

namespace Samples\Newbie\VinhPT2\Admin\Report;

use Data\CRUD;

/**
 * @property lib\FeeReport $model Model tương ứng
 */
class FeeReport extends CRUD {
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
    ];

}
