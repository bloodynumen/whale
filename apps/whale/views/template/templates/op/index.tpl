<div id="mis_content">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">操作日志查看</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <form class="form-inline" action="<($smarty.server.PATH_INFO)>" method="GET">
            <div class="form-group">
              <label for="search-name">操作人</label>
              <input type="text" class="form-control" id="search-editor" name="editor" value="<(if isset($smarty.get.editor))><($smarty.get.editor)><(/if)>" />
            </div>
            <div class="form-group">
              <label for="search-name">path</label>
              <input type="text" class="form-control" id="search-path" name="path" value="<(if isset($smarty.get.path))><($smarty.get.path)><(/if)>" />
            </div>
            <div class="form-group">
              <label for="search-name">起始时间</label>
              <input type="date" class="form-control" id="search-begin_datetime" name="begin_datetime" value="<(if isset($smarty.get.begin_datetime))><($smarty.get.begin_datetime)><(/if)>" />
            </div>
            <div class="form-group">
              <label for="search-name">结束时间</label>
              <input type="date" class="form-control" id="search-end_datetime" name="end_datetime" value="<(if isset($smarty.get.end_datetime))><($smarty.get.end_datetime)><(/if)>" />
            </div>
            <input type="hidden" name="app" value="<(if isset($smarty.get.app))><($smarty.get.app)><(/if)>" />
            <button type="submit" class="btn btn-default">筛选</button>
          </form>
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
                  <tr>
                    <(foreach $fields as $field => $name)>
                    <td>
                      <(if strpos($field, '_params') !== false)>
                        <textarea rows="4"><(print_r($item.$field, true))></textarea>
                      <(elseif $field == 'ctime')>
                        <($item.$field|date_format:"%Y-%m-%d %H:%M:%S")>
                      <(else)>
                        <($item.$field)>
                      <(/if)>
                    </td>
                    <(/foreach)>
                  </tr>
                <(/foreach)>
              </tbody>
            </table>
          </div>
          <($pagination|pagination)>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
  </div>
</div>
