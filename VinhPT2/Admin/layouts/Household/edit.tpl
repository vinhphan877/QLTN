<CMS.edit hideHeader="1" notUsing="1">
    <Layout.label label="Căn hộ" required="1">
        <input class="form-control" type="Form.Select"
               name="fields[apartmentId]" service="Samples.Newbie.VinhPT2.Admin.Apartment.selectList"
               filters[status]="0"
               value="{quote(!empty(apartmentId) ? apartmentId : '')}"
               description="-- {'Chọn %s', 'căn hộ'} --">
    </Layout.label>
    <Layout.label label="Tên hộ gia đình" required="1">
        <input name="fields[title]" type="Form.Text" value="{title ?? ''}"
               placeholder="{'Tên hộ gia đình'}" class="form-control">
    </Layout.label>
    <Layout.multiple name='members' hasIcon="1">
        <Layout.label label="Thành viên trong hộ gia đình"></Layout.label>
        <table class="table table-condensed table-choices" style="margin-bottom: 0;">
            <tbody>
            <tr>
                <td>
                    <input name="fields[members][#INDEX][name]" class="form-control" placeholder="{'Họ tên'}"
                           type="Form.Text">
                </td>
                <td>
                    <input name="fields[members][#INDEX][age]" class="form-control" placeholder="{'Tuổi'}"
                           type="Form.Text">
                </td>
                <td>
                    <input name="fields[members][#INDEX][gender]" class="form-control" placeholder="{'Giới tính'}"
                           type="Form.Select" value="{quote(gender ?? '')}"
                           items="{\Core\Enum\lib\Gender::selectList()}">
                </td>
                <td style="width:30px;vertical-align:middle;">
                    <a class="btn btn-delete-accordion" href="javascript:void(0);" rel="Delete" title="{'Xóa'}">
                        <i class="vi vi-trash"></i>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </Layout.multiple>
    <Layout.label label="Thời gian bắt đầu" required=1>
        <input name="fields[startTime]" type="Form.DatePicker" value="{quote(startTime??'')}"
               class="form-control">
    </Layout.label>
    <Layout.label label="Thời gian kết thúc" required=1>
        <input name="fields[endTime]" type="Form.DatePicker" value="{quote(endTime??'')}"
               class="form-control">
    </Layout.label>
</CMS.edit>
<script type="text/javascript">
    VHV.using({
        rules: {
            'fields[apartmentId]': {
                required: true
            },
            'fields[title]': {
                required: true,
                maxlength: 255
            },
            'fields[members][*][name]': {
                required: true,
                maxlength: 255
            },
            'fields[members][*][age]': {
                required: true,
                number: true,
                min: 1,
                max: 100
            },
            'fields[members][*][gender]': {
                required: true
            },
            'fields[startTime]': {
                required: true,
                dateVN: true
            },
            'fields[endTime]': {
                required: true,
                dateVN: {
                    gt: 'fields[startTime]'
                }
            }
        },
        members: php(`!empty(members) ? members : []`)
    });
</script>
