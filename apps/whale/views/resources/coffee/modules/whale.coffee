#扩展jquery,并提供whale工具模块

define 'whale', ['jquery', 'jqueryui','jqueryform'], ($)->
  #新的扩展等 加入到whale中 而非扩展jquery
  whale =
    getPathList: ()->
      return window.location.pathname.split( '/' )
      #刷新当前页面
    refresh: ()->
      document.location.reload()
    getHost: ()->
      return window.location.protocol + '#' + window.location.host
    path: window.location.pathname
    #获取数据对象
    getDataObj: (obj) ->
        if obj.attr('data-attr')
            return $.parseJSON(obj.attr('data-attr'))
        parent = obj.closest('[data-attr]')
        if parent.length
            return $.parseJSON(parent.attr('data-attr'))
        return {}
    queryString: do ->
        query_string = {}
        query = window.location.search.substring(1)
        vars = query.split("&")
        for unit in vars
            pair = unit.split("=");
            if typeof query_string[pair[0]] == "undefined"
                query_string[pair[0]] = pair[1]
            else if typeof query_string[pair[0]] == "string"
                arr = [ query_string[pair[0]], pair[1] ]
                query_string[pair[0]] = arr
            else
                query_string[pair[0]].push(pair[1])
        return query_string
    formDialog: (tpl, settings) ->
      effects = ['blind', 'clip', 'drop', 'explode', 'fold', 'puff', 'slide', 'scale', 'size', 'pulsate']
      defaultSettings =
        ajaxForm:
          #检查数据是否为空
          beforeSubmit: (arr, formObj, options)->
            emptyField = []
            $.each arr, (i,field)->
              if !field.value and (formObj.find('[name=' + field.name + ']').attr('allow_empty') != 'true')
                emptyField.push(field.name)
                console.log(field.name)
            if emptyField.length != 0
              $.whaleTip
                refresh : false,
                tip : "请填写完整数据"
              return false
          success:  (res)->
            refresh = false
            if (res.errno == 22000)
              refresh = true
            $.whaleTip
              refresh: refresh,
              tip: res.msg,
              closeTime : 1500
          error : ()->
            $.whaleTip
              refresh : false,
              tip : "网络请求失败"
        dialog:
          show: effects[Math.floor(Math.random() * effects.length)]
          hide: effects[Math.floor(Math.random() * effects.length)]
          title: ''
          width: 320
          height: 'auto'
          afterOpen: (dialog)->
            return false

      settings = $.extend(true, defaultSettings, settings)
      $(tpl).dialog
        show: settings.dialog.show
        hide: settings.dialog.hide
        title: settings.dialog.title
        width: settings.dialog.width
        height: settings.dialog.height
        open : (event, ui) ->
          $(this).bind "keypress", (event) ->
            if event.keyCode == $.ui.keyCode.ENTER
              $(".ui-dialog-buttonpane button").first().click()
              return false
          settings.dialog.afterOpen($(this))
          return
        buttons :
          "确认" : () ->
            $(this).find('form').ajaxSubmit settings.ajaxForm
          "取消" : () ->
            $(this).dialog("close")


  path_list = window.location.pathname.split('/')
  whale.app_path = path_list[1]
  whale.pathname = window.location.pathname

  #nav中功能频道 交互处理 默认选中当前访问的频道
  if (whale.pathname != whale.app_path)
    side_menu = $('#side-menu')
    func_link = side_menu.find('li[class!="sidebar-search"] ul li a[href^="' + whale.pathname + '"]')
    if (func_link.length > 0)
      func_link.each (i)->
        href = $(this).attr('href')
        li_obj = $(this).parent().parent().parent()
        li_obj.addClass('active')
        li_obj.find('ul').removeClass('collapse').addClass('in')
        $(this).addClass('nav-selected')
        return false

  #jquery 插件扩展
  #whale的ajax,添加了一些默认值而已
  $.extend
    whaleAjax : ($settings)->
      $defaultSettings =
        type : 'GET',
        async : false,
        dataType : 'json',
        success :  (msg)->
          alert(msg.msg)
          if ((msg.errno == 0 || msg.errno == 22000))
            whale.refresh()
        error : ()->
          alert("请求失败")
      $settings = $.extend($defaultSettings, $settings)
      $.ajax ($settings)

  #whale的ajaxTip ajax请求后 更加合适的tip提示 提示文字和返回的结果中的提示文字一致
  $.extend
    whaleAjaxTip: ($settings)->
      closeTime = if $settings.closeTime then $settings.closeTime else 10
      delete $settings.closeTime

      $defaultSettings =
        type : 'GET',
        async : false,
        dataType : 'json',
        success :  (msg)->
          $refresh = false
          if ((msg.errno == 0 || msg.errno == 22000))
            $refresh = true
          $.whaleTip
            refresh: $refresh,
            tip: msg.msg,
            closeTime : closeTime
        error : ()->
          alert("请求失败")
      $settings = $.extend($defaultSettings, $settings)
      $.ajax ($settings)

  #tip 提示框 多用于操作成功的提示
  $.extend
    whaleTip: ($tipSettings)->
      $tip = if $tipSettings.tip then $tipSettings.tip else ''
      $closeTime = if $tipSettings.closeTime then $tipSettings.closeTime else 1500
      $refresh = $tipSettings.refresh

      delete $tipSettings.msg
      delete $tipSettings.closeTime
      delete $tipSettings.refresh

      #dialog ui tip模板
      tpl = ''
      tpl += '<div style="padding:5px 20px">'
      tpl += '<p style="font-size:14pxpadding-top:10px"><span class="ui-icon ui-icon-alert" style="float:left margin:0 7px 20px 0"></span><span class="ajaxMsg">' + $tip + '</span></p>'
      #错误信息
      tpl += '<span id="error_info" style="color:red"></span>'
      tpl += '</div>'

      $defaultTipSettings =
        title : '提示',
        slow : 'slide',
        width : 320,
        open :  (event, ui)->
          $(this).bind "keypress", (event)->
            $(this).dialog('close')
          $dialog = $(this)
          callback = ->
            $dialog.dialog('close')
            if ($refresh)
              document.location.reload()
          setTimeout callback, $closeTime
      $tipSettings = $.extend($defaultTipSettings, $tipSettings)
      $(tpl).dialog($tipSettings)
  return whale
