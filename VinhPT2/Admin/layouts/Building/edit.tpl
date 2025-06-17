<CMS.edit hideHeader="1" notUsing="1">
    <Layout.label label="Tên tòa nhà" required="1">
        <input name="fields[title]" type="Form.Text" value="{title ?? ''}"
               placeholder="{'Tên tòa nhà'}" class="form-control">
    </Layout.label>
    <Layout.label label="Địa chỉ" required=1>
        <input name="fields[address]" type="Form.Text" value="{address ?? ''}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Tổng số tầng" required=1>
        <input name="fields[totalFloor]" type="Form.Text" value="{totalFloor ?? ''}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Tổng số phòng" required=1>
        <input name="fields[totalRoom]" type="Form.Text" value="{totalRoom ?? ''}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Trạng thái" required=1>
        <input class="form-control" type="Form.Select" name="fields[status]"
               value="{status ?? ''}"
               items="{\Core\lib\BasicStatus::selectList()}"
               description="-- {'Chọn trạng thái'} --">
    </Layout.label>
</CMS.edit>
<script type="text/javascript">
    VHV.using({
        rules: {
            'fields[title]': {
                required: true,
                maxlength: 255
            },
            'fields[address]': {
                required: true
            },
            'fields[totalFloor]': {
                required: true,
                digits: true,
                range: [10, 80]
            },
            'fields[totalRoom]': {
                required: true,
                digits: true,
                min: 1
            },
            'fields[status]': {
                required: true
            }
        },
        messages: {
            'fields[totalFloor]': {
                range: 'Số tầng phải nằm trong khoảng từ 10 đến 80'
            },
            'fields[totalRoom]': {
                min: 'Số phòng phải lớn hơn 0'
            }
        }
    });
</script>
