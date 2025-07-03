<CMS.Admin.table>
    <region name="header">
        <th>Tên hộ gia đình</th>
        <th>Tên loại phí</th>
        <th>Tên phí</th>
        <th>Số tiền</th>
        <th>Thời gian nộp</th>
        <th>Trạng thái</th>
    </region>
    <td>{!empty(items.householdTitle) ? items.householdTitle : ''}</td>
    <td>{!empty(items.feeTypeTitle) ? items.feeTypeTitle : ''}</td>
    <td>{notag(items.title ?? '')}</td>
    <td>{notag(items.amount ?? '')}</td>
    <td>{notag(CDateTime(items.submissionTime ?? '')->date())}</td>
    <td>{!empty(items.statusTitle) ? items.statusTitle : ''}</td>
</CMS.Admin.table>
