<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:55 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;

class ResidentCommentEdit
{
    public static string $type = 'Newbie.VinhptFeedBack';

    public static function checkRequired(array $fields, array &$return): bool
    {
        $requiredFields = [
            'title',
            'content',
            'status',
            'householdId'
        ];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (!isset($fields[$field]) || $fields[$field] === '') {
                $return['errors'][$field] = "Trường '{$field}' không được để trống.";
                $valid = false;
            }
        }

        return $valid;
    }

    public static function validateStatus(array $fields, array &$return): bool
    {
        if (isset($fields['status']) && !in_array($fields['status'], [0, 1])) {
            $return['errors']['status'] = 'Trạng thái không hợp lệ';
            return false;
        }
        return true;
    }

    public static function validateHousehold(array $fields, array &$return): bool
    {
        if (!empty($fields['householdId'])) {
            if (!Data('Newbie.VinhptHousehold')->select([
                'site' => portal()->id,
                'id' => $fields['householdId']
            ])) {
                $return['errors']['householdId'] = 'Hộ gia đình không tồn tại';
                return false;
            }
        }
        return true;
    }
}
