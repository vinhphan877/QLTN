<?php
/**
 *
 * @author vinhpt
 * @date 6/19/2025
 * @time 1:50 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

class HouseholdEdit {
    public static function checkRequired(array &$fields, array &$return): bool {
        $requiredFields = [
            'title',
            'name',
            'age',
            'gender',
            'startTime',
            'endTime',
            'apartmentId',
            'buildingId'
        ];
        $valid = true;

        foreach ($requiredFields as $field) {
            if (!isset($fields[$field])) {
                $return['errors'][$field] = "Trường '{$field}' không được để trống.";
                $valid = false;
            }
        }

        return $valid;
    }

    public static function checkExits(array $item, array &$return): bool {
        if (!empty($oldItem['id'])
            && Data('Newbie.VinhptFee')->select([
                'site' => portal()->id,
                'householdId' => $item['id'],
                'status' => 1, 2
            ])) {
            $return['message'] = 'Hộ gia đình vẫn còn nợ phí, không thể xóa';
            return false;
        }
        return true;
    }

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

}
