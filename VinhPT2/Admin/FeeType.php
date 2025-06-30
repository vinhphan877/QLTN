<?php

namespace Samples\Newbie\VinhPT2\Admin;

use Data\CRUD;

/**
 * @property lib\FeeType $model Model tương ứng
 */
class FeeType extends CRUD {
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
        'delete' => 'owner',
        'edit' => 'owner',
    ];

}
