(function() {
    require(['jquery', 'jqueryform', 'whale'], function($, jqueryform, whale) {
        $('.submit').click(function(){
            var form = $('form[role="form"]');
            var url = form.attr('action');
            var data = form.serialize();
            var dataList = form.serializeArray();
            var emptyField = new Array();
            $.each(dataList,function (i,field){
                if (!field.value && field.name != 'user_group_id'){
                    emptyField.push(field.name);
                }
            });
            if (emptyField.length != 0) {
                $.whaleTip({
                    refresh : false,
                    tip : "请填写正确数据"
                });
                return false;
            }
            $.whaleAjaxTip({
                type : 'POST',
                url : url,
                data : data,
                closeTime : 1000,
            });
            return false;
        });
        //删除用户组
        $('.del_user_group').click(function(){
            var data_obj = whale.getDataObj($(this));
            operate_group('删除用户组', 'del', data_obj);
        });
        //操作频道组
        function operate_group(dialog_title, method, data_obj) {
            if (typeof(data_obj) == 'undefined') {
                var data_obj = {};
            }
            queryString = whale.queryString;
            var tpl = '';
            tpl += '<div class="table-responsive">';
            tpl += '<form action="" method="" role="form">';

            tpl += '<div class="well">';
            tpl += '<p class="form-control-static">确认删除吗?</p>';
            tpl += '</div>' ;

            //错误信息
            tpl += '<div class="well error_info">';
            tpl += '<label>错误信息</label>';
            tpl += '<p class="form-control-static"></p>';
            tpl += '</div>' ;

            //隐藏字段的位置
            tpl += '<input type="hidden" value="' + (data_obj._id ? data_obj._id : '') + '" name="user_group_id"/>';
            tpl += '<input type="hidden" value="' + queryString.app + '" name="app"/>';

            tpl += '</form>';
            tpl += '</div>';

            $(tpl).dialog({
                slow : 'slide',
                title : dialog_title,
                width : 580,
                open : function (event, ui) {
                    $(this).find('.error_info').hide();
                    $(this).bind("keypress",function(event){
                        if (event.keyCode == $.ui.keyCode.ENTER) {
                            $(".ui-dialog-buttonpane button").first().click();
                            return false;
                        }
                    });
                },
                buttons : {
                    "确认" : function() {
                        var dialog = $(this);
                        var url = '/whale/user/group/' + method;
                        var data = $(this).find('form').serialize();
                        var dataList = $(this).find('form').serializeArray();
                        var emptyField = new Array();
                        $.each(dataList,function (i,field){
                            if (!field.value){
                                emptyField.push(field.name);
                            }
                        });
                        if (emptyField.length != 0) {
                            $.whaleTip({
                                refresh : false,
                                tip : "请填写正确数据"
                            });
                            return;
                        }
                        $.whaleAjaxTip({
                            type : 'POST',
                            url : url,
                            data : data,
                            closeTime : 1000,
                        });
                    },
                    "取消" : function() {
                        $(this).dialog("close");
                    }
                }
            });
        }
    });

}).call(this);

