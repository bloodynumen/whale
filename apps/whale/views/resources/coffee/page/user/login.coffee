require ['jquery', 'jqueryform'], ($) ->
    $("form").ajaxForm
        success: (res) ->
            if res.errno == 22000
                window.location.href = '/juhe/'
            else
                alert(res.msg)
        error: () ->
            alert("请求错误")
