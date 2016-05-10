{{extends file="`$_common.whale.layoutDir`single.layout.tpl"}}
{{block name="title"}}登陆{{/block}}
{{block name="content"}}
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">请登录</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="/whale/user/index/auth" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="用户名" name="name" type="text" autofocus="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="密码" name="password" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">记住我
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-lg btn-success btn-block">登陆</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{/block}}
{{block name="footer" append}}
    <script src="/whale/static/js/page/user/login.js"></script>
{{/block}}


