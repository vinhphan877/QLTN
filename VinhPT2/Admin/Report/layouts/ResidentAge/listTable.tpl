<pre>
    {print_r($params);}
</pre>
<CMS.Admin.Table hideAddNew="1" hideReload="1" hideActions="1" hideCheckbox="1" hideHeader="1">
    <region name="header">
        <th>STT</th>
        <th>Họ và tên</th>
        <th>Tuổi</th>
        <th>Giới tính</th>
    </region>
    <td>{members._index}</td>
    <td>{notag(members.name ?? '')}</td>
    <td>{number(members.age ?? '')}</td>
    <td>{notag(members.genderTitle ?? '')}</td>
</CMS.Admin.Table>
