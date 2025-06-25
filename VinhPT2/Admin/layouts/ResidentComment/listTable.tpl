<CMS.Admin.list hideAddNew="1" hideReload="1" hideActions="1" hideCheckbox="1">
    <!--IF(!empty(items))-->
    <CMS.Admin.table>
        <region name="header">
            <th>Tên hộ gia đình</th>
            <th>Tiêu đề</th>
            <th>Nội dung</th>
            <th>Trạng thái</th>
        </region>
        <td>{notag(items.title ?? '')}</td>
        <td>{notag(items.titleComment ?? '')}</td>
        <td>{notag(items.content ?? '')}</td>
        <td>{notag(items.status ?? '')}</td>
    </CMS.Admin.table>
    <!--ELSE-->
    <Common.noData></Common.noData>
    <!--/IF-->
</CMS.Admin.list>
