<CMS.edit hideHeader="1" notUsing="1">
    <Layout.label label="Chọn hộ gia đình" required="1">
        <input class="form-control" type="Form.Select"
               name="fields[householdId]" service="Samples.Newbie.VinhPT2.Admin.Household.selectList"
               options[orderBy]="sortOrder ASC"
               value="{quote(!empty(householdId) ? householdId : '')}"
               description="-- {'Chọn %s', 'hộ gia đình'} --">
    </Layout.label>
    <Layout.label label="Mã loại phí" required="1">
        <input class="form-control" type="Form.Select"
               name="fields[feeTypeId]" service="Samples.Newbie.VinhPT2.Admin.Fee.selectList"
               options[orderBy]="sortOrder ASC"
               value="{quote(!empty(feeTypeId) ? feeTypeId : '')}"
               description="-- {'Chọn %s', 'loại phí'} --">
    </Layout.label>
    <Layout.label label="Số tiền" required="1">
        <input name="fields[amount]" type="Form.Text" value="{amount ?? ''}"
               placeholder="{'Số tiền'}" class="form-control money">
    </Layout.label>
    <Layout.label label="Thời gian nộp" required=1>
        <input name="fields[submissionTime]" type="Form.DatePicker" value="{submissionTime ?? ''}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Trạng Thái" required=1>
        <input class="form-control" type="Form.Select" name="fields[status]"
               value="{status ?? ''}" items="{\Samples\Newbie\VinhPT2\Enum\lib\FeeStatus::selectList()}">
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
            'fields[amount]': {
                required: true,
                number: true,
                min: 1000
            },
            'fields[submissionTime]': {
                required: true
            },
            'fields[status]': {
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
