<?php

namespace Samples\Newbie\VinhPT2\Admin;

use Data\CRUD;

/**
 * @property lib\Apartment $model Model tương ứng
 */
class Apartment extends CRUD {
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
        'delete' => 'owner',
        'edit' => 'owner',
    ];

}
