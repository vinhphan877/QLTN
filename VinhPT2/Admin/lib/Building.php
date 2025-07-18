<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:47 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Core\lib\BasicStatus;
use Data\lib\CRUD;

class Building extends CRUD {
    public static string $type = 'Newbie.VinhptBuilding';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        return BuildingEdit::checkRequired($fields, $return)
            && BuildingEdit::validateBuilding($fields, $return)
            && BuildingEdit::checkExistsBuilding($fields, $return, $oldItem)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function checkItem(array &$item): bool {
        $item['statusTitle'] = BasicStatus::getTitle($item['status'] ?? '');
        return parent::checkItem($item);
    }

    protected function prepareList(array &$return): void {
        if (!empty($return['items'])) {
            BasicStatus::addTitle($return['items'], 'status');
        }
        parent::prepareList($return);
    }

    protected static function addFields(array &$items): void {
        foreach ($items as &$item) {
            $item['statusTitle'] = BasicStatus::getTitle($item['status'] ?? '');
        }
    }

}
