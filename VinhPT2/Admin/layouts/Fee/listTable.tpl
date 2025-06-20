<pre>
    {print_r($params)}
</pre>
<CMS.Admin.table>
    <region name="header">
        <th>Tên hộ gia đình</th>
        <th>Tên loại phí</th>
        <th>Số tiền</th>
        <th>Trạng thái</th>
        <th>Thời gian nộp</th>
        <th>Hạn nộp</th>
    </region>
    <td>{!empty(items.buildingTitle) ? items.buildingTitle : ''}</td>
    <td>{!empty(items.feeTypeTitle) ? items.feeTypeTitle : ''}</td>
    <td>{notag(items.amount ?? '')}</td>
    <td>{notag(items.statusTitle ?? '')}</td>
    <td>{notag(items.submissionTime ?? '')}</td>
    <td>{notag(items.deadline ?? '')}</td>
</CMS.Admin.table>
