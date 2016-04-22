{{extends file="`$_common.whale.layoutDir`single.layout.tpl"}}
{{block name="content"}}
<div class="content">
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
