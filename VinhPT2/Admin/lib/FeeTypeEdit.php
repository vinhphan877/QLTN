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
        $requiredFields = ['title', 'price', 'deadline'];
        foreach ($requiredFields as $field) {
            if (!isset($fields[$field]) || $fields[$field] === '') {
                $return['message'] = "Thiếu trường bắt buộc: $field";
                $return['errors']['fields[' . $field . ']'] = "Trường này không được để trống.";
                return false;
            }
        }
        return true;
    }

    public static function setDefaultStatus(array &$fields): void {
        if (empty($fields['status'])) {
            $fields['status'] = 0;
        }
    }

    /**
     * Kiểm tra độ dài tối đa của tên loại phí.
     * @author vinhpt
     * @param array $fields
     * @param array $return
     * @return bool
     */
    public static function checkTitleLength(array $fields, array &$return): bool {
        if (!empty($fields['title']) && mb_strlen($fields['title']) > 225) {
            $return['message'] = 'Tên loại phí không được vượt quá 225 ký tự.';
            $return['errors']['fields[title]'] = 'Độ dài tối đa là 225 ký tự.';
            return false;
        }
        return true;
    }

    /**
     *Y svhrdee
     * Kiểm tra tính hợp lệ của hạn nộp.
     * @author vinhpt
     * @param array $fields
     * @param array $return
     * @return bool
     */
    public static function checkDeadline(array $fields, array &$return): bool {
        $start = (int)($fields['deadlineStartDay'] ?? 0);
        $end = (int)($fields['deadlineEndDay'] ?? 0);

        if ($start < 1 || $start > 31 || $end < 1 || $end > 31) {
            $return['message'] = 'Ngày hạn nộp phải là một ngày hợp lệ trong tháng (từ 1 đến 31).';
            $return['errors']['fields[deadlineStartDay]'] = 'Ngày không hợp lệ.';
            return false;
        }

        if ($start > $end) {
            $return['message'] = 'Ngày bắt đầu hạn nộp phải trước hoặc bằng ngày kết thúc.';
            $return['errors']['fields[deadlineEndDay]'] = 'Ngày kết thúc phải sau ngày bắt đầu.';
            return false;
        }
        return true;
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
