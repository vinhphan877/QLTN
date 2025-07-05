<?php
/**
 *
 * @author vinhpt
 * @date 7/4/2025
 * @time 4:46 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\Report\lib;

use Data\lib\Listing;

class ResidentCommentReport extends Listing {
    public static string $type = 'Newbie.VinhptHousehold';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];
}
