<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:49 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data\lib\CRUD;

class ResidentComment extends CRUD {
    public static string $type = 'Newbie.VinhptFeedBack';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool
    {
        return ResidentCommentEdit::checkRequired($fields, $return)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function checkItem(array &$item): bool
    {
        $item['statusTitle'] = ($item['status'] ?? 0) ? 'Đã xử lý' : 'Chưa xử lý';
        return parent::checkItem($item);
    }

    protected function prepareList(array &$return): void
    {
        if (!empty($return['items'])) {
            static::addFields($return['items']);
        }
        parent::prepareList($return);
    }

    protected static function addFields(array &$items): void
    {
        foreach ($items as &$item) {
            $item['statusTitle'] = ($item['status'] ?? 0) ? 'Đã xử lý' : 'Chưa xử lý';
        }
    }
}
