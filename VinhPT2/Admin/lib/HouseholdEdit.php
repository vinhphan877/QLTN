<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:50 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;

class HouseholdEdit {
    public static string $type = 'Newbie.VinhptHousehold';

    /**
     * Kiểm tra các trường bắt buộc trong form hộ gia đình
     * @param array $fields Mảng chứa thông tin dữ liệu cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @return bool Trả về true nếu tất cả trường bắt buộc hợp lệ, ngược lại trả về false
     */
    public static function checkRequired(array $fields, array &$return): bool {
        $requiredFields = ['title', 'members', 'startTime', 'apartmentId'];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (empty($fields[$field])) {
                $return['errorsFields']['fields[' . $field . ']'] = "Trường $field không được để trống.";
                $valid = false;
            }
        }

        if (!empty($fields['members'])) {
            foreach ($fields['members'] as $member) {
                if (empty($member['name']) || !isset($member['age']) || !isset($member['gender'])) {
                    $return['message'] = 'Vui lòng điền đầy đủ thông tin thành viên';
                    $valid = false;
                }
            }
        }

        return $valid;
    }

    /**
     * Kiểm tra tình trạng sẵn có của căn hộ
     * @param array $fields Mảng chứa thông tin dữ liệu cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @return bool Trả về true nếu căn hộ còn trống, ngược lại trả về false
     */
    public static function checkValidApartment(array $fields, array &$return): bool {
        if (!empty($fields['apartmentId'])) {
            $apartment = Data('Newbie.VinhptApartment')->select([
                '_id' => Data::objectId($fields['apartmentId']),
                'status' => 1
            ]);

            if (!empty($apartment)) {
                $return['message'] = 'Căn hộ đã có người thuê';
                return false;
            }
        }
        return true;
    }

    /**
     * Kiểm tra ràng buộc thời gian
     * @param array $fields Mảng chứa thông tin dữ liệu cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @return bool Trả về true nếu thời gian hợp lệ, ngược lại trả về false
     */
    public static function checkTime(array $fields, array &$return): bool {
        if (!empty($fields['startTime']) && !empty($fields['endTime'])) {
            $startTime = CDateTime($fields['startTime'])->time;
            $endTime = CDateTime($fields['endTime'])->time;

            if ($endTime <= $startTime) {
                $return['message'] =
                $return['errors']['fields[endTime]'] = 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu';
                return false;
            }
        }
        return true;
    }

    /**
     * Kiểm tra sự tồn tại của hộ gia đình trong hệ thống
     * @param array $fields Mảng chứa thông tin hộ gia đình cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @param array $oldItem Mảng chứa thông tin hộ gia đình cũ (nếu có)
     * @return bool Trả về true nếu hộ gia đình chưa tồn tại, ngược lại trả về false
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
                $return['message'] = $return['errors']['fields[title]'] = 'Hộ gia đình này đã tồn tại';
                return false;
            }
        }
        return true;
    }

}
