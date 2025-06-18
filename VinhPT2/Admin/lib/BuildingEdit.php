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

    /**
     * Kiểm tra các trường bắt buộc trong form
     * @author vinhpt
     * @param array $fields Mảng chứa thông tin dữ liệu cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @return bool Trả về true nếu tất cả trường bắt buộc hợp lệ, ngược lại trả về false
     */
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
            if (!isset($fields[$field]) || $fields[$field] === '') {
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

    /**
     * Kiểm tra tính hợp lệ của số tầng tòa nhà
     * @author vinhpt
     * @param array $fields Mảng chứa thông tin dữ liệu, bao gồm số tầng
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @return bool Trả về true nếu số tầng hợp lệ, ngược lại trả về false
     */
    public static function validateBuilding(array $fields, array &$return): bool {
        if (!empty($fields['totalFloor'])
            && ($fields['totalFloor'] < 10 || $fields['totalFloor'] > 80)) {
            $return['errors']['totalFloor'] = 'Số tầng phải nằm trong khoảng từ 10 đến 80';
            return false;
        }
        return true;
    }

    /**
     * Kiểm tra sự tồn tại của tòa nhà trong hệ thống
     * @author vinhpt
     * @param array $fields Mảng chứa thông tin tòa nhà cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @param array $oldItem Mảng chứa thông tin tòa nhà cũ (nếu có)
     * @return bool Trả về true nếu tòa nhà chưa tồn tại, ngược lại trả về false
     */
    public static function checkExistsBuilding(array $fields, array &$return, array $oldItem): bool {
        if (!empty($fields['title'])) {
            $filters = [
                'site' => portal()->id,
                'title' => $fields['title'],
                'address' => $fields['address']
            ];
            if (!empty($oldItem)) {
                $filters['_id'] = ['$ne' => Data::objectId($oldItem['id'])];
            }
            if (Data(static::$type)->select($filters)) {
                $return['message'] = $return['errors']['fields[title]'] = 'Tòa nhà này đã tồn tại tại địa chỉ này';
                return false;
            }
        }
        return true;
    }

}
