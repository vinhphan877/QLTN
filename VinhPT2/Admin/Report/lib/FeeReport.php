<?php
/**
 *
 * @author vinhpt
 * @date 7/4/2025
 * @time 4:37 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\Report\lib;

use Data;
use Data\lib\Listing;
use Samples\Newbie\VinhPT2\Enum\lib\FeeStatus;

class FeeReport extends Listing {
    public static string $type = 'Newbie.VinhptFee';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'fields' => '*',
        'orderBy' => 'createdTime DESC'
    ];

    protected function addFields(array &$items): void {
        Data::getMoreFields('Newbie.VinhptHousehold', $items, [
            'householdId' => ['title' => 'householdTitle'],
        ]);
        Data::getMoreFields('Newbie.VinhptFeeType', $items, [
            'feeTypeId' => ['title' => 'feeTypeTitle'],
        ]);
    }

    protected function prepareList(array &$return): void {
        parent::prepareList($return);
        if (!empty($return['items'])) {
            FeeStatus::addTitle($return['items'], 'status');
            $this->addFields($return['items']);
        }

    }

    public function getUnPaidFee(array $fields): array {
        $allFeeTypes = Data('Newbie.VinhptFeeType')->select([
            'site' => portal()->id,
            'fields' => [
                '_id' => Data::objectId($fields['feeTypeId']),
                'title' => $fields['title']
            ]
        ]);

        if (empty($allFeeTypes)) {
            return [];
        }

        $paidFees = Data('Newbie.VinhptFee')->select([
            'site' => portal()->id,
            'fields' => ['feeTypeId']
        ]);

        $paidFeeTypeIds = array_unique(array_column($paidFees, 'feeTypeId'));

        $unpaidFeeTypes = array_filter($allFeeTypes, function ($feeType) use ($paidFeeTypeIds) {
            return !in_array((string)$feeType['_id'], $paidFeeTypeIds);
        });
        return array_values($unpaidFeeTypes);
    }

}
