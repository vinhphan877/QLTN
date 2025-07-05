<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:55 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;
use MongoDB\BSON\ObjectId;
use Samples\Newbie\VinhPT2\Enum\lib\FeeStatus;

class FeeEdit {
    /**
     * Kiểm tra thời gian nộp tiền (submissionTime) không thể nhỏ hơn thời gian bắt đầu thuê nhà (startTime trong bảng Household)
     * @author vinhpt
     * @param array $fields
     * @param array $return
     * @return bool
     */
    public static function checkTime(array $fields, array &$return): bool {
        if (empty($fields['submissionTime']) || empty($fields['householdId'])) {
            return true;
        }

        $household = Data('Newbie.VinhptHousehold')->select([
            'site' => portal()->id,
            '_id' => Data::objectId($fields['householdId'])
        ]);

        if (!$household || empty($household['startTime'])) {
            $return['message'] = 'Không tìm thấy thông tin thời gian bắt đầu thuê nhà.';
            $return['errors']['fields[householdId]'] = 'Dữ liệu hộ dân không hợp lệ.';
            return false;
        }

        $submissionTime = CDateTime($fields['submissionTime'])->time;
        $rentStartTime = CDateTime($household['startTime'])->time;

        if ($submissionTime < $rentStartTime) {
            $return['message'] = 'Ngày nộp tiền không thể nhỏ hơn ngày bắt đầu thuê nhà.';
            $return['errors']['fields[submissionTime]'] = 'Ngày không hợp lệ.';
            return false;
        }

        return true;
    }

    /**
     * Kiểm tra các trường bắt buộc dựa trên yêu cầu.
     * @author vinhpt
     * @param array $fields
     * @param array $return
     * @return bool
     */
    public static function checkRequired(array $fields, array &$return): bool {
        $required = ['title', 'amount', 'submissionTime', 'householdId', 'feeTypeId'];
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
        if (isset($item['status']) && $item['status'] != FeeStatus::PAIDONTIME->value) {
            $return['message'] = 'Chỉ có thể xóa khoản phí đã ở trạng thái "Đã trả".';
            return false;
        }
        return true;
    }

    /**
     * Kiểm tra số tiền nộp phải > 0 và < soos tieenf quy định
     * @author vinhpt
     * @param array $fields
     * @param array $return
     * @return bool
     */
    public static function checkAmmount(array $fields, array &$return): bool {
        if (!empty($fields['amount']) && $fields['amount'] > 0 && !empty($fields['feeTypeId'])) {
            $feeType = Data('Newbie.VinhptDeeType')->select([
                'site' => portal()->id,
                'id' => $fields['feeTypeId']
            ]);

            if (!$feeType || !isset($feeType['price'])) {
                $return['message'] = 'Không tìm thấy thông tin loại phí hoặc giá không hợp lệ.';
                $return['errors']['fields[feeTypeId]'] = 'Loại phí không hợp lệ.';
                return false;
            }

            $price = $feeType['price'];

            if ($fields['amount'] >= $price) {
                $return['message'] = 'Số tiền nộp phải nhỏ hơn mức phí quy định.';
                $return['errors']['fields[amount]'] = 'Số tiền không được lớn hơn hoặc bằng giá quy định.';
                return false;
            }
        }
        return true;
    }

    /**
     * Đặt trạng thái khi tạo mới.
     * Nếu submissionTime trong khoảng ngày 1 đến ngaỳ 10 hằng tháng thì trạng thái sẽ là trả đúng hạn
     * Nếu submissionTime ngoài khoảng ngày 1 đến ngaỳ 10 hằng tháng thì trạng thái sẽ là trả không đúng hạn
     * @author vinhpt
     * @param array $fields
     * @param array $return
     * @return bool
     */

    public static function validateStatusOnCreate(array &$fields, array &$return): bool {
        $feeType = Data('Newbie.VinhptFeeType')->select($fields['feeTypeId']);

        if (!$feeType || !isset($feeType['price'])) {
            $return['message'] = 'Không tìm thấy loại phí hoặc thiếu giá.';
            $return['errors']['fields[feeTypeId]'] = 'Loại phí không hợp lệ.';
            return false;
        }

        $timestamp = CDateTime($fields['submissionTime'])->time;

        $day = (int)date('d', $timestamp);
        $fields['status'] = ($day >= 1 && $day <= 10)
            ? FeeStatus::PAIDONTIME->value
            : FeeStatus::EXPIRED->value;

        return true;
    }

}
