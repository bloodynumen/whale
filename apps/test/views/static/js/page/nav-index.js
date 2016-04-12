$().ready(function(){
    //频道组交互
    var group_obj = $('a.mis-nav-group, a.mis-nav-channel');
    group_obj.find('button').hide();
    group_obj.hover(
        function(){
            $(this).find('button').show();
        },
        function(){
            $(this).find('button').hide();
        }
    );

    $('.add_group').click(function(){
        operate_group('添加频道组', 'add');
    });
    $('.edit_group').click(function(){
        var data_obj = MIS.getDataObj($(this));
        operate_group('编辑频道组', 'edit', data_obj);
    });
    $('.del_group').click(function(){
        var data_obj = MIS.getDataObj($(this));
        operate_group('删除频道组', 'del', data_obj);
    });

    $('.add_channel').click(function(){
        var data_obj = MIS.getDataObj($(this));
        data_obj = {
            _id : data_obj._id
        }
        operate_channel('添加频道', 'add', data_obj);
    });
    $('.edit_channel').click(function(){
        var data_obj = MIS.getDataObj($(this));
        operate_channel('编辑频道', 'edit', data_obj);
    });
    $('.del_channel').click(function(){
        var data_obj = MIS.getDataObj($(this));
        operate_channel('删除频道', 'del', data_obj);
    });


    //操作频道组
    function operate_group(dialog_title, method, data_obj) {
        if (typeof(data_obj) == 'undefined') {
            var data_obj = {

            };
        }
        var app = MIS.queryString['app'];
        var tpl = '';
        tpl += '<div class="table-responsive">';
        tpl += '<form action="" method="" role="form">';

        if (method != 'del') {
            tpl += '<div class="form-group">';
            tpl += '<label>频道组名称:</label>';
            tpl += '<input class="form-control" value="' + (data_obj.name ? data_obj.name : '') + '" name="name"></input>';
            tpl += '</div>' ;
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
        tpl += '<input type="hidden" value="' + (data_obj._id ? data_obj._id : '') + '" name="_id"/>';
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
                    var url = '/base/nav/group/' + method;
                    var data = $(this).find('form').serialize();
                    var dataList = $(this).find('form').serializeArray();
                    var emptyField = new Array();
                    $.each(dataList,function (i,field){
                        if (!field.value && field.name != '_id'){
                            emptyField.push(field.name);
                        }
                    });
                    if (emptyField.length != 0) {
                        $.misTip({
                            refresh : false,
                            tip : "请填写正确数据"
                        });
                        return;
                    }
                    $.misAjaxTip({
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

    //操作频道
    function operate_channel(dialog_title, method, data_obj) {
        if (typeof(data_obj) == 'undefined') {
            var data_obj = {

            };
        }
        var tpl = '';
        tpl += '<div class="table-responsive">';
        tpl += '<form action="" method="" role="form">';

        if (method != 'del') {
            tpl += '<div class="form-group">';
            tpl += '<label>频道名称:</label>';
            tpl += '<input class="form-control" value="' + (data_obj.name ? data_obj.name : '') + '" name="name"></input>';
            tpl += '</div>' ;

            tpl += '<div class="form-group">';
            tpl += '<label>频道链接:</label>';
            tpl += '<input class="form-control" placeholder="相对路径,包含app目录" value="' + (data_obj.link ? data_obj.link : '') + '" name="link"></input>';
            tpl += '</div>' ;
        } else {
            tpl += '<div class="well">';
            tpl += '<p class="form-control-static">确认删除吗?</p>';
            tpl += '</div>' ;
            tpl += '<input type="hidden" value="' + (data_obj.name ? data_obj.name : '') + '" name="name"/>';
        }

        //错误信息
        tpl += '<div class="well error_info">';
        tpl += '<label>错误信息</label>';
        tpl += '<p class="form-control-static"></p>';
        tpl += '</div>' ;

        //隐藏字段的位置
        tpl += '<input type="hidden" value="' + (data_obj._id ? data_obj._id : '') + '" name="_id"/>';
        tpl += '<input type="hidden" value="' + (data_obj.channel_id ? data_obj.channel_id : '') + '" name="channel_id"/>';

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
                    var url = '/base/nav/channel/' + method;
                    var data = $(this).find('form').serialize();
                    var dataList = $(this).find('form').serializeArray();
                    var emptyField = new Array();
                    $.each(dataList,function (i,field){
                        if (!field.value && field.name != 'channel_id'){
                            emptyField.push(field.name);
                        }
                    });
                    if (emptyField.length != 0) {
                        $.misTip({
                            refresh : false,
                            tip : "请填写正确数据"
                        });
                        return;
                    }
                    $.misAjaxTip({
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

