{{$_common.whale.layoutDir}}
{{extends file="`$_common.whale.layoutDir`single.layout.tpl"}}
{{block name="content"}}
<div class="content">
    <div class="jumbotron">
        <h1>Hello, world!</h1>
        <p>...</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
    </div>
    {{if $list}}
    <ul>
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
