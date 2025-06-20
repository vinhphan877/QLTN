<?php

namespace Samples\Newbie\VinhPT2\Admin;

use Data\CRUD;

/**
 * @property lib\Fee $model Model tương ứng
 */
class Fee extends CRUD {
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
        'delete' => 'owner',
        'edit' => 'owner',
    ];

}
