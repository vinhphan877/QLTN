<pre>
    {print_r($params)}
</pre>
<CMS.Admin.list>
    <!--IF(!empty(items))-->
    <CMS.Admin.table>
        <region name="header">
            <th>Tên hộ gia đình</th>
            <th>Thời gian bắt đầu thuê</th>
            <th>Thời gian kết thúc thuê</th>
            <th>Căn hộ</th>
            <th>Chi tiết thành viên</th>
        </region>
        <td>{notag(items.title ?? '')}</td>
        <td>{notag(items.startTime ?? '')}</td>
        <td>{notag(items.endTime ?? '')}</td>
        <td>{notag(items.apartmentTitle ?? '')}</td>
        <td>
            <a class="action" href="javascript:void(0);"
               title="{'Chi tiết'}"
               data-modal-class="modal-fullscreen"
               data-x-modal="{quote(changeTail(layout, 'detail'))}"
               data-popup="1"
               data-filters-apartment-id="{items.apartmentId ?? ''}"
               data-x-popup="backdrop:'static',keyboard: false"
               data-service="Samples.Newbie.VinhPT2.Admin.Apartment.selectAll"
               data-parameters="apartmentId:{items.apartmentId}}"
               data-grid-module-parent-id="_MID_">
                <i class="vi vi-eye vi-1_2x"></i>
            </a>
        </td>
    </CMS.Admin.table>
    <!--ELSE-->
    <Common.noData></Common.noData>
    <!--/IF-->
</CMS.Admin.list>
