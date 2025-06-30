<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:48 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data\lib\CRUD;
use Samples\Newbie\VinhPT2\Enum\lib\FeeTypeStatus;

class FeeType extends CRUD {
    public static string $type = 'Newbie.VinhptFeeType';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        return FeeTypeEdit::setDefaultStatus($fields)
            && FeeTypeEdit::checkRequired($fields, $return)
            && FeeTypeEdit::checkTitleLength($fields, $return)
            && FeeTypeEdit::checkDeadline($fields, $return)
            && FeeTypeEdit::checkExists($fields, $return, $oldItem)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function checkItem(array &$item): bool {
        $item['statusTitle'] = FeeTypeStatus::getTitle($item['status'] ?? '');
        return parent::checkItem($item);
    }

    protected function prepareList(array &$return): void {
        if (!empty($return['items'])) {
            FeeTypeStatus::addTitle($return['items'], 'status');
        }
        parent::prepareList($return);
    }

}
