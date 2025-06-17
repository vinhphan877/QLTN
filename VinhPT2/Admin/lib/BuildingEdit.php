<?php
/**
 *
 * @author vinhpt
 * @date 6/3/2025
 * @time 4:51 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;
use CMS\Article\lib\Status;

/**
 * @property $type
 */
class BuildingEdit {
    public static string $type = 'Newbie.VinhptBuilding';

    public static function checkRequired(array $fields, array &$return): bool {
        $requiredFields = [
            'title',
            'address',
            'totalFloor',
            'totalRoom',
            'status'
        ];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (empty($fields[$field])) {
                $return['errors'][$field] = "Trường '{$field}' không được để trống.";
                $valid = false;
            }
        }

        if ($valid && !Status::getTitle($fields['status'])) {
            $return['message'] = $return['errors']['fields[status]'] = 'Trạng thái không hợp lệ';
            $valid = false;
        }

        return $valid;
    }

    public static function validateBuilding(array $fields, array &$return): bool {
        if (!empty($fields['totalFloor'])
            && ($fields['totalFloor'] < 10 || $fields['totalFloor'] > 80)) {
            $return['errors']['totalFloor'] = 'Số tầng phải nằm trong khoảng từ 10 đến 80';
            return false;
        }
        return true;
    }

    public static function checkExistsBuilding(array $fields, array $oldItem, array &$return): bool {
        $filters = [
            'title' => $fields['title'],
            'address' => $fields['address'],
            'totalFloor' => $fields['totalFloor'],
            'totalRoom' => $fields['totalRoom']
        ];

        if (!empty($oldItem)) {
            $filters['_id'] = ['$ne' => Data::objectId($oldItem['id'])];
        }

        $existing = Data(self::$type)->select($filters);
        if ($existing) {
            $return['message'] = 'Tòa nhà này đã tồn tại';
            return false;
        }
        return true;
    }

}
