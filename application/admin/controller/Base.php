<?php


namespace app\admin\controller;

use app\common\extend\MgBase;
use think\App;

// 公共继承文件
class Base extends MgBase
{
    public function __construct(App $app = null) {
        // 声明管理端，此处不可删除修改移动
        $this->mg_module = 'admin';
        // 父级初始化
        parent::__construct($app);
    }
}