<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:49 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;
use Data\lib\CRUD;
use Samples\Newbie\VinhPT2\Enum\lib\FeedBackStatus;

class ResidentComment extends CRUD {
    public static string $type = 'Newbie.VinhptResidentComment';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        ResidentCommentEdit::setDefaultStatus($fields);
        return ResidentCommentEdit::checkRequired($fields, $return)
            && ResidentCommentEdit::checkExists($fields, $return, $oldItem)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function prepareList(array &$return): void {
        if (!empty($return['items'])) {
            static::addFields($return['items']);
            FeedBackStatus::addTitle($return['items'], 'status');
        }
        parent::prepareList($return);
    }

    protected function checkItem(array &$item): bool {
        $item['statusTitle'] = FeedBackStatus::getTitle($item['status'] ?? '');
        return parent::checkItem($item);
    }

    public static function addFields(array &$items): void {
        Data::getMoreFields('Newbie.VinhptHousehold', $items, [
            'householdId' => ['title' => 'householdTitle']
        ]);
    }

}
