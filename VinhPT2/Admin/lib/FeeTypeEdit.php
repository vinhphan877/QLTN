<?php

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;

class FeeTypeEdit {

    public static string $type = 'Newbie.VinhptFeeType';

    /**
     * Kiểm tra các trường bắt buộc.
     * @author vinhpt
     * @param array $fields
     * @param array $return
     * @return bool
     */
    public static function checkRequired(array $fields, array &$return): bool {
        $requiredFields = ['title', 'price'];
        foreach ($requiredFields as $field) {
            if (!isset($fields[$field]) || $fields[$field] === '') {
                $return['message'] = "Thiếu trường bắt buộc: $field";
                $return['errors']['fields[' . $field . ']'] = "Trường này không được để trống.";
                return false;
            }
        }
        return true;
    }

    /**
     * Đặt trạng thái mặc định khi tạo mới loại phí
     * @author vinhpt
     * @param array $fields
     */
    public static function setDefaultStatus(array &$fields): void {
        if (empty($fields['status'])) {
            $fields['status'] = 0;
        }
    }

    /**
     * Kiểm tra sự tồn tại của loại phí.
     * @author vinhpt
     * @param array $fields
     * @param array $return
     * @param array $oldItem
     * @return bool
     */
    public static function checkExists(array $fields, array &$return, array $oldItem): bool {
        if (!empty($fields['title'])) {
            $filters = [
                'site' => portal()->id,
                'title' => $fields['title']
            ];
            if (!empty($oldItem['id'])) {
                $filters['_id'] = ['$ne' => Data::objectId($oldItem['id'])];
            }
            if (Data(static::$type)->select($filters)) {
                $return['message'] = 'Loại phí này đã tồn tại.';
                $return['errors']['fields[title]'] = 'Loại phí này đã tồn tại.';
                return false;
            }
        }
        return true;
    }

}
