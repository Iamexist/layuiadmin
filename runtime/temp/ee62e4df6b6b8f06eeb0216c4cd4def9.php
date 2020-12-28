<?php /*a:3:{s:71:"D:\phpstudy_pro\WWW\iframe3\application\develop\view\install\step1.html";i:1604472907;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\header.html";i:1600763989;s:70:"D:\phpstudy_pro\WWW\iframe3\application\common\view\public\footer.html";i:1600763989;}*/ ?>
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
        <div class="layui-col-md2"></div>
        <div class="layui-card layui-col-md8">
            <div class="layui-card-header">三国服务器 THINKPHP 6.0 自动化后台2.0  - Step1 开发配置写入</div>
            <div class="layui-card-body">
                <form action="" class="layui-form">
                    <fieldset class="layui-elem-field">
                        <legend>OSS配置</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label">OSS</label>
                                <div class="layui-input-block">
                                    <input type="checkbox" name="oss[open]" value="1" lay-text="On|Off" lay-skin="switch" lay-filter="oss_switch">
                                </div>
                            </div>
                            <div id="oss_box" style="display: none;">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">BUCKET</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="oss[oss_bucket]" value="pilihuo" class="layui-input">
                                    </div>
                                    <label class="layui-form-label">OSS_KEY_ID</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="oss[oss_key_id]" value="LTAI4G9UPE2SvrU3csmUPxM6" class="layui-input">
                                    </div>
                                    <label class="layui-form-label">KEY_SECRET</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="oss[oss_key_secret]" value="1PmN2CTq97RJ0Q4DWqNlx4Rhu4iELn" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">UPLOAD_URL</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="oss[oss_upload_url]" value="http://oss-cn-hangzhou.aliyuncs.com" class="layui-input">
                                    </div>
                                    <label class="layui-form-label">STATIC_URL</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="oss[oss_static_url]" value="https://game.vrupup.com/resources" class="layui-input">
                                    </div>
                                    <label class="layui-form-label">STATIC_PATH</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="oss[oss_static_path]" value="shanxing100" class="layui-input">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </fieldset>

                    <fieldset class="layui-elem-field">
                        <legend>正式环境配置</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label">DB_HOST</label>
                                <div class="layui-input-block">
                                    <input type="text" name="product[db_host]" value="rm-bp1p153yeb567lpo0.mysql.rds.aliyuncs.com" lay-verify="required" placeholder="数据库连接地址" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">DB_PORT</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="product[db_port]" value="3306" lay-verify="required" placeholder="数据库端口" class="layui-input">
                                </div>
                                <label class="layui-form-label">DB_CHAR</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="product[db_char]" value="utf8mb4" lay-verify="required" placeholder="数据库编码" class="layui-input">
                                </div>
                                <label class="layui-form-label">DB_NAME</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="product[db_name]" value="yangyuntian" lay-verify="required" placeholder="数据库名称" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">DB_USER</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="product[db_user]" value="yangyuntian" lay-verify="required" placeholder="数据库账号" class="layui-input">
                                </div>
                                <label class="layui-form-label">DB_PASS</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="product[db_pass]" value="seUv0iSpXCAbP5n" lay-verify="required" placeholder="数据库密码" class="layui-input">
                                </div>
                                <label class="layui-form-label">DB_PRE</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="product[db_pre]" value="good100_" lay-verify="required" placeholder="数据表前缀" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">REDIS_HOST</label>
                                <div class="layui-input-block">
                                    <input type="text" name="product[redis_host]" value="r-bp18vmtk1409q08i00.redis.rds.aliyuncs.com" lay-verify="required" placeholder="redis连接地址" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">REDIS_PORT</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="product[redis_port]" value="6379" lay-verify="required" placeholder="redis端口" class="layui-input">
                                </div>
                                <label class="layui-form-label">REDIS_PASS</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="product[redis_pass]" value="1yVXE0uOItLIBCE" lay-verify="required" placeholder="redis密码" class="layui-input">
                                </div>
                                <label class="layui-form-label">REDIS_INDEX</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="product[redis_index]" value="1" lay-verify="required" placeholder="redis库" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="layui-elem-field">
                        <legend>开发环境配置</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label">DB_HOST</label>
                                <div class="layui-input-block">
                                    <input type="text" name="develop[db_host]" value="127.0.0.1" lay-verify="required" placeholder="数据库连接地址" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">DB_PORT</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="develop[db_port]" value="3306" lay-verify="required" placeholder="数据库端口" class="layui-input">
                                </div>
                                <label class="layui-form-label">DB_CHAR</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="develop[db_char]" value="utf8mb4" lay-verify="required" placeholder="数据库编码" class="layui-input">
                                </div>
                                <label class="layui-form-label">DB_NAME</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="develop[db_name]" value="good100" lay-verify="required" placeholder="数据库名称" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">DB_USER</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="develop[db_user]" value="root" lay-verify="required" placeholder="数据库账号" class="layui-input">
                                </div>
                                <label class="layui-form-label">DB_PASS</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="develop[db_pass]" value="root" placeholder="数据库密码" class="layui-input">
                                </div>
                                <label class="layui-form-label">DB_PRE</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="develop[db_pre]" value="good100_" lay-verify="required" placeholder="数据表前缀" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">REDIS_HOST</label>
                                <div class="layui-input-block">
                                    <input type="text" name="develop[redis_host]" value="47.110.91.60" lay-verify="required" placeholder="redis连接地址" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">REDIS_PORT</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="develop[redis_port]" value="27635" lay-verify="required" placeholder="redis端口" class="layui-input">
                                </div>
                                <label class="layui-form-label">REDIS_PASS</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="develop[redis_pass]" value="1yVXE0uOItLIBCE" placeholder="redis密码" class="layui-input">
                                </div>
                                <label class="layui-form-label">REDIS_INDEX</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="develop[redis_index]" value="1" lay-verify="required" placeholder="redis库" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn layui-btn-normal" lay-submit="">写入开发配置</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="layui-col-md2"></div>
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
<script>
    layui.use(['form'], function() {
        var form = layui.form;
        var $    = layui.$;

        form.render();

        form.on('switch(oss_switch)', function(data) {
            if($(data.elem).prop('checked')) {
                $('#oss_box').show();
            }else {
                $('#oss_box').hide();
            }
        });

        form.on('submit()', function(data) {
            Post('<?php echo url("Install/step1"); ?>', data.field, function(res) {
                if(res.code == 1) {
                    alert_success(res.msg, function() {
                        location.href = '<?php echo url("Install/step2"); ?>';
                    });
                }else {
                    alert_error(res.msg);
                }
            });
            return false;
        });
    });
</script>