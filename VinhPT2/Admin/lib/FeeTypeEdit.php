<?php
/**
 *
 * @author vinhpt
 * @date 6/27/2025
 * @time 9:37 AM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;
use Samples\Newbie\VinhPT2\Enum\lib\FeeTypeStatus;

class FeeTypeEdit {

    public static string $type = 'Newbie.VinhptFeeType';

    /**
     * Kiểm tra các trường bắt buộc trong form
     * @param array $fields Mảng chứa thông tin dữ liệu cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @return bool Trả về true nếu tất cả trường bắt buộc hợp lệ, ngược lại trả về false
     */
    public static function checkRequired(array $fields, array &$return): bool {
        $requiredFields = [
            'title',
            'price',
            'status'
        ];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (empty($fields[$field])) {
                $return['errorsFields']['fields[' . $field . ']'] = "Trường $field không được để trống.";
                $valid = false;
            }
        }

        if ($valid && !FeeTypeStatus::getTitle($fields['status'])) {
            $return['message'] = $return['errors']['fields[status]'] = 'Trạng thái loại phí không hợp lệ!';
            $valid = false;
        }

        return $valid;
    }

    /**
     * Kiểm tra sự tồn tại của loại phí
     * @param array $fields Mảng chứa thông tin loại phí cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @param array $oldItem Mảng chứa thông tin loại phí cũ (nếu có)
     * @return bool Trả về true nếu loại phí chưa tồn tại, ngược lại trả về false
     */
    public static function checkExists(array $fields, array &$return, array $oldItem): bool {
        if (!empty($fields['title'])) {
            $filters = [
                'site' => portal()->id,
                'title' => $fields['title']
            ];
            if (!empty($oldItem)) {
                $filters['_id'] = ['$ne' => Data::objectId($oldItem['id'])];
            }
            if (Data(static::$type)->select($filters)) {
                $return['message'] = $return['errors']['fields[title]'] = 'Loại phí này đã tồn tại.';
                return false;
            }
        }
        return true;
    }

}
