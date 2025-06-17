<CMS.Admin.list sortTime="1" modalClass="modal-md" typeTitle="{'Quản lý tòa nhà'}">
    <region name="filter">
        <div>
            <input type="Form.Text" name="filters[suggestTitle]" class="form-control"
                   placeholder="{'Tìm kiếm theo tên tòa'}"
                   value="{(filters['suggestTitle']??'')}"
            >
        </div>
    </region>
    <div class="layout-content">
        <CurrentLayout.listTable></CurrentLayout.listTable>
    </div>
</CMS.Admin.list>
