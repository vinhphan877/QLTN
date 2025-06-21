<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:55 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

class FeeEdit {
    /**
     * Kiểm tra trạng thái fee trước khi xóa
     *
     * @param array $item Mảng chứa thông tin fee cần kiểm tra
     * @param array &$return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về false nếu status là 1 hoặc 2, ngược lại trả về true
     */
    public static function validateStatus(array $item, array &$return): bool {
        if (isset($item['status']) && in_array($item['status'], [1, 2])) {
            $return['message'] = 'Không thể xóa khi trạng thái là 1 hoặc 2';
            return false;
        }
        return true;
    }

    /**
     * Kiểm tra các trường bắt buộc
     *
     * @param array $fields Mảng chứa các trường cần kiểm tra
     * @param array &$return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về false nếu thiếu trường bắt buộc, ngược lại trả về true
     */
    public static function checkRequired(array $fields, array &$return): bool {
        $required = ['title', 'amount', 'submissionTime', 'householdId', 'feeTypesId'];
        foreach ($required as $field) {
            if (empty($fields[$field])) {
                $return['message'] = "Trường $field là bắt buộc";
                return false;
            }
        }
        return true;
    }

    /**
     * Kiểm tra tính hợp lệ của thời gian nộp phí với thời gian thuê của hộ gia đình
     *
     * @param array $fields Mảng chứa thông tin thời gian nộp phí
     * @param array $household Mảng chứa thông tin thời gian thuê của hộ gia đình
     * @param array &$return Mảng tham chiếu để lưu thông báo lỗi
     * @return bool Trả về false nếu thời gian không hợp lệ, ngược lại trả về true
     */
    public static function checkTime(array $fields, array $household, array &$return): bool {
        if ($fields['submissionTime'] < $household['startTime']
            || $fields['submissionTime'] > $household['endTime']) {
            $return['message'] = 'Thời gian nộp phí phải nằm trong thời gian thuê của hộ gia đình';
            return false;
        }
        return true;
    }

}
