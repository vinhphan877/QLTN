<pre>
    {print_r($params)}
</pre>
<CMS.Admin.table>
    <region name="header">
        <th>Tên loại phí</th>
        <th>Giá tiền</th>
        <th>Hạn nộp</th>
    </region>
    <td>{!empty(items.title) ? items.title : ''}</td>
    <td>{!empty(items.price) ? items.price : ''}</td>
    <td>{notag(items.deadline ? date('d/m/Y', items.deadline) : '')}</td>
</CMS.Admin.table>
