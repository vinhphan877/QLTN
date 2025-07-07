<CMS.Admin.list sortTime="1" modalClass="modal-md" typeTitle="{'Thống kê thông tin cư dân theo giới tính'}">
    <div>
        <input class="form-control"
               type="Form.Select"
               name="filters[status]"
               placeholder="{'Trạng thái'}"
               value="{filters['status'] ?? ''}"
               items="{\Core\Enum\lib\Gender::selectList()}"
        >
    </div>
    <div class="layout-content">
        <CurrentLayout.listTable></CurrentLayout.listTable>
    </div>
</CMS.Admin.list>
