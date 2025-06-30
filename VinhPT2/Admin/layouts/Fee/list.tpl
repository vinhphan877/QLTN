<CMS.Admin.list sortTime="1" modalClass="modal-md" typeTitle="{'Thông tin các khoản phí cần đóng'}">
    <region name="menuTab">
        <Samples.Newbie.VinhPT2.Admin.tab></Samples.Newbie.VinhPT2.Admin.tab>
    </region>
    <region name="filter">
        <div>
            <input type="Form.Text" name="filters[suggestTitle]" class="form-control"
                   placeholder="{'Tìm kiếm theo tên loại phí'}"
                   value="{(filters['suggestTitle']??'')}"
            >
        </div>
    </region>
    <div class="layout-content">
        <CurrentLayout.listTable></CurrentLayout.listTable>
    </div>
</CMS.Admin.list>
