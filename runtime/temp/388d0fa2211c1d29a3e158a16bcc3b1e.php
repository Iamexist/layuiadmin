<?php /*a:3:{s:71:"D:\phpstudy_pro\WWW\iframe3\application\admin\view\prize\add_stock.html";i:1604562595;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\header.html";i:1600763989;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\footer.html";i:1600763989;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="<?php echo htmlentities($resource_url); ?>layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="<?php echo htmlentities($resource_url); ?>layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="<?php echo htmlentities($resource_url); ?>layuiadmin/style/login.css" media="all">
    <link rel="stylesheet" href="<?php echo htmlentities($resource_url); ?>admin/css/login.css" media="all">
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
<div class="layui-fluid layui-bg-white" style="height: calc(100% - 32px);">
    <form class="layui-form padsome" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">库存数量</label>
            <div class="layui-input-block">
                <input type="text" name="number" value="" lay-verify="required" placeholder="请输入库存数量" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <div class="layui-footer" style="left: 0;">
                    <button class="layui-btn" lay-submit="">提交</button>
                    <button class="layui-btn layui-btn-primary" type="button" onclick="close_frame()">返回</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="<?php echo htmlentities($resource_url); ?>layuiadmin/layui/layui.js"></script>
<script src="<?php echo htmlentities($resource_url); ?>admin/js/common.js"></script>
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
    layui.use(['index', 'form', 'layedit'], function(){
        var $ = layui.$
            ,form = layui.form;
        form.render(null, 'component-form-group');

        // 监听表单提交
        form.on('submit()', function(data){
            delete data.field.file;
            Post('', data.field, function(res) {
                if (res.code == 1) {
                    alert_success(res.msg, function() {
                        close_frame();
                        parent.location.reload();
                    })
                } else {
                    alert_error(res.msg);
                }
            });
            return false;
        });
    });
</script>