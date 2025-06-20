<CMS.Admin.list sortTime="1" modalClass="modal-md" typeTitle="{'Quản lý hộ gia đình'}">
    <region name="menuTab">
        <Samples.Newbie.VinhPT2.Admin.tab></Samples.Newbie.VinhPT2.Admin.tab>
    </region>
    <region name="filter">
        <div>
            <input type="Form.Text" name="filters[suggestTitle]" class="form-control"
                   placeholder="{'Tìm kiếm theo hộ gia đình'}"
                   value="{(filters['suggestTitle']??'')}"
            >
        </div>
    </region>
    <div class="layout-content">
        <CurrentLayout.listTable></CurrentLayout.listTable>
    </div>
</CMS.Admin.list>
