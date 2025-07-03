<CMS.Admin.table>
    <region name="header">
        <th>Tên loại phí</th>
        <th>Giá tiền</th>
        <th>Hạn Nộp</th>
    </region>
    <td>{!empty(items.title) ? items.title : ''}</td>
    <td>{!empty(items.price) ? items.price : ''}</td>
    <td>Mặc định sẽ từ 1-10 hằng tháng</td>
</CMS.Admin.table>
