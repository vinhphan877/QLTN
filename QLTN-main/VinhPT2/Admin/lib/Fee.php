<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:48 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Core\lib\BasicStatus;
use Data\lib\CRUD;

class Fee extends CRUD
{
    public static string $type = 'Newbie.VinhptFee';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];

    const STATUS_PAID = '0';
    const STATUS_UNPAID = '1';
    const STATUS_OVERDUE = '2';

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool
    {
        $requiredFields = ['amount', 'payDay', 'status', 'householdId', 'feeTypesId'];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (!isset($fields[$field]) || $fields[$field] === '') {
                $return['errors'][$field] = "Trường '{$field}' không được để trống.";
                $valid = false;
            }
        }

        if ($valid && !in_array($fields['status'], [self::STATUS_PAID, self::STATUS_UNPAID, self::STATUS_OVERDUE])) {
            $return['errors']['status'] = 'Trạng thái không hợp lệ';
            $valid = false;
        }

        if ($valid && !is_numeric($fields['amount'])) {
            $return['errors']['amount'] = 'Số tiền phải là số';
            $valid = false;
        }

        return $valid && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function checkItem(array &$item): bool
    {
        $item['statusTitle'] = match ($item['status'] ?? '') {
            self::STATUS_PAID => 'Đã trả',
            self::STATUS_UNPAID => 'Chưa trả',
            self::STATUS_OVERDUE => 'Quá hạn',
            default => ''
        };
        return parent::checkItem($item);
    }

    protected function prepareList(array &$return): void
    {
        if (!empty($return['items'])) {
            foreach ($return['items'] as &$item) {
                $item['statusTitle'] = match ($item['status'] ?? '') {
                    self::STATUS_PAID => 'Đã trả',
                    self::STATUS_UNPAID => 'Chưa trả',
                    self::STATUS_OVERDUE => 'Quá hạn',
                    default => ''
                };
            }
        }
        parent::prepareList($return);
    }
}
