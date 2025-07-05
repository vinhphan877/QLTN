<?php
/**
 *
 * @author vinhpt
 * @date 7/4/2025
 * @time 4:48 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\Report\lib;

use Core\Enum\lib\Gender;
use Data;
use Data\lib\Listing;

class ResidentGenderReport extends Listing {
    public static string $type = 'Newbie.VinhptHousehold';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => 'members',
        'orderBy' => 'createdTime DESC'
    ];

    protected function prepareList(array &$return): void {
        Data('Newbie.VinhptHousehold')->select([
            'site' => portal()->id,
            'fields' => ['members']
        ]);

        parent::prepareList($return);

    }

}
