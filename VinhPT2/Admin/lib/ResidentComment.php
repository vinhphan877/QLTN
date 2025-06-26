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
            ResidentCommentEdit::addFields($return['items']);
        }
        parent::prepareList($return);
    }

    protected function checkDelete(array &$item, array &$return): bool {
        return parent::checkDelete($item, $return);
    }

}
