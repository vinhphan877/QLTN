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

    public static function checkValidApartment(array $fields, array &$return, array $oldItem): bool {
        if (empty($fields['startTime']) || empty($fields['endTime']) || empty($fields['apartmentId'])) {
            return true;
        }

        $startTime = CDateTime($fields['startTime'])->time;
        $endTime = CDateTime($fields['endTime'])->time;

        if ($endTime <= $startTime) {
            $return['message'] =
            $return['errors']['fields[endTime]'] = 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu.';
            return false;
        }

        $filters = [
            'site' => portal()->id,
            'apartmentId' => $fields['apartmentId'],
            'startTime' => ['$lt' => $endTime],
            'endTime' => ['$gt' => $startTime],
        ];

        if (!empty($oldItem['id'])) {
            $filters['_id'] = ['$ne' => Data::objectId($oldItem['id'])];
        }

        if (Data(static::$type)->select($filters)) {
            $return['message'] =
            $return['errors']['fields[startTime]'] = 'Khoảng thời gian này đã có hộ gia đình khác thuê phòng này.';
            return false;
        }
        return true;
    }

    public static function checkTime(array $fields, array &$return): bool {
        if (!empty($fields['startTime']) && !empty($fields['endTime'])) {
            $startTime = CDateTime($fields['startTime'])->time;
            $endTime = CDateTime($fields['endTime'])->time;

            if ($endTime <= $startTime) {
                $return['message'] =
                $return['errors']['fields[endTime]'] = 'Thời gian kết thúc phải sau thời gian bắt đầu';
                return false;
            }
        }
        return true;
    }

    public static function checkRequired(array $fields, array &$return): bool {
        $requiredFields = ['title', 'startTime', 'endTime', 'apartmentId'];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (empty($fields[$field])) {
                $return['errors']['fields[' . $field . ']'] = "Trường $field không được để trống.";
                $valid = false;
            }
        }
        return $valid;
    }

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
