{{extends file="`$_common.whale.layoutDir`single.layout.tpl"}}
{{block name="content"}}
    <div id="wrapper" class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ucfirst($smarty.get.app)}}角色管理</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <a href="/whale/user/group/add?app={{$smarty.get.app}}" class="btn btn-success add_group">添加角色</a>
                        <div class="table-responsive top17">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        {{foreach $header as $field => $text}}
                                        <th>{{$text}}</th>
                                        {{/foreach}}
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{foreach $list as $row}}
                                    <tr class="odd gradeX">
                                        {{foreach $header as $field => $text}}
                                        <td>{{$row.$field}}</td>
                                        {{/foreach}}
                                        <td class="center">
                                            <a class="btn btn-primary btn-xs" href="/whale/user/group/edit?app={{$smarty.get.app}}&user_group_id={{$row._id}}" >编辑</a>
                                            <button type="button" class="btn btn-primary btn-xs del_user_group" data-attr='{{$row|json_str}}'>删除</button>
                                        </td>
                                    </tr>
                                    {{/foreach}}
                                </tbody>
                            </table>
                            <!-- 
                                 <div class="row"><div class="col-sm-6"><div class="dataTables_info" id="dataTables-example_info" role="alert" aria-live="polite" aria-relevant="all">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-6"><div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate"><ul class="pagination"><li class="paginate_button previous disabled" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous"><a href="#">Previous</a></li><li class="paginate_button active" aria-controls="dataTables-example" tabindex="0"><a href="#">1</a></li><li class="paginate_button " aria-controls="dataTables-example" tabindex="0"><a href="#">2</a></li><li class="paginate_button " aria-controls="dataTables-example" tabindex="0"><a href="#">3</a></li><li class="paginate_button " aria-controls="dataTables-example" tabindex="0"><a href="#">4</a></li><li class="paginate_button " aria-controls="dataTables-example" tabindex="0"><a href="#">5</a></li><li class="paginate_button " aria-controls="dataTables-example" tabindex="0"><a href="#">6</a></li><li class="paginate_button next" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next"><a href="#">Next</a></li></ul></div></div></div>
                               -->
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
    </div>
{{/block}}
{{block name="footer" append}}
    <script src="/whale/static/js/page/user-group-operate.js?v=2"></script>
{{/block}}
