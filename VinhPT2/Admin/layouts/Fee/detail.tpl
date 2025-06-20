<CMS.edit hideHeader="1" notUsing="1">
    <Layout.label label="Tên loại phí" required="1">
        <input name="fields[title]" type="Form.Text" value="{title ?? ''}"
               placeholder="{'Tên loại phí'}" class="form-control">
    </Layout.label>
    <Layout.label label="Giá tiền" required=1>
        <input name="fields[price]" type="Form.Number" value="{price ?? ''}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Thời gian áp dụng" required=1>
        <input name="fields[rangeTime]" type="Form.DateRangePicker" value="{(rangeTime??'')}"
               class="form-control" description="Chọn khoảng thời gian">
    </Layout.label>
</CMS.edit>
<script type="text/javascript">
    VHV.using({
        rules: {
            'fields[title]': {
                required: true,
                maxlength: 255
            },
            'fields[price]': {
                required: true,
                number: true,
                min: 0
            },
            'fields[rangeTime]': {
                required: true,
                dateRangeVN: true
            }
        }
    });
</script>
