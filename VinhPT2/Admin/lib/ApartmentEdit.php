<?php
/**
 *
 * @author vinhpt
 * @date 6/18/2025
 * @time 9:47 AM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Core\Enum\lib\Gender;
use Data;
use Samples\Newbie\VinhPT2\Enum\lib\ApartmentStatus;

class ApartmentEdit {
    public static string $type = 'Newbie.VinhptApartment';

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
            'floorNumber'
        ];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (!isset($fields[$field])) {
                $return['errorsFields']['fields[' . $field . ']'] = "Trường $field không được để trống.";
                $valid = false;
            }
        }

        if ($valid && !ApartmentStatus::getTitle($fields['status'])) {
            $return['message'] = $return['errors']['fields[status]'] = 'Trạng thái căn hộ không hợp lệ!';
            $valid = false;
        }

        return $valid;
    }

    /**
     * Kiểm tra số tầng căn hộ so với tòa nhà
     * @author vinhpt
     * @param array $fields Thông tin căn hộ
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về true nếu hợp lệ, ngược lại trả về false
     */
    public static function checkFloor(array $fields, array &$return): bool {
        if (!empty($fields['floorNumber']) && !empty($fields['buildingId'])) {
            $building = Data('Newbie.VinhptBuilding')->select([
                'site' => portal()->id,
                '_id' => Data::objectId($fields['buildingId'])
            ]);

            if (!empty($building['totalFloor']) && $fields['floorNumber'] >= $building['totalFloor']) {
                $return['errors']['floorNumber'] = 'Số tầng căn hộ phải nhỏ hơn tổng số tầng của tòa nhà';
                return false;
            }
        }
        return true;
    }

    /**
     * Kiểm tra sự tồn tại của căn hộ trong hệ thống
     * @author vinhpt
     * @param array $fields Mảng chứa thông tin căn hộ cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @param array $oldItem Mảng chứa thông tin căn hộ cũ (nếu có)
     * @return bool Trả về true nếu căn hộ chưa tồn tại, ngược lại trả về false
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
                $return['message'] = $return['errors']['fields[title]'] = 'Căn hộ này đã tồn tại';
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
     * Kiểm tra trạng thái của tòa nhà được chọn và số lượng căn hộ
     * @author vinhpt
     * @param array $fields Mảng chứa thông tin căn hộ cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về true nếu tòa nhà hợp lệ và chưa đạt giới hạn căn hộ, ngược lại trả về false
     */
    public static function checkBuilding(array $fields, array &$return): bool {
        if (!empty($fields['buildingId'])) {
            $building = Data('Newbie.VinhptBuilding')->select([
                'site' => portal()->id,
                '_id' => Data::objectId($fields['buildingId'])
            ]);

            if (!empty($building) && $building['status'] == 0) {
                $return['message'] = 'Tòa nhà không còn hoạt động';
                return false;
            }

            $apartmentCount = Data(static::$type)->count([
                'site' => portal()->id,
                'buildingId' => $fields['buildingId']
            ]);

            if (!empty($building['totalRoom']) && $apartmentCount >= $building['totalRoom']) {
                $return['message'] = 'Số lượng căn hộ đã đạt giới hạn của tòa nhà';
                return false;
            }
        }
        return true;
    }

    /**
     * Kiểm tra số lượng căn hộ so với tổng số phòng của tòa nhà
     * @author vinhpt
     * @param array $fields Mảng chứa thông tin căn hộ cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về true nếu số lượng căn hộ hợp lệ, ngược lại trả về false
     */
    public static function checkRoom(array $fields, array &$return): bool {
        if (!empty($fields['buildingId'])) {
            $building = Data('Newbie.VinhptBuilding')->select([
                'site' => portal()->id,
                '_id' => Data::objectId($fields['buildingId'])
            ]);

            if (!empty($building['totalRoom'])) {
                $apartmentCount = Data(static::$type)->count([
                    'site' => portal()->id,
                    'buildingId' => $fields['buildingId']
                ]);

                if ($apartmentCount >= $building['totalRoom']) {
                    $return['message'] = 'Số lượng căn hộ đã vượt quá số phòng của tòa nhà';
                    return false;
                }
            }
        }
        return true;
    }

}
