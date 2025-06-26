<CMS.edit hideHeader="1" notUsing="1">
    <Layout.label label="Chọn hộ gia đình" required="1">
        <input class="form-control" type="Form.Select"
               name="fields[householdId]" service="Samples.Newbie.VinhPT2.Admin.Household.selectList"
               options[orderBy]="sortOrder ASC"
               value="{quote(!empty(householdId) ? householdId : '')}"
               description="-- {'Chọn %s', 'hộ gia đình'} --">
    </Layout.label>
    <Layout.label label="Tiêu đề" required="1">
        <input name="fields[title]" type="Form.Text" value="{title ?? ''}"
               placeholder="{'Tiêu đề'}" class="form-control money">
    </Layout.label>
    <Layout.label label="Nội dung" required="1">
        <input name="fields[content]" type="Form.Text" value="{content ?? ''}"
               placeholder="{'Nội dung'}" class="form-control money">
    </Layout.label>
</CMS.edit>
<script type="text/javascript">
    VHV.using({
        rules: {
            'fields[title]': {
                required: true
            },
            'fields[feeTypeId]': {
                required: true
            },
            'fields[content]': {
                required: true
            }
        },
    });
</script>
