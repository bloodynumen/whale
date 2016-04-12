<(extends file="`$page.tpl.systemDir`defaultLayout.tpl")>
<(block name="head" append)>
<script type="text/javascript" src="/base/static/js/page/performance/index.js"></script>
<(/block)>
<(block name="title")>性能日志查看<(/block)>
<(block name="content")>
<div id="mis_content">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">性能日志查看</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <(foreach $fields as $field => $name)>
                                    <th><($name)></th>
                                    <(/foreach)>
                                </tr>
                            </thead>
                            <tbody>
                                <(foreach $list as $item)>
                                <tr data-attr='<($item|json_str)>'>
                                    <(foreach $fields as $field => $name)>
                                    <td>
                                        <($item.$field)>
                                    </td>
                                    <(/foreach)>
                                </tr>
                                <(/foreach)>
                            </tbody>
                        </table>
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
<(/block)>
