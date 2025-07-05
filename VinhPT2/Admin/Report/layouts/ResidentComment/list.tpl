<CMS.Admin.list sortTime="1" modalClass="modal-md" typeTitle="{'Thống kê thông tin góp ý theo trạng thái '}">
    <div>
        <input class="form-control" type="Form.Select" name="filters[status]"
               placeholder="{'Trạng thái'}"
               value="{filters['status'] ?? ''}" items="{\Samples\Newbie\VinhPT2\Enum\lib\FeedBackStatus::selectList()}"
        >
    </div>
    <div class="layout-content">
        <CurrentLayout.listTable></CurrentLayout.listTable>
    </div>
</CMS.Admin.list>
