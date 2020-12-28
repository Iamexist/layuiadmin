<?php /*a:3:{s:68:"D:\phpstudy_pro\WWW\iframe3\application\common\view\index\login.html";i:1600398452;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\header.html";i:1609135838;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\footer.html";i:1609127281;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../../../../../static/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../../../../../static/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="../../../../../static/layuiadmin/style/login.css" media="all">
    <link rel="stylesheet" href="../../../../../static/admin/css/login.css" media="all">
    <style>
        td img {
            width: 40px;
            height: 40px;
            display: block;
        }
        .layui-search {
            display: block;
            padding: 10px 10px 0 10px;
            border: 1px solid #e6e6e6;
            background-color: #f2f2f2;
            margin-top: 10px;
        }
        .layui-search .layui-col-md3, .layui-search .layui-col-md9 {
            margin-bottom: 10px;
        }
        .layui-search label {
            float: left;
            display: block;
            width: 80px;
            font-weight: 400;
            line-height: 20px;
            text-align: right;
            padding: 9px 9px 9px 0;
            text-align-last: justify;
            font-size: 13px;
        }
        .layui-search .layui-input-inline {
            width: calc(100% - 100px);
        }
        .layui-form-mid {
            float: none !important;
        }
        .layui-form-select .layui-anim {
            z-index: 999999;
        }
        .img_preview {
            cursor: pointer;
        }
    </style>
    <script>
        var UPLOAD_URL   = '<?php echo url("Oss/upload_file"); ?>';
        var RESOURCE_URL = '<?php echo htmlentities($resource_url); ?>';
    </script>
</head>
<body>
<div class="login_bg" style="height: 100%;">
    <div class="login">
        <div class="title">管理登录</div>
        <div class="dark_banner_wrap"></div>
        <form class="layui-form" action="">
            <input name="username" placeholder="用户名" type="text" lay-verify="required" autocomplete="off" class="layui-input login_input">
            <div class="h15"></div>
            <input name="password" placeholder="密码" type="password" lay-verify="required" autocomplete="off" class="layui-input login_input">
            <div class="h15"></div>
            <button class="layui-btn login_btn" lay-submit="">登录</button>
            <div class="h15"></div>
        </form>
    </div>
</div>
<script src="../../../../static/layuiadmin/layui/layui.js"></script>
<script src="../../../../static/admin/js/common.js"></script>
<script>
    layui.config({
        base: '<?php echo htmlentities($resource_url); ?>layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['layer', 'form'], function() {
        var $       = layui.$;
        var form    = layui.form;
        var layer   = layui.layer;
        form.render();
        form.on('checkbox(checkAll)', function(data) {
            if($(data.elem).prop('checked')) {
                $('[name="ids[]"]').prop("checked", true);
                form.render();
            }else {
                $('[name="ids[]"]').prop("checked", false);
                form.render();
            }
        });
        $('.img_preview').click(function () {
            // 创建对象
            var img = new Image();
            img.src = $(this).attr('src');
            var height = img.height, width = img.width;
            while(width > 800 || height > 400) {
                height /= 2;
                width /= 2;
            }
            layer.open({
                type: 1,
                shade: false,
                title: false,
                area: [width+'px', height+ 'px'],
                content: '<img style="width: '+width+'px; height: '+height+'px;" src="'+$(this).attr('src')+'"/>'
            });
        });
    });
</script>
</body>
</html>
<script>
    layui.use(['form'], function(){
        var $    = layui.$;
        var form = layui.form;

        form.render();

        // 登录
        form.on('submit()', function(data){
            Post('', data.field, function(res) {
                if (res.code == 1) {
                    tips_success(res.msg, function() {
                        location.href = '<?php echo url("Index/index"); ?>';
                    });
                } else {
                    alert_error(res.msg);
                }
            });
            return false;
        });
    });
</script>
