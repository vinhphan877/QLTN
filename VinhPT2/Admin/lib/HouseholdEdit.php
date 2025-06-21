<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:50 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

class HouseholdEdit {
    /**
     * Xác thực tất cả các trường bắt buộc đã được điền
     *
     * @param array &$fields Mảng chứa dữ liệu cần xác thực
     * @param array &$return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về true nếu tất cả trường bắt buộc đã được điền, ngược lại trả về false
     */
    public static function checkRequired(array &$fields, array &$return): array {
        $requiredFields = [
            'apartmentId',
            'title',
            'name',
            'age',
            'gender',
            'startTime',
            'endTime'
        ];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (!isset($fields[$field]) || empty($fields[$field])) {
                $errors[$field] = "Trường '{$field}' không được để trống.";
            }
        }

        return $errors;
    }

    /**
     * Kiểm tra xem hộ gia đình có khoản phí chưa thanh toán trước khi xóa
     *
     * @param array $item Mảng chứa thông tin hộ gia đình cần kiểm tra
     * @param array &$return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về true nếu có thể xóa hộ gia đình, ngược lại trả về false
     */
    public static function checkExists(array $item, array &$return): bool {
        if (!empty($item['id'])
            && Data('Newbie.VinhptFee')->select([
                'site' => portal()->id,
                'householdId' => $item['id'],
                'status' => [1, 2]
            ])) {

    /**
     * Xác thực căn hộ được chọn còn trống hay không
     *
     * @param array $fields Mảng chứa dữ liệu đầu vào với ID căn hộ
     * @param array &$return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về true nếu căn hộ hợp lệ và còn trống, ngược lại trả về false
     */
    public static function checkValidApartment(array $fields, array &$return): bool {
        if (!empty($fields['apartmentId'])) {
            $apartment = Data('Newbie.VinhptApartment')->select([
                'site' => portal()->id,
                'id' => $fields['apartmentId']
            ]);

            if ($apartment['status'] == 1) {
                $return['message'] = 'Căn hộ này đã có người ở, vui lòng chọn căn hộ khác';
                return false;
            }

            if (Data('Newbie.VinhptHousehold')->select([
                'site' => portal()->id,
                'apartmentId' => $fields['apartmentId']
            ])) {
                $return['message'] = 'Căn hộ đã có người ở';
                return false;
            }
        }
        return true;
    }

    /**
     * Kiểm tra thời gian bắt đầu phải nhỏ hơn thời gian kết thúc
     *
     * @param array $fields Mảng chứa thông tin thời gian cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về true nếu thời gian hợp lệ, ngược lại trả về false
     */
    public static function checkTime(array $fields, array &$return): bool {
        if (!empty($fields['startTime']) && !empty($fields['endTime'])) {
            $startTime = CDateTime($fields['startTime'])->time;
            $endTime = CDateTime($fields['endTime'])->time;

            if ($endTime <= $startTime) {
                $return['message'] = $return['errors']['fields[startTime]']
                    = 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu';
                return false;
            }
        }
        return true;
    }

}
