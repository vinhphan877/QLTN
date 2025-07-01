<pre>
    {print_r($params)}
</pre>
<CMS.Admin.list hideReload="1" hideAdd="1" hideSort="1">
    <!--IF(!empty(items))-->
    <CMS.Admin.table>
        <region name="header">
            <th>Căn hộ</th>
            <th>Tên hộ gia đình</th>
            <th>Thời gian bắt đầu thuê</th>
            <th>Thời gian kết thúc thuê</th>
            <th>Chi tiết thành viên</th>
        </region>
        <td>{notag(items.apartmentTitle ?? '')}</td>
        <td>{notag(items.title ?? '')}</td>
        <td>{notag(CDateTime(items.startTime ?? '')->date())}</td>
        <td>{notag(CDateTime(items.endTime ?? '')->date())}</td>
        <td>
            <a class="action" href="javascript:void(0);"
               title="{'Chi tiết'}"
               data-modal-class="modal-fullscreen"
               data-x-modal="{(changeTail(layout, 'detail'))}"
               data-popup="1"
               data-x-popup="backdrop:'static',keyboard: false"
               data-service="Samples.Newbie.VinhPT2.Admin.Household.select"
               data-item-id="{items.id ?? ''}"
               data-id="{items.id ?? ''}"
               data-grid-module-parent-id="_MID_">
                <i class="vi vi-eye vi-1_2x"></i>
            </a>
        </td>
    </CMS.Admin.table>
    <!--ELSE-->
    <Common.noData></Common.noData>
    <!--/IF-->
</CMS.Admin.list>
