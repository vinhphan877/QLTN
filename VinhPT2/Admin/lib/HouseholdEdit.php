<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:50 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;
use Samples\Newbie\VinhPT2\Enum\lib\ApartmentStatus;

class HouseholdEdit {
    public static string $type = 'Newbie.VinhptHousehold';

    /**
     * Kiểm tra các trường bắt buộc trong form hộ gia đình
     * @param array $fields Mảng chứa thông tin dữ liệu cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @return bool Trả về true nếu tất cả trường bắt buộc hợp lệ, ngược lại trả về false
     */
    public static function checkRequired(array $fields, array &$return): bool {
        $requiredFields = ['title', 'startTime', 'apartmentId'];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (empty($fields[$field])) {
                $return['errorsFields']['fields[' . $field . ']'] = "Trường $field không được để trống.";
                $valid = false;
            }
        }

        if (!empty($fields['members'])) {
            foreach ($fields['members'] as $index => $member) {
                if (empty($member['name']) || !isset($member['age']) || !isset($member['gender'])) {
                    $return['message'] = "Vui lòng điền đầy đủ thông tin cho tất cả thành viên. Lỗi ở thành viên số "
                        . ($index + 1)
                        . ".";
                    $valid = false;
                    break;
                }
            }
        }

        return $valid;
    }

    /**
     * Kiểm tra tình trạng sẵn có của căn hộ.
     * Căn hộ phải trống (status = 0) trừ khi đó là căn hộ đã được gán cho chính hộ gia đình này.
     * @param array $fields Mảng chứa thông tin dữ liệu cần kiểm tra (bao gồm apartmentId)
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @param array $oldItem Dữ liệu cũ của hộ gia đình trước khi chỉnh sửa
     * @return bool Trả về true nếu căn hộ hợp lệ, ngược lại trả về false
     */
    public static function checkValidApartment(array $fields, array &$return, array $oldItem): bool {
        if (empty($fields['apartmentId'])) {
            return true;
        }

        if (!empty($oldItem['apartmentId']) && $fields['apartmentId'] === $oldItem['apartmentId']) {
            return true;
        }

        $apartment = Data('Newbie.VinhptApartment')->select([
            '_id' => $fields['apartmentId']
        ]);

        if (empty($apartment)) {
            $return['message'] = 'Căn hộ được chọn không tồn tại.';
            return false;
        }

        if ($apartment['status'] == 1) {
            $return['message'] = 'Căn hộ đã có người thuê.';
            return false;
        }

        return true;
    }

    public static function checkTime(array $fields, array $oldItem, array &$return): bool {
        if (!empty($fields['startTime']) && !empty($fields['endTime'])) {
            $startTime = CDateTime($fields['startTime'])->time;
            $endTime = CDateTime($fields['endTime'])->time;
            $filters = [
                'site' => portal()->id,
                'apartmentId' => $fields['apartmentId'],
                '$or' => [
                    [
                        'startTime' => ['$gte' => $startTime],
                        'endTime' => ['$lte' => $endTime],
                    ],
                    [
                        'startTime' => ['$lte' => $endTime],
                        'endTime' => ['$gte' => $startTime, '$lte' => $endTime],
                    ],
                    [
                        'startTime' => ['$gte' => $startTime, '$lte' => $endTime],
                        'endTime' => ['$gte' => $endTime],
                    ],
                ]
            ];
            if (!empty($oldItem)) {
                $filters['_id'] = ['$ne' => Data::objectId($oldItem['id'])];
            }
            if (Data(static::$type)->select($filters)) {
                $return['message'] = $return['errors']['fields[startTime]']
                    = 'Căn hộ hiện tại đã có người thuê trong khoảng thời gian này';
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
