<?php


namespace app\develop\controller;

// 系统安装
use think\App;

class Install extends Base
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);

        if($this->system['install'] && request()->isAjax()) {
            json_response(0, '您已安装，请勿重复安装');
        }

        if($this->system['install'] && !request()->isAjax()) {
            return redirect('Index/index');
        }
    }

    /**
     * 第一步：生成Env配置文件和权限控制数据表
     * @date 2020/8/6 16:02
     */
    public function step1() {
        if(request()->isPost()) {
            try {
                $oss     = $_POST['oss'];
                // 创建env文件
                $env_path = dirname(app()->getAppPath()).'\.env';
                $this->write_env($env_path, ['SYSTEM'=>'develop']);
                $this->write_env($env_path, ['resource_url'=>$this->resource_url]);
                // 写入OSS配置
                if(!empty($oss['open'])) {
                    unset($oss['open']);
                    $this->write_env($env_path, $oss);
                }
                // 写入正式环境配置
                $this->write_env($env_path, ['product'=>$_POST['product']]);
                // 写入开发环境配置
                $this->write_env($env_path, ['develop'=>$_POST['develop']]);
                json_response(1, '写入成功');
            } catch (\Exception $e) {
                json_response(0, '接口错误', [
                    'info' => $e->getMessage(),
                    'line' => $e->getLine()
                ]);
            }
        }else {
            return $this->fetch();
        }
    }

    /**
     * 创建后台代码以及生成sql
     * @date 2020/8/6 16:37
     */
    public function step2() {
        if(request()->isPost()) {
            $app_path  = app()->getAppPath();
            $mg_module = $_POST['mg_module'];
            // 安装模块
            $this->install('mg', $mg_module);
            // 安装锁
            file_put_contents("{$app_path}develop/install.lock", date('Y-m-d H:i:s'));
            file_put_contents("{$app_path}develop/mg_module", json_encode([$_POST['mg_module']]));
            json_response(1, '安装成功');
        }else {
            return $this->fetch();
        }
    }


    /**
     * 写入env文件
     * @param $env_path
     * @param $config
     * @date 2020/8/6 16:37
     */
    private function write_env($env_path, $config) {
        foreach($config as $key=>$value) {
            if(is_array($value)) {
                file_put_contents($env_path, "[{$key}]\n", FILE_APPEND);
                foreach($value as $k=>$v) {
                    file_put_contents($env_path, "{$k}='{$v}'\n", FILE_APPEND);
                }
            }else {
                file_put_contents($env_path, "{$key}='{$value}'\n", FILE_APPEND);
            }
        }
        file_put_contents($env_path, "\n", FILE_APPEND);
    }
}