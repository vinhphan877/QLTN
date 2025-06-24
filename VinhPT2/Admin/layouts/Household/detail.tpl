<CMS.detail hideAddNew="1" hideReload="1" hideActions="1" hideCheckbox="1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Danh sách thành viên trong căn hộ</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Tuổi</th>
                    <th>Giới tính</th>
                </tr>
                </thead>
                <tbody>
                <!--IF(!empty(items))-->
                <!--LIST(items)-->
                <tr>
                    <td>{items._index + 1}</td>
                    <td>{notag(items.name ?? '')}</td>
                    <td>{number(items.age ?? '')}</td>
                    <td>{number(items.genderTitle ?? '')}</td>
                </tr>
                <!--/LIST-->
                <!--ELSE-->
                <tr>
                    <td colspan="8" class="text-center">Không có dữ liệu</td>
                </tr>
                <!--/IF-->
                </tbody>
            </table>
        </div>
    </div>
</CMS.detail>
