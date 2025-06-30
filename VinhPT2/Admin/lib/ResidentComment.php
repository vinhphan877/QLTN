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
        }
        parent::prepareList($return);
    }

    protected static function getUnProcessedCommentsList(array &$items): void {
        $items = array_filter($items, function ($item) {
            return $item['status'] === 0;
        });
    }

    protected static function getProcessedCommentsList(array &$items): void {
        $items = array_filter($items, function ($item) {
            return $item['status'] === 1;
        });
    }

    public static function addFields(array &$items): void {
        Data::getMoreFields('Newbie.VinhptHousehold', $items, [
            'householdId' => ['title' => 'householdName']
        ]);
    }
}
