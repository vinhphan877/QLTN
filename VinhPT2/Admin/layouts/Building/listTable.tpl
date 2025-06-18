<CMS.Admin.table>
    <region name="header">
        <th>Tên tòa nhà</th>
        <th>Địa chỉ</th>
        <th>Tổng số tầng</th>
        <th>Tổng số phòng</th>
        <th>Trạng thái</th>
    </region>
    <td>{notag(items.title ?? '')}</td>
    <td>{notag(items.address ?? '')}</td>
    <td>{notag(items.totalFloor ?? '')}</td>
    <td>{notag(items.totalRoom ?? '')}</td>
    <td>{notag(items.statusTitle) ?? ''}</td>
</CMS.Admin.table>
