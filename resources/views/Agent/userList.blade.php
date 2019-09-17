<html>
<head>
    <title>用户列表</title>
</head>
<body>
    <table>
        <tr>
            <td>id</td>
            <td>name</td>
            <td>推广码</td>
            <td>码</td>
            <td>操作</td>
        </tr>
        @foreach($info as $v)
            <tr>
                <td>{{$info->id}}</td>
                <td>{{$info->name}}</td>
                <td>{{$info->id}}</td>
                <td><a href="">生成专属二维码</a></td>
            </tr>
            @endforeach
    </table>
</body>
</html>