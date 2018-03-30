layui.use(['layer','laydate','table', 'form', 'element'], function(){
    var layer = layui.layer;
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
                    area: 'auto',
                    content:target+'?is_iframe=1'
                });
            }
            return false;
        }

        if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
            layer.load(0);
            if ( $(that).hasClass('popup') ){
                target = target+'?is_popup=1';
            }
            $.get(target).done(function(data){
                layer.closeAll('loading');
                if (data.code==1) {
                    //弹出层
                    if ( $(that).hasClass('popup') ) {
                        layer.open({
                            type: 1,
                            skin: 'layui-layer-demo', //样式类名
                            closeBtn: 0, //不显示关闭按钮
                            anim: 2,
                            shadeClose: true, //开启遮罩关闭
                            content: data.data
                        });
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