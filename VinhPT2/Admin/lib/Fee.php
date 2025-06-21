<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:48 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;
use Data\lib\CRUD;

class Fee extends CRUD {
    public static string $type = 'Newbie.VinhptFee';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'orderBy' => 'createdTime DESC'
    ];

    protected function checkDelete(array &$item, array &$return): bool {
        return FeeEdit::validateStatus($item, $return)
            && parent::checkDelete($item, $return);
    }

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        $household = $oldItem['householdId'] ?? 0;
        return FeeEdit::checkRequired($fields, $return)
            && FeeEdit::checkTime($fields, $return, $household)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function addFields(array &$items): void {
        Data::getMoreFields('Newbie.Household', $items, [
            'householdId' => ['title' => 'householdTitle'],
        ]);
    }

    protected function prepareList(array &$return): void {
        parent::prepareList($return);
        $this->addFields($return['items']);
    }


}
