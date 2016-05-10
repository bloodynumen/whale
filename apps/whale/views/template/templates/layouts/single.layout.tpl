<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        {{block name="head"}}
        <meta charset="utf-8"/>
        <title>{{if isset($_common.page.site)}}{{$_common.page.site}}-{{/if}}{{block name="title"}}{{/block}}</title>
        <link rel="shortcut icon" href="/whale/static/images/favicon.ico"/>
        <link rel="stylesheet" href="/whale/static/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/whale/static/css/font-awesome.css" />
        <link rel="stylesheet" href="/whale/static/css/sb-admin.css" />
        <link rel="stylesheet" href="/whale/static/css/whale.css?v=8899" />
        <link rel="stylesheet" href="/whale/static/css/jquery-ui-1.10.0.custom.css?v=2" />
        {{/block}}
    </head>

    <body>
        <div class="container single-wrapper">
            {{block name="content"}}
            {{/block}}

            {{block name="footer"}}
                <script src="/whale/static/js/require.min.js"></script>
                <script src="/whale/static/js/require.init.js?v=1"></script>
            {{/block}}
        </div>
    </body>
</html>
