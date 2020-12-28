<?php /*a:4:{s:77:"D:\phpstudy_pro\WWW\iframe3\application\admin\view\activity\add_activity.html";i:1604541530;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\header.html";i:1600763989;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\footer.html";i:1600763989;s:71:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\ueditor.html";i:1600398452;}*/ ?>
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
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-card">
            <div class="layui-card-header"><?php echo htmlentities($page_title); ?> <a href="<?php echo url('activity_list'); ?>" class="layui-btn layui-btn-primary layui-layout-right">返回上级</a></div>
            <div class="layui-card-body">
                <form class="layui-form padsome" action="">

                    <div class="layui-form-item">
                        <label class="layui-form-label">活动标题</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" value="<?php echo htmlentities($data['title']); ?>" lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-block">
                            <input type="radio" name="status" value="1" title="开启" <?php if($data['status'] == 1): ?>checked<?php endif; ?>>
                            <input type="radio" name="status" value="2" title="关闭" <?php if($data['status'] == 2): ?>checked<?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">日期时间范围</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" name="time" id="time" value="<?php echo htmlentities($data['time']); ?>">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">活动列表图</label>
                        <div class="layui-input-block">
                            <input type="hidden" name="thumb" id="thumb" value="<?php echo htmlentities($data['thumb']); ?>">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">活动规则图</label>
                        <div class="layui-input-block">
                            <input type="hidden" name="rule" id="rule" value="<?php echo htmlentities($data['rule']); ?>">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">活动轮播图</label>
                        <div class="layui-input-block">
                            <input type="hidden" name="banner" id="banner" value="<?php echo htmlentities($data['banner']); ?>">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <div class="layui-footer" style="left: 0;">
                                <button class="layui-btn" lay-submit="">提交</button>
                                <button class="layui-btn layui-btn-primary" type="button" onclick="back_url()">返回</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
<script type="text/javascript" charset="utf-8" src="<?php echo htmlentities($resource_url); ?>ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo htmlentities($resource_url); ?>ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo htmlentities($resource_url); ?>ueditor/lang/zh-cn/zh-cn.js"></script>
<script>
    // 修改百度编辑器自定义上传接口
    UE.Editor.prototype._bkGetActionUrl = UE.Editor.prototype.getActionUrl;
    UE.Editor.prototype.getActionUrl = function(action) {
        if(action == 'config') {
            return '<?php echo url("Oss/editor_upload"); ?>';
        } else if(action == 'uploadimage') {
            return '<?php echo url("Oss/editor_upload"); ?>?action='+action;
        } else if(action == 'uploadvideo') {
            return '<?php echo url("Oss/editor_upload"); ?>?action='+action;
        } else {
            return this._bkGetActionUrl.call(this, action);
        }
    };
</script>

<script>
    layui.use(['index', 'form', 'laydate', 'layedit'], function(){
        var $ = layui.$
            ,laydate = layui.laydate
            ,form = layui.form;
        form.render(null, 'component-form-group');

        //日期时间范围
        laydate.render({
            elem: '#time'
            ,type: 'datetime'
            ,range: true
            ,format: 'yyyy/MM/dd HH:mm:ss'
        });

        uploadInit('thumb', 'image');

        uploadInit('rule', 'image');

        uploadInit('banner', 'images');


        // 监听表单提交
        form.on('submit()', function(data){
            Post('', data.field, function(res) {
                if (res.code == 1) {
                    alert_success(res.msg, function() {
                        back_url();
                    })
                } else {
                    alert_error(res.msg);
                }
            });
            return false;
        });

    });
</script>