<CMS.edit hideHeader="1" notUsing="1">
    <Layout.label label="Tên căn hộ" required="1">
        <input name="fields[title]" type="Form.Text" value="{title ?? ''}"
               placeholder="{'Tên căn hộ'}" class="form-control">
    </Layout.label>
    <Layout.label label="Số tầng" required=1>
        <input name="fields[floorNumber]" type="Form.Text" value="{floorNumber ?? ''}"
               data-totalfloor="{totalFloor ?? ''}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Trạng thái" required=1>
        <input class="form-control" type="Form.Select" name="fields[status]"
               value="{status ?? ''}"
               items="{\Samples\Newbie\VinhPT2\Enum\lib\ApartmentStatus::selectList()}"
               description="-- {'Chọn trạng thái'} --">
    </Layout.label>
    <Layout.label label="Tòa nhà" required="1">
        <input class="form-control" type="Form.Select"
               name="fields[buildingId]" service="Samples.Newbie.VinhPT2.Admin.Building.selectList"
               options[orderBy]="sortOrder ASC"
               value="{quote(!empty(buildingId) ? buildingId : '')}"
               description="-- {'Chọn %s', 'tòa nhà'} --">
    </Layout.label>
</CMS.edit>
<script type="text/javascript">
    VHV.using({
        rules: {
            'fields[title]': {
                required: true,
                maxlength: 255
            },
            'fields[floorNumber]': {
                required: true
            },
            'fields[status]': {
                required: true
            },
            'fields[buildingId]':{
                required: true
            }
        }
    });
</script>
