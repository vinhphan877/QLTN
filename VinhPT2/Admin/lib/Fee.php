<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:48 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data\lib\CRUD;


class Fee extends CRUD {
    public static string $type = 'Newbie.VinhptFee';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'orderBy' => 'createdTime DESC'
    ];

}
