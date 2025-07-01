<?php
/**
 *
 * @author vinhpt
 * @date 6/13/2025
 * @time 3:48 PM
 */

namespace Samples\Newbie\VinhPT2\Admin\lib;

use Data;
use Data\lib\CRUD;
use Samples\Newbie\VinhPT2\Enum\lib\FeeStatus;

class Fee extends CRUD {
    public static string $type = 'Newbie.VinhptFee';
    public static string $searchKeyword = 'suggestTitle';
    public static array $options = [
        'itemsPerPage' => 20,
        'pageNo' => 1,
        'orderBy' => 'createdTime DESC'
    ];

    protected function prepareEdit(array &$fields, array &$oldItem, array &$return): bool {
        if (!FeeEdit::checkRequired($fields, $return)) {
            return false;
        }

        $household = Data('Newbie.VinhptHousehold')->select(['_id' => Data::objectId($fields['householdId'])]);

        return FeeEdit::checkTime($fields, $household, $return)
            && parent::prepareEdit($fields, $oldItem, $return);
    }

    protected function checkDelete(array &$item, array &$return): bool {
        return FeeEdit::validateStatusOnDelete($item, $return)
            && parent::checkDelete($item, $return);
    }

    protected function addFields(array &$items): void {
        Data::getMoreFields('Newbie.VinhptHousehold', $items, [
            'householdId' => ['title' => 'householdTitle'],
        ]);
        Data::getMoreFields('Newbie.VinhptFeeTypes', $items, [
            'feeTypesId' => ['title' => 'feeTypeTitle'],
        ]);
    }

    protected function prepareList(array &$return): void {
        parent::prepareList($return);
        if (!empty($return['items'])) {
            FeeStatus::addTitle($return['items'], 'status');
            $this->addFields($return['items']);
        }
    }

    #[\Service]
    public static function getTotalUnpaidFee(): array {
        $fees = Data('Newbie.VinhptFee')->select([
            'filter' => [
                'status' => FeeStatus::NOTAVAIABLE->value
            ],
            'fields' => ['_id', 'householdId', 'amount']
        ]);

        $report = [];
        $totalAmount = 0;

        foreach ($fees as $fee) {
            $householdId = $fee['householdId'] ?? '';
            $amount = (float)($fee['amount'] ?? 0);

            if (!$householdId || $amount <= 0) {
                continue;
            }

            if (!isset($report[$householdId])) {
                $report[$householdId] = [
                    'householdId' => $householdId,
                    'totalUnpaid' => 0,
                    'numUnpaidFees' => 0,
                ];
            }

            $report[$householdId]['totalUnpaid'] += $amount;
            $report[$householdId]['numUnpaidFees']++;
            $totalAmount += $amount;
        }

        $reportItems = array_values($report);
        Data::getMoreFields('Newbie.VinhptHousehold', $reportItems, [
            'householdId' => ['title' => 'householdTitle']
        ]);

        return [
            'byHousehold' => $reportItems,
            'totalUnpaidAll' => $totalAmount
        ];
    }

}
