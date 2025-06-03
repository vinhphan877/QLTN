<CMS.Admin.table>
    <region name="header">
        <th>Tên tòa nhà</th>
        <th>Tổng số tầng</th>
        <th>Loại tầng</th>
        <th>Tổng số phòng</th>
        <th>Thời gian bắt đầu hoạt động</th>
    </region>
    <td>{notag(items.title ?? '')}</td>
    <td>{notag(items.totalFloor ?? '')}</td>
    <td>{notag(items.floorKind ?? '')}</td>
    <td>{notag(items.totalRoom ?? '')}</td>
    <td>{!empty(items.since) ? date('d/m/Y', items.since) : ''}</td>
</CMS.Admin.table>
