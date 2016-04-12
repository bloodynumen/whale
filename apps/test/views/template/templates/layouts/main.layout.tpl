<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <(block name="head")>
        <meta charset="utf-8"/>
        <title>百度音乐-MIS平台 <(block name="title")><(/block)></title>
        <link rel="shortcut icon" href="/base/static/images/favicon.ico"/>
        <link rel="stylesheet" href="/base/static/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/base/static/css/font-awesome.css" />
        <link rel="stylesheet" href="/base/static/css/sb-admin.css" />
        <link rel="stylesheet" href="/base/static/css/base.css?v=8899" />
        <link rel="stylesheet" href="/base/static/css/jquery-ui-1.10.0.custom.css?v=2" />
        <link rel="stylesheet" href="/<($page.app_uri)>/static/css/base.css?v=1000" />
        <script src="/base/static/js/require.js"></script>
        <script src="/base/static/js/require.init.js?v=1"></script>
        <(/block)>
    </head>

    <body>
        <div id="wrapper">
            <(block name="nav")>
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/base">Music Mis 平台 v1.4</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>
                            <(if isset($page.user) )>
                            <($page.user.name)>
                            <(/if)>
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="/base/user/index/logout"><i class="fa fa-sign-out fa-fw"></i>退出</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default navbar-static-side" role="navigation">
                    <div class="sidebar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                            </li>

                            <(if isset($page.nav))>
                            <(foreach $page.nav as $group)>
                            <li>
                                <a class="mis-channel-group" href="#"><i class="fa fa-wrench fa-fw"></i> <($group.name)><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <(if isset($group.channel_list))>
                                    <(foreach $group.channel_list as $function)>
                                    <li>
                                        <a href="<($function.link)>" <(if isset($function.target))>target="<($function.target)>"<(/if)>><($function.name)></a>
                                    </li>
                                    <(/foreach)>
                                    <(/if)>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <(/foreach)>
                            <(/if)>

                        </ul>
                        <!-- /#side-menu -->
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
            <(/block)>

            <div id="page-wrapper">
                <(block name="content")>
                <(/block)>
            </div>

            <(block name="footer")>
            <div id="footer">
                <div class="container-fluid">
                    <p class="text-center">
                        <span class="label label-info">程序耗时:</span>
                        <strong class="sec"><($page.elapsed_time)>秒</strong>
                    </p>
                </div>
            </div>
            <(/block)>
        </div>
    </body>
</html>
