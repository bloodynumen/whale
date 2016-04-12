//全局工具对象
var MIS = {
    getPathList : function() {
      return window.location.pathname.split( '/' );
    },
    //常用 获取当前元素的父tr上的属性值
    getTrAttr : function(obj, attr) {
        if (attr == undefined) {
            attr = 'id';
        }
        tr = this.getParentByTag(obj, 'tr');
        return tr.attr(attr);
    },
    //根据htmltag获取元素的父元素
    getParentByTag : function (obj, tag) {
        loop = 10;
        parent = null;
        for (i = 0; i < loop; i++) {
            if (parent) {
                parent = parent.parent();
            } else {
                parent = obj.parent();
            }
            if (parent.is(tag)) {
                return parent;
                break;
            }
        }
        return null;
    },
    //获取数据对象
    getDataObj : function (obj) {
        if (obj.attr('data-attr')) {
            return $.parseJSON(obj.attr('data-attr'));
        }
        loop = 10;
        parent = null;
        for (i = 0; i < loop; i++) {
            if (parent) {
                parent = parent.parent();
            } else {
                parent = obj.parent();
            }
            if (parent.attr('data-attr')) {
                return $.parseJSON(parent.attr('data-attr'));
                break;
            }
        }
        return {};
    },
    //刷新当前页面
    refresh : function() {
        document.location.reload();
    },
    getHost :function() {
        return window.location.protocol + '//' + window.location.host;
    },
    queryString : function () {
        // This function is anonymous, is executed immediately and 
        // the return value is assigned to QueryString!
        var query_string = {};
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            // If first entry with this name
            if (typeof query_string[pair[0]] === "undefined") {
                query_string[pair[0]] = pair[1];
                // If second entry with this name
            } else if (typeof query_string[pair[0]] === "string") {
                var arr = [ query_string[pair[0]], pair[1] ];
                query_string[pair[0]] = arr;
                // If third or later entry with this name
            } else {
                query_string[pair[0]].push(pair[1]);
            }
        } 
        return query_string;
    }()
}

var path_list = window.location.pathname.split('/');
MIS.app_path = path_list[1];
MIS.pathname = window.location.pathname;

$().ready(function(){
    if (MIS.pathname != MIS.app_path) {
        //nav中功能频道 交互处理 默认选中当前访问的频道
        var side_menu = $('#side-menu');
        var func_link = side_menu.find('li[class!="sidebar-search"] ul li a[href^="' + MIS.pathname + '"]');
        if (func_link.length > 0) {
            func_link.each(function(i){
                var href = $(this).attr('href');
                var li_obj = $(this).parent().parent().parent();
                li_obj.addClass('active');
                li_obj.find('ul').removeClass('collapse').addClass('in');
                $(this).addClass('nav-selected');
                return false;
            });
        }
    }

});
//jquery 插件扩展
//mis的ajax 添加了一些默认值而已
$.extend({
    misAjax : function($settings) {
        var $defaultSettings = {
            type : 'GET',
            async : false,
            dataType : 'json',
            success : function (msg) {
                alert(msg.message);
                if ((msg.errno == 0 || msg.errno == 22000)) {
                    MIS.refresh();
                }
            },
            error : function(){
                alert("请求失败");
            }
        }
        $settings = $.extend($defaultSettings, $settings);
        $.ajax ($settings);
    }
});
//mis的ajaxTip ajax请求后 更加合适的tip提示 提示文字和返回的结果中的提示文字一致
$.extend({
    misAjaxTip : function($settings) {
        closeTime = $settings.closeTime ? $settings.closeTime : 10;
        delete $settings.closeTime;

        var $defaultSettings = {
            type : 'GET',
            async : false,
            dataType : 'json',
            success : function (msg) {
                $refresh = false;
                if ((msg.errno == 0 || msg.errno == 22000)) {
                    $refresh = true;
                }
                $.misTip({
                    refresh : $refresh,
                    tip : msg.message,
                    closeTime : closeTime
                });
            },
            error : function(){
                alert("请求失败");
            }
        }
        $settings = $.extend($defaultSettings, $settings);
        $.ajax ($settings);
    }
});
//mis confirm dialog ajax 
$.extend({
    misConfirm : function($confirmSettings) {
        var $data  = $confirmSettings.data;
        var $url  = $confirmSettings.url;
        var $msg  = $confirmSettings.msg;
        var refresh = $confirmSettings.refresh;
        if (typeof(refresh) == 'undefined') {
            refresh = true;
        }
        delete $confirmSettings.msg;
        delete $confirmSettings.data;
        delete $confirmSettings.url;
        delete $confirmSettings.refresh;
        //dialog ui confirm模板
        var tpl = '';
        tpl += '<div style="padding:5px 20px">';
        tpl += '<p style="font-size:14px;padding-top:10px;"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span class="ajaxMsg">' + $msg + '</span></p>';
        //错误信息
        tpl += '<span id="error_info" style="color:red"></span>';
        tpl += '</div>';

        var $defaultConfirmSettings = {
            slow : 'slide',
            width : 320,
            open : function (event, ui) {
                $(this).bind("keypress",function(event){
                    if (event.keyCode == $.ui.keyCode.ENTER) {
                        $(".ui-dialog-buttonpane button").first().click();
                        return false;
                    }
                });
            },
            buttons : {
                "确认" : function() {
                    (function(dialog){
                        $.misAjax({
                            type : 'POST',
                            url : $url,
                            data : $data,
                            success : function(msg){
                                $(".ajaxMsg").text(msg.message);
                                setTimeout(function(){
                                    if ((msg.errno == 0 || msg.errno == 22000) && refresh) {
                                        MIS.refresh();
                                    }
                                    dialog.dialog('close');
                                }, 1500);
                            },
                            error : function(){
                                $("#ajaxMsg").text(msg.message);
                            }
                        });
                    })($(this));

                },
                "取消" : function() {
                    $(this).dialog("close");
                }
            }
        }
        var $confirmSettings = $.extend($defaultConfirmSettings, $confirmSettings);
        $(tpl).dialog($confirmSettings);
    }
});
//tip 提示框 多用于操作成功的提示 
$.extend({
    misTip : function($tipSettings) {
        $tip = $tipSettings.tip ? $tipSettings.tip : '';
        $closeTime = $tipSettings.closeTime ? $tipSettings.closeTime : 1500;
        $refresh = $tipSettings.refresh;

        delete $tipSettings.msg;
        delete $tipSettings.closeTime;
        delete $tipSettings.refresh;

        //dialog ui tip模板
        var tpl = '';
        tpl += '<div style="padding:5px 20px">';
        tpl += '<p style="font-size:14px;padding-top:10px;"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span class="ajaxMsg">' + $tip + '</span></p>';
        //错误信息
        tpl += '<span id="error_info" style="color:red"></span>';
        tpl += '</div>';

        var $defaultTipSettings = {
            title : '提示',
            slow : 'slide',
            width : 320,
            open : function (event, ui) {
                $(this).bind("keypress",function(event){
                    $(this).dialog('close');
                });
                $dialog = $(this);
                setTimeout(function(){
                    $dialog.dialog('close');
                    if ($refresh) {
                        MIS.refresh();
                    }
                }, $closeTime);
            }
        }
        var $tipSettings = $.extend($defaultTipSettings, $tipSettings);
        $(tpl).dialog($tipSettings);
    }
});
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
