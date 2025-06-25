<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:55 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;
use Samples\Newbie\VinhPT2\Enum\lib\FeedBackStatus;

class ResidentCommentEdit {

    public static string $type = 'Newbie.VinhptResidentComment';

    /**
     * Kiểm tra các trường bắt buộc trong form
     * @param array $fields Mảng chứa thông tin dữ liệu cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @return bool Trả về true nếu tất cả trường bắt buộc hợp lệ, ngược lại trả về false
     */
    public static function checkRequired(array $fields, array &$return): bool {
        $requiredFields = [
            'title',
            'status',
            'householdId'
        ];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (empty($fields[$field])) {
                $return['errorsFields']['fields[' . $field . ']'] = "Trường $field không được để trống.";
                $valid = false;
            }
        }

        if ($valid && !FeedBackStatus::getTitle($fields['status'])) {
            $return['message'] = $return['errors']['fields[status]'] = 'Trạng thái góp ý không hợp lệ!';
            $valid = false;
        }

        return $valid;
    }

    /**
     * Kiểm tra sự tồn tại của góp ý của cùng một hộ gia đình
     * @param array $fields Mảng chứa thông tin góp ý cần kiểm tra
     * @param array $return Mảng tham chiếu để lưu thông báo lỗi, nếu có
     * @param array $oldItem Mảng chứa thông tin góp ý cũ (nếu có)
     * @return bool Trả về true nếu góp ý chưa tồn tại, ngược lại trả về false
     */
    public static function checkExists(array $fields, array &$return, array $oldItem): bool {
        if (!empty($fields['title']) && !empty($fields['householdId'])) {
            $filters = [
                'site' => portal()->id,
                'title' => $fields['title'],
                'householdId' => $fields['householdId']
            ];
            if (!empty($oldItem)) {
                $filters['_id'] = ['$ne' => Data::objectId($oldItem['id'])];
            }
            if (Data(static::$type)->select($filters)) {
                $return['message'] = $return['errors']['fields[title]'] = 'Góp ý này đã tồn tại cho hộ gia đình này.';
                return false;
            }
        }
        return true;
    }

    /**
     * Thêm trường dữ liệu hộ gia đình vào danh sách góp ý
     * @param array $items Mảng tham chiếu chứa danh sách các góp ý
     */
    public static function addFields(array &$items): void {
        Data::getMoreFields('Newbie.VinhptHousehold', $items, [
            'householdId' => ['title' => 'householdName']
        ]);
    }
}
