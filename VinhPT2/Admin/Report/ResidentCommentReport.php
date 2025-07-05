<?php

namespace Samples\Newbie\VinhPT2\Admin\Report;

use Data\CRUD;

/**
 * @property lib\ResidentCommentReport $model Model tương ứng
 */
class ResidentCommentReport extends CRUD {
    public const ROLES = [
        'selectAll' => 'owner',
        'select' => 'owner',
        'selectList' => 'owner',
    ];

}
