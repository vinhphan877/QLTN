<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:55 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Samples\Newbie\VinhPT2\Enum\lib\FeeStatus;

class FeeEdit {
    /**
     * Kiểm tra các trường bắt buộc dựa trên yêu cầu.
     * @author vinhpt
     * @param array $fields
     * @param array $return
     * @return bool
     */
    public static function checkRequired(array $fields, array &$return): bool {
        $required = ['title', 'amount', 'submissionTime', 'status', 'householdId', 'feeTypesId'];
        foreach ($required as $field) {
            if (!isset($fields[$field]) || $fields[$field] === '') {
                $return['message'] = "Trường '$field' là bắt buộc.";
                $return['errors']['fields[' . $field . ']'] = "Trường này không được để trống.";
                return false;
            }
        }

        if (!is_numeric($fields['amount']) || $fields['amount'] < 0) {
            $return['message'] = "Số tiền phải là một số không âm.";
            $return['errors']['fields[amount]'] = "Số tiền không hợp lệ.";
            return false;
        }

        if (FeeStatus::getTitle($fields['status']) === '') {
            $return['message'] = 'Giá trị trạng thái không hợp lệ.';
            $return['errors']['fields[status]'] = 'Trạng thái không hợp lệ.';
            return false;
        }

        return true;
    }

    /**
     * Kiểm tra trạng thái fee trước khi xóa (chỉ cho phép xóa khi đã trả).
     * @author vinhpt
     * @param array $item
     * @param array $return
     * @return bool
     */
    public static function validateStatusOnDelete(array $item, array &$return): bool {
        if (isset($item['status']) && $item['status'] != FeeStatus::AVAIABLE->value) {
            $return['message'] = 'Chỉ có thể xóa khoản phí đã ở trạng thái "Đã trả".';
            return false;
        }
        return true;
    }

    /**
     * Kiểm tra thời gian nộp phí phải nằm trong thời gian thuê của hộ gia đình.
     * @author vinhpt
     * @param array $fields
     * @param array $household
     * @param array $return
     * @return bool
     */
    public static function checkTime(array $fields, array $household, array &$return): bool {
        if (empty($household)) {
            $return['message'] = 'Hộ gia đình không tồn tại.';
            return false;
        }
        if ($fields['submissionTime'] < $household['startTime'] || $fields['submissionTime'] > $household['endTime']) {
            $return['message'] = 'Thời gian nộp phí phải nằm trong thời gian thuê của hộ gia đình.';
            $return['errors']['fields[submissionTime]'] = 'Thời gian nộp không hợp lệ.';
            return false;
        }
        return true;
    }

}
