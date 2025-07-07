<pre>
    {print_r($params)}
</pre>
<CMS.Admin.table hideAddNew="1" hideReload="1" hideActions="1" hideCheckbox="1" hideHeader="1">
    <region name="header">
        <th>Giới tính</th>
        <th>Số lượng</th>
    </region>
    <!--FOREACH(items.counts)-->
    <tr>
        <td>{key}</td>
        <td>{value}</td>
    </tr>
    <!--/FOREACH-->
</CMS.Admin.table>
