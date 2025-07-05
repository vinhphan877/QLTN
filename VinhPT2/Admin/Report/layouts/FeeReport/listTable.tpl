<pre>
    {print_r($params)}
</pre>
<CMS.Admin.table hideAddNew="1" hideReload="1" hideActions="1" hideCheckbox="1" hideHeader="1">
    <region name="header">
        <th>Tên hộ gia đình</th>
        <th>Tên loại phí</th>
        <th>Tên phí</th>
        <th>Số tiền</th>
    </region>
    <td>{!empty(items.householdTitle) ? items.householdTitle : ''}</td>
    <td>{!empty(items.feeTypeTitle) ? items.feeTypeTitle : ''}</td>
    <td>{notag(items.title ?? '')}</td>
    <td>{notag(items.amount ?? '')}</td>
</CMS.Admin.table>
