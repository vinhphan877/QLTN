<?php
/**
 *
 * @author vinhpt
 * @date 6/3/2025
 * @time 4:51 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

class BuildingEdit {
    public static function checkRequired(array $fields, array &$return): bool {
        $requiredFields = [
            'title',
            'totalFloor',
            'floorKind',
            'totalRoom',
            'since'
        ];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (empty($fields[$field])) {
                $return['errors'][$field] = "Trường '{$field}' không được để trống.";
                $valid = false;
            }
        }
        return $valid;
    }

}
