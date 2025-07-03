<CMS.detail hideAddNew="1" hideReload="1" hideActions="1" hideCheckbox="1" hideHeader="1">
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
                <!--IF(!empty(members))-->
                <!--LIST(members)-->
                <tr>
                    <td>{members._index}</td>
                    <td>{notag(members.name ?? '')}</td>
                    <td>{number(members.age ?? '')}</td>
                    <td>{notag(members.genderTitle ?? '')}</td>
                </tr>
                <!--/LIST-->
                <!--ELSE-->
                <tr>
                    <td colspan="4" class="text-center">Không có dữ liệu</td>
                </tr>
                <!--/IF-->
                </tbody>
            </table>
        </div>
    </div>
</CMS.detail>
