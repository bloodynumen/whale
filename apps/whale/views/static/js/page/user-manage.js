(function() {
    require(['jquery', 'jqueryform', 'whale'], function($, jqueryform, whale) {
        $('.add_user').click(function(){
            operate_user('添加用户', 'add');
        });
        $('.edit_user').click(function(){
            var data_obj = whale.getDataObj($(this));
            operate_user('编辑用户', 'edit', data_obj);
        });
        $('.del_user').click(function(){
            var data_obj = whale.getDataObj($(this));
            operate_user('删除用户', 'del', data_obj);
        });


        //操作用户
        function operate_user(dialog_title, method, data_obj) {
            if (typeof(data_obj) == 'undefined') {
                var data_obj = {

                };
            }
            var app = whale.queryString['app'];
            var tpl = '';
            tpl += '<div class="table-responsive">';
            tpl += '<form action="" method="" role="form">';

            if (method != 'del') {
                //用户名不可修改
                if (method != 'edit') {
                    tpl += '<div class="form-group">';
                    tpl += '<label>用户名称:</label>';
                    tpl += '<input class="form-control" value="' + (data_obj.name ? data_obj.name : '') + '" name="name"></input>';
                    tpl += '</div>' ;

                    tpl += '<div class="form-group">';
                    tpl += '<label>密码:</label>';
                    tpl += '<input class="form-control" value="" name="password" type="password"></input>';
                    tpl += '</div>' ;
                }

                tpl += '<div class="form-group">';
                tpl += '<label>用户类型:</label>';
                tpl += '<select class="form-control" name="type">';
                $.each(user_type, function(i, n) {
                    if (i == data_obj.type) {
                        tpl += '<option value="' + i + '" selected>' + n + '</option>';
                    } else {
                        tpl += '<option value="' + i + '">' + n + '</option>';
                    }
                });
                tpl += '</select>';
                tpl += '</div>';

                tpl += '<div class="form-group">';
                tpl += '<label>用户组:</label>';
                $.each(user_group, function(i, n) {
                    tpl += '<label class="checkbox-inline">';
                    if (data_obj.group_list && ($.inArray(n._id, data_obj.group_list) != -1)) {
                        tpl += '<input type="checkbox" name="group_list[]" value="' + n._id + '" checked>' + n.name;
                    } else {
                        tpl += '<input type="checkbox" name="group_list[]" value="' + n._id + '">' + n.name;
                    }
                    tpl += '</label>';
                });
                tpl += '</div>';
            } else {
                tpl += '<div class="well">';
                tpl += '<p class="form-control-static">确认删除吗?</p>';
                tpl += '</div>' ;
            }

            //错误信息
            tpl += '<div class="well error_info">';
            tpl += '<label>错误信息</label>';
            tpl += '<p class="form-control-static"></p>';
            tpl += '</div>' ;

            //隐藏字段的位置
            tpl += '<input type="hidden" value="' + (data_obj._id ? data_obj._id : '') + '" name="id"/>';
            tpl += '<input type="hidden" value="' + app + '" name="app"/>';

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
                        var url = '/whale/user/manage/' + method;
                        var data = $(this).find('form').serialize();
                        var dataList = $(this).find('form').serializeArray();
                        var emptyField = new Array();
                        $.each(dataList,function (i,field){
                            if (!field.value && field.name != 'id'){
                                emptyField.push(field.name);
                            }
                        });
                        if (emptyField.length != 0) {
                            alert(emptyField);
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
