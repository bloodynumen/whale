<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <(include file=$page['tpl']['head'])>
        <script src="/base/static/js/page/user-group-operate.js?v=2"></script>
    </head>

    <body class="pd-top5">
        <div id="wrapper" class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><(ucfirst($smarty.get.app))>用户组管理
                        <(if $operate == 'add')>
                            添加
                        <(else)>
                            编辑
                        <(/if)>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="navbar-default top17" role="navigation">
                                <form role="form" action="/base/user/group/<($operate)>" method="post">
                                    <div class="sidebar-collapse">
                                        <div class="form-group user-group-form-group">
                                            <label>用户组名称</label>
                                            <input class="form-control" value="<(if (isset($user_group_info)))><($user_group_info.name)><(/if)>" name="name">
                                        </div>
                                        <ul class="nav">
                                            <(foreach $nav_list as $group)>
                                            <li>
                                            <a class="mis-nav-group" href="#"><i class="fa fa-wrench fa-fw"></i> <($group.name)>
                                            </a>
                                            <(if isset($group.channel_list))>
                                            <ul class="nav nav-second-level">
                                                <(foreach $group.channel_list as $channel)>
                                                <li>
                                                <a class="mis-nav-channel" href="javascript:void(0);">
                                                    <div class="checkbox top0 bottom0">
                                                        <label>
                                                            <input type="checkbox" name='channel_id_list[]' value="<($channel.channel_id)>" 
                                                            <(if (isset($user_group_info) && in_array($channel.channel_id, $user_group_info.channel_id_list)))>
                                                            checked
                                                            <(/if)>

                                                            ><($channel.name)>
                                                        </label>
                                                    </div>
                                                </a>
                                                </li>
                                                <(/foreach)>
                                            </ul>
                                            <(/if)>
                                            <!-- /.nav-second-level -->
                                            </li>
                                            <(/foreach)>
                                        </ul>
                                        <!-- /#side-menu -->
                                        <div class="form-group user-group-form-group">
                                            <input type="hidden" value="<($smarty.get.app)>" name="app">
                                            <input type="hidden" value="<(if isset($user_group_info._id))><($user_group_info._id)><(/if)>" name="user_group_id">
                                            <button class="btn btn-default submit">提交</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- /.sidebar-collapse -->
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>



        </div>


    </body>
</html>



