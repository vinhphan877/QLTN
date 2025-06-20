<?php

namespace Samples\Newbie\VinhPT2\Admin;

use Data\CRUD;

/**
 * @property lib\ResidentComment $model Model tương ứng
 */
class ResidentComment extends CRUD {
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
        'delete' => 'owner',
        'edit' => 'owner',
    ];

}
