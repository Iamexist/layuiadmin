<?php /*a:3:{s:72:"D:\phpstudy_pro\WWW\iframe3\application\admin\view\prize\prize_list.html";i:1604562378;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\header.html";i:1609135838;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\footer.html";i:1609127281;}*/ ?>
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
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-card">
            <div class="layui-card-header"><?php echo htmlentities($page_title); ?></div>
            <div class="layui-card-body">
                <?php echo access_button('Prize/add_prize', '添加奖品'); ?>
                <form class="layui-search layui-form" action="" method="get">
                    <div class="layui-col-md3">
                        <label>昵称</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" name="nickname" value="<?php echo htmlentities($where['nickname']); ?>" placeholder="请输入昵称">
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-search-submit">
                        <div class="layui-input-inline">
                            <button class="layui-btn layui-btn-normal" type="button" onclick="search(this)">搜索</button>
                        </div>
                    </div>
                    <div class="layui-clear"></div>
                </form>
                <table class="layui-table layui-form">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>奖品名称</th>
                        <th>奖品图片</th>
                        <th>状态</th>
                        <th>奖品数量</th>
                        <th>每日发放量</th>
                        <th>中奖概率</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <?php if(empty($list)): ?>
                    <tr>
                        <td colspan="12" align="center">暂无数据！</td>
                    </tr>
                    <?php endif; ?>
                    <tbody>
                    <?php foreach($list as $item): ?>
                    <tr>
                        <td><?php echo htmlentities($item['id']); ?></td>
                        <td><?php echo htmlentities($item['prize_name']); ?></td>
                        <td><img src="<?php echo htmlentities($item['prize_img']); ?>" alt=""></td>
                        <td><?php if($item['status'] == 1): ?>开启<?php else: ?>关闭<?php endif; ?></td>
                        <td><?php echo htmlentities($item['prize_num']); ?>
                        <td><?php echo htmlentities($item['day_num']); ?></td>
                        <td><?php echo htmlentities($item['win_radio']); ?></td>
                        <td>
                            <!--操作按钮开始-->
                            <?php echo access_button('Prize/add_stock', ['id'=>$item['id']], '添加库存', 'frame', ['400px', '300px']); ?>
                            <?php echo access_button('Prize/edit_prize', ['id'=>$item['id']], '编辑'); ?>
                            <?php echo access_button('Prize/del_prize', ['id'=>$item['id']], '删除', 'confirm'); ?>
                            <!--操作按钮结束-->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <!--分页按钮输出开始-->
                <div class="page">
                    <?php echo $page; ?>
                </div>
                <!--分页按钮输出结束-->
            </div>
        </div>
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