layui.use(['layer','laydate','table', 'form', 'element'], function(){
    var layer = layui.layer
        ,form = layui.form
        ,element = layui.element
        ,laydate = layui.laydate
        ,table = layui.table
    form.render();

    //laydate 时间选择器
    lay('.time').each(function(){
        laydate.render({
            elem: this
            ,trigger: 'click'
            ,format: 'yyyy-MM-dd HH:mm'
        });
    });
    //laydate 日期选择器
    lay('.date').each(function(){
        laydate.render({
            elem: this
            ,trigger: 'click'
            ,format: 'yyyy-MM-dd'
        });
    });

    //全选的实现


    $(".check-all").click(function(){
        $(".ids").prop("checked", this.checked);
    });
    $(".ids").click(function(){
        var option = $(".ids");
        option.each(function(i){
            if(!this.checked){
                $(".check-all").prop("checked", false);
                return false;
            }else{
                $(".check-all").prop("checked", true);
            }
        });
    });

    //ajax get请求
    $('.ajax-get').click(function(){
        var target;
        var that = this;
        if ( $(this).hasClass('confirm') ) {
            if(!confirm('确认要执行该操作吗?')){
                return false;
            }
        }
        //iframe窗
        if($(that).hasClass('iframe')){
            if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
                layer.open({
                    type: 2,
                    title: '编辑',
                    skin: 'layer-iframe-bg-olive',
                    anim:1,
                    shadeClose: true,//开启遮罩关闭
                    shade: ['0.5'],
                    maxmin: true, //开启最大化最小化按钮
                    area: ['893px', '600px'],
                    content:target+'?is_iframe=1'
                });
            }
            return false;
        }

        if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
            layer.load(0);
            $.get(target).done(function(data){
                layer.closeAll('loading');
                if (data.code==1) {
                    //弹出层
                    if ( $(that).hasClass('popup') ) {
                        layer.open({
                            type: 1,
                            // skin: 'layui-layer-rim', //样式类名
                            closeBtn: 1, //不显示关闭按钮
                            shadeClose: true, //开启遮罩关闭
                            maxmin: true, //开启最大化最小化按钮
                            area: ['893px', '600px'],
                            content: data.data
                        });
                        console.log(data.data);
                        return false;
                    }
                    if (data.url) {
                        layer_success(data.msg + ' 页面即将自动跳转~');
                    }else{
                        layer_success(data.msg);
                    }
                    setTimeout(function(){
                        if (data.url && data.url !== 'javascript:history.back(-1);') {
                            location.href=data.url;
                        }else{
                            location.reload();
                        }
                    },1500);
                }else{
                    layer_error(data.msg);
                    setTimeout(function(){
                        if (data.url) {
                            // location.href=data.url;
                        }else{
                            $('#top-alert').find('button').click();
                        }
                    },1500);
                }
            });

        }
        return false;
    });

    //ajax post submit请求
    $('.ajax-post').click(function(){
        var target,query,form;
        var target_form = $(this).attr('target-form');
        var that = this;
        var nead_confirm=false;
        if( ($(this).attr('type')=='submit') || (target = $(this).attr('href')) || (target = $(this).attr('url')) ){
            form = $('.'+target_form);

            if ($(this).attr('hide-data') === 'true'){//无数据时也可以使用的功能
                form = $('.hide-data');
                query = form.serialize();
            }else if (form.get(0)==undefined){
                return false;
            }else if ( form.get(0).nodeName=='FORM' ){
                if ( $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                if($(this).attr('url') !== undefined){
                    target = $(this).attr('url');
                }else{
                    target = form.get(0).action;
                }
                query = form.serialize();
            }else if( form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA') {
                form.each(function(k,v){
                    if(v.type=='checkbox' && v.checked==true){
                        nead_confirm = true;
                    }
                })
                if ( nead_confirm && $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                query = form.serialize();
            }else{
                if ( $(this).hasClass('confirm') ) {
                    if(!confirm('确认要执行该操作吗?')){
                        return false;
                    }
                }
                query = form.find('input,select,textarea').serialize();
            }
            $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
            $.post(target,query).done(function(data){
                if (data.code==1) {
                    //iframe中的提交不跳转页面
                    if($(that).hasClass('iframe')){
                        layer_success(data.msg);
                        setTimeout(function(){
                            location.reload();
                        },1500);
                        return false;
                    }
                    if (data.url) {
                        layer_success(data.msg+ ' 页面即将自动跳转~');
                    }else{
                        layer_success(data.msg);
                    }
                    setTimeout(function(){
                        $(that).removeClass('disabled').prop('disabled',false);
                        if (data.url  && data.url !== 'javascript:history.back(-1);') {
                            location.href=data.url;
                        }else if( $(that).hasClass('no-refresh')){
                            $('#top-alert').find('button').click();
                        }else{
                            location.reload();
                        }
                    },1500);
                }else{
                    layer_error(data.msg);
                    setTimeout(function(){
                        $(that).removeClass('disabled').prop('disabled',false);
                        if (data.url  && data.url !== 'javascript:history.back(-1);') {
                            location.href=data.url;
                        }else{
                            $('#top-alert').find('button').click();
                        }
                    },1500);
                }
            });
        }
        return false;
    });
});
//成功提示
function layer_success(msg,config = false) {
    layui.use(['layer'],function () {
        var layer = layui.layer;
        if(!config)
            config = {icon: 6,shade:0.5,shadeClose:true};
        layer.msg(msg,config);
    });
}
//错误提示
function layer_error(msg,config = false) {
    layui.use(['layer'],function () {
        var layer = layui.layer;
        if(!config)
            config = {icon: 5,shade:0.5,shadeClose:true};
        layer.msg(msg,config);
    });
}
function getFormJson(frm) {
    var o = {};
    var a = $(frm).serializeArray();
    $.each(a,
        function() {
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
}

/* 上传图片预览弹出层 */

//标签页切换(无下一步)
function showTab() {
    $(".tab-nav li").click(function(){
        var self = $(this), target = self.data("tab");
        self.addClass("current").siblings(".current").removeClass("current");
        window.location.hash = "#" + target.substr(3);
        $(".two-tab-content .tab-pane.in").removeClass("in");
        $("." + target).addClass("in");
    }).filter("[data-tab=tab" + window.location.hash.substr(1) + "]").click();
}

//标签页切换(有下一步)
function nextTab() {
     $(".tab-nav li").click(function(){
        var self = $(this), target = self.data("tab");
        self.addClass("current").siblings(".current").removeClass("current");
        window.location.hash = "#" + target.substr(3);
        $(".two-tab-content .tab-pane.in").removeClass("in");
        $("." + target).addClass("in");
        showBtn();
    }).filter("[data-tab=tab" + window.location.hash.substr(1) + "]").click();

    $("#submit-next").click(function(){
        $(".tab-nav li.current").next().click();
        showBtn();
    });
}

// 下一步按钮切换
function showBtn() {
    var lastTabItem = $(".tab-nav li:last");
    if( lastTabItem.hasClass("current") ) {
        $("#submit").removeClass("hidden");
        $("#submit-next").addClass("hidden");
    } else {
        $("#submit").addClass("hidden");
        $("#submit-next").removeClass("hidden");
    }
}

//导航高亮
function highlight_subnav(url){
    $(document).ready(function () {
        $('.side-sub-menu').find('a[href="' + url + '"]').closest('li').addClass('active');
        $('.side-sub-menu').find('a[href="' + url + '"]').parents('.treeview').addClass('active');
        $('.side-sub-menu').find('a[href="' + url + '"]').parents('.treeview-menu').css({'display':'block'});
    });
}