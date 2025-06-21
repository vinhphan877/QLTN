<CMS.Admin.table>
    <region name="header">
        <th>Tên hộ gia đình</th>
        <th>Tên loại phí</th>
        <th>Tên phí</th>
        <th>Số tiền</th>
        <th>Thời gian nộp</th>
    </region>
    <td>{!empty(items.buildingTitle) ? items.buildingTitle : ''}</td>
    <td>{!empty(items.feeTypeTitle) ? items.feeTypeTitle : ''}</td>
    <td>{notag(items.title ?? '')}</td>
    <td>{notag(items.amount ?? '')}</td>
    <td>{notag(items.submissionTime ?? '')}</td>
</CMS.Admin.table>
