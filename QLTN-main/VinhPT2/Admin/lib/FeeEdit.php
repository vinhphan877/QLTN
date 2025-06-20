<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:55 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;

class FeeEdit
{
    public static string $type = 'Newbie.VinhptFee';

    public static function checkRequired(array $fields, array &$return): bool
    {
        $requiredFields = [
            'amount',
            'payDay',
            'status',
            'householdId',
            'feeTypesId'
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

    public static function validateAmount(array $fields, array &$return): bool
    {
        if (!empty($fields['amount']) && $fields['amount'] <= 0) {
            $return['errors']['amount'] = 'Số tiền phải lớn hơn 0';
            return false;
        }
        return true;
    }

    public static function checkExistsFee(array $fields, array &$return, array $oldItem = []): bool
    {
        if (!empty($fields['householdId']) && !empty($fields['feeTypesId'])) {
            $filters = [
                'site' => portal()->id,
                'householdId' => $fields['householdId'],
                'feeTypesId' => $fields['feeTypesId']
            ];
            if (!empty($oldItem)) {
                $filters['_id'] = ['$ne' => Data::objectId($oldItem['id'])];
            }
            if (Data(static::$type)->select($filters)) {
                $return['message'] = 'Khoản phí này đã tồn tại cho hộ gia đình này';
                return false;
            }
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
                $return['message'] = 'Hộ gia đình không tồn tại';
                return false;
            }
        }
        return true;
    }

    public static function validateStatus(array $fields, array &$return): bool
    {
        $validStatuses = ['0', '1', '2'];
        if (!empty($fields['status']) && !in_array($fields['status'], $validStatuses)) {
            $return['errors']['status'] = 'Trạng thái không hợp lệ';
            return false;
        }
        return true;
    }
}
