<CMS.edit hideHeader="1" notUsing="1">
    <Layout.label label="Tên tòa nhà" required="1">
        <input name="fields[title]" type="Form.Text" value="{title ?? ''}"
               placeholder="{'Tên tòa nhà'}" class="form-control">
    </Layout.label>
    <Layout.label label="Tổng số tầng" required=1>
        <input name="fields[totalFloor]" type="Form.Text" value="{totalFloor ?? ''}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Loại tầng" required=1>
        <input name="fields[floorKind]" type="Form.Text" value="{floorKind ?? '')}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Tổng số phòng" required=1>
        <input name="fields[totalRoom]" type="Form.Text" value="{totalRoom ?? '')}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Thời gian bắt đầu đi vào hoạt động" required=1>
        <input name="fields[since]" type="Form.DateTimePicker" value="{since ?? '')}"
               class="form-control">
    </Layout.label>
</CMS.edit>
<script type="text/javascript">
    VHV.using({
        rules: {
            'fields[title]': {
                required: true,
                maxlength: 255
            },
            'fields[totalFloor]': {
                required: true
            },
            'fields[floorKind]': {
                required: true
            },
            'fields[totalRoom]': {
                required: true
            },
            'fields[since]': {
                required: true,
                dateVN: true
            }
        },
    });
</script>
