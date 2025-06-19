<pre>
    {print_r($params)}
</pre>
<CMS.Admin.table>
    <region name="header">
        <th>Tòa nhà</th>
        <th>Số tầng</th>
        <th>Tên căn hộ</th>
        <th>Trạng thái</th>
    </region>
    <td>{!empty(items.buildingTitle) ? items.buildingTitle : ''}</td>
    <td>{notag(items.floorNumber ?? '')}</td>
    <td>{notag(items.title ?? '')}</td>
    <td>{notag(items.statusTitle ?? '')}</td>
</CMS.Admin.table>
