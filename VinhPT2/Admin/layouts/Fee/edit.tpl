<CMS.edit hideHeader="1" notUsing="1">
    <Layout.label label="Chọn hộ gia đình" required="1">
        <input class="form-control" type="Form.Select"
               name="fields[householdId]" service="Samples.Newbie.VinhPT2.Admin.Household.selectList"
               options[orderBy]="sortOrder ASC"
               value="{quote(!empty(householdId) ? householdId : '')}"
               description="-- {'Chọn %s', 'hộ gia đình'} --">
    </Layout.label>
    <Layout.label label="Loại phí" required="1">
        <input class="form-control" type="Form.Select"
               name="fields[feeTypeId]" service="Samples.Newbie.VinhPT2.Admin.FeeType.selectList"
               options[orderBy]="sortOrder ASC"
               value="{quote(!empty(feeTypeId) ? feeTypeId : '')}"
               description="-- {'Chọn %s', 'loại phí'} --">
    </Layout.label>
    <Layout.label label="Tên phí" required="1">
        <input name="fields[title]" type="Form.Text" value="{title ?? ''}"
               placeholder="{'Tên phí'}" class="form-control money">
    </Layout.label>
    <Layout.label label="Số tiền nộp" required="1">
        <input name="fields[amount]" type="Form.Text" value="{amount ?? ''}"
               placeholder="{'Số tiền'}" class="form-control money">
    </Layout.label>
    <Layout.label label="Thời gian nộp" required=1>
        <input name="fields[submissionTime]" type="Form.DatePicker" value="{submissionTime ?? ''}"
               class="form-control">
    </Layout.label>
</CMS.edit>
<script type="text/javascript">
    VHV.using({
        rules: {
            'fields[householdId]': {
                required: true
            },
            'fields[feeTypeId]': {
                required: true
            },
            'fields[title]': {
                required: true
            },
            'fields[amount]': {
                required: true,
                number: true,
                min: 1000
            },
            'fields[submissionTime]': {
                required: true
            }
        },
        messages: {
            'fields[amount]': {
                min: 'Số tiền phải lớn hơn 1.000 VND'
            }
        }
    });
</script>
