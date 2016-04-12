<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <title>百度音乐-MIS平台</title>
        <link rel="shortcut icon" href="/base/static/images/favicon.ico">
        <script src="/base/static/js/jquery.min.js"></script>
        <script src="/base/static/js/bootstrap.min.js"></script>
        <script src="/base/static/js/jquery.metisMenu.js"></script>
        <script src="/base/static/js/sb-admin.js"></script>
        <link rel="stylesheet" href="/base/static/css/bootstrap.min.css">
        <link rel="stylesheet" href="/base/static/css/font-awesome.css">
        <link rel="stylesheet" href="/base/static/css/sb-admin.css">
        <link rel="stylesheet" href="/base/static/css/base.css?v=3">
        <script src="/base/static/js/base.js"></script>
    </head>

    <body>
        <div id="wrapper">
            <div class="container">
                <div class="jumbotron">
                    <h1>Hello</h1>
                    <p>欢迎使用mis平台, 您想去哪儿? 请访问下面的地址</p>
                </div>
                <ul class="list-group app-list">
                <(foreach $app_list as $app)>
                    <li class="list-group-item col-md-4"><a href="/<($app)>" target="_self"><(ucfirst($app))></a></li>
                <(/foreach)>
                </ul>
            </div>
        </div>
    </body>
</html>
