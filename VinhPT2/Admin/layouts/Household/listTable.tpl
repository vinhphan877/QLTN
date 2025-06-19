<CMS.Admin.table>
    <region name="header">
        <th>Tên hộ gia đình</th>
        <th>Thoời gian bắt đầu thuê</th>
        <th>Thoời gian kết thúc thuê</th>
        <th>Căn hộ</th>
        <th>Tòa nhà</th>
    </region>
    <td>{notag(items.title ?? '')}</td>
    <td>{notag(items.startTime ?? '')}</td>
    <td>{notag(items.endTime ?? '')}</td>
    <td>{notag(items.apartmentTitle ?? '')}</td>
    <td>{notag(items.buildingTitle)}</td>
</CMS.Admin.table>
