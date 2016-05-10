{{extends file="`$_common.whale.layoutDir`single.layout.tpl"}}
{{block name="content"}}
    <div id="wrapper" class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ucfirst($smarty.get.app)}}导航管理</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <button type="button" class="btn btn-success add_group">添加频道组</button>
                        <div class="navbar-default top17" role="navigation">
                            <div class="sidebar-collapse">
                                <ul class="nav">
                                    {{foreach $nav_list as $group}}
                                    <li>
                                        <a class="mis-nav-group" href="#"><i class="fa fa-wrench fa-fw"></i> {{$group.name}}
                                            <button type="button" class="btn btn-primary btn-xs edit_group" data-attr='{{$group|json_str}}'>编辑</button>
                                            <button type="button" class="btn btn-primary btn-xs add_channel" data-attr='{{$group|json_str}}'>添加功能频道</button>
                                            <button type="button" class="btn btn-primary btn-xs del_group" data-attr='{{$group|json_str}}'>删除</button>
                                        </a>
                                        {{if isset($group.channel_list)}}
                                        <ul class="nav nav-second-level">
                                            {{foreach $group.channel_list as $channel}}
                                            <li>
                                                <a class="mis-nav-channel" href="javascript:void(0);">
                                                    {{$channel.name}}
                                                    <button type="button" class="btn btn-primary btn-xs edit_channel" data-attr='{{$channel|json_str}}'>编辑</button>
                                                    <button type="button" class="btn btn-primary btn-xs del_channel" data-attr='{{$channel|json_str}}'>删除</button>
                                                </a>
                                            </li>
                                            {{/foreach}}
                                        </ul>
                                        {{/if}}
                                        <!-- /.nav-second-level -->
                                    </li>
                                    {{/foreach}}
                                </ul>
                                <!-- /#side-menu -->
                            </div>
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
    {{/block}}
    {{block name="footer" append}}
        <script src="/whale/static/js/page/nav-index.js"></script>
        {{/block}}
