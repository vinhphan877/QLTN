<CMS.edit hideHeader="1" notUsing="1">
    <Layout.label label="Tên loại phí" required="1">
        <input name="fields[title]" type="Form.Text" value="{title ?? ''}"
               placeholder="{'Tên loại phí'}" class="form-control">
    </Layout.label>
    <Layout.label label="Giá tiền" required=1>
        <input name="fields[price]" type="Form.Number" value="{price ?? ''}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Lưu ý: Hạn nộp mặc định sẽ từ ngày 1-10 hằng tháng" required="1"></Layout.label>
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
            }
        }
    });
</script>
