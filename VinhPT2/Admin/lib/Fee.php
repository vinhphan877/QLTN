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
use Samples\Newbie\VinhPT2\Enum\lib\FeeStatus;

class Fee extends CRUD {
    public static string $type = 'Newbie.VinhptFee';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        if (!FeeEdit::checkRequired($fields, $return)
            || !FeeEdit::validateStatusOnCreate($fields, $return)
            || !FeeEdit::checkTime($fields, $return)) {
            return false;
        }

        Data('Newbie.VinhptHousehold')->select([
            '_id' => Data::objectId($fields['householdId'])
        ]);

        return parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function checkDelete(array &$item, array &$return): bool {
        return FeeEdit::validateStatusOnDelete($item, $return)
            && parent::checkDelete($item, $return);
    }

    protected function addFields(array &$items): void {
        Data::getMoreFields('Newbie.VinhptHousehold', $items, [
            'householdId' => ['title' => 'householdTitle'],
        ]);
        Data::getMoreFields('Newbie.VinhptFeeType', $items, [
            'feeTypeId' => ['title' => 'feeTypeTitle'],
        ]);
    }

    protected function prepareList(array &$return): void {
        parent::prepareList($return);
        if (!empty($return['items'])) {
            FeeStatus::addTitle($return['items'], 'status');
            $this->addFields($return['items']);
        }

    }

}
