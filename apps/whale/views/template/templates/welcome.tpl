{{$_common.whale.layoutDir}}
{{extends file="`$_common.whale.layoutDir`single.layout.tpl"}}
{{block name="content"}}
<div class="content">
    <div class="jumbotron">
        <h1>Hello, world!</h1>
        <p>欢迎来到 Whale</p>
    </div>
    {{if $list}}
    <ul class="app-list">
        {{foreach $list as $short => $app}}
        <li><a href="/{{$short}}/">{{$app.name}}</a></li>
        {{/foreach}}
    </ul>
    {{/if}}
</div>
{{/block}}

{{block name="footer" append}}
    <script src="/whale/static/js/page/welcome.js"></script>
{{/block}}
