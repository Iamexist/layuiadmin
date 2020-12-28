<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 根据权限生成按钮
 * @param $router
 * @param array $param
 * @param string $name
 * @param string $type
 * @param array $area frame窗口大小
 * @param string $style 按钮样式
 */
function access_button($router, $param=[], $name='', $type='url', $area=[], $style='') {
    global $admin_uid, $mg_router;
    $router = count(explode('/', $router)) > 2 ? $router : "{$mg_router}/{$router}";
    $button = '<a href="{url}" class="layui-btn {style}">{icon}{name}</a>';
    $data = cache("{$mg_router}_menu_{$admin_uid}");
    $link = url($router, $param);
    if($type == 'url') {
        $url = $link;
    }else if($type == 'confirm') {
        $url = "javascript: confirm('{$link}', '是否确认执行此操作？')";
    }else if($type == 'frame') {
        if(is_array($area) && count($area) > 1) {
            $frame_area = ", ['{$area[0]}', '{$area[1]}']";
        }else if(is_string($area)){
            $frame_area = ", ['{$area}', '90%']";
        }else {
            $frame_area = ", ['90%', '90%']";
        }
        $url = "javascript: open_frame('{$link}', '{$data['access_menu'][$router]['name']}'{$frame_area})";
    }else if($type == 'prompt') {
        $url = "javascript: _prompt('{$link}', '{$area}')";
    }else if($type == 'upload') {
        $area = empty($area) ? '' : $area;
        $url = "javascript: _upload('{$link}', '{$area}')";
    }else if($type == 'batch') {
        $url = "javascript: batch_action('{$link}', '{$area}')";
    }else {
        $url = '';
    }
    $real_style = empty($style) ? $data['access_menu'][$router]['style'] : $style;
    if(in_array($router, array_keys($data['access_menu']))) {
        echo str_replace([
            '{url}',
            '{style}',
            '{icon}',
            '{name}'
        ], [
            $url,
            $real_style,
            $data['access_menu'][$router]['icon'] ? '<i class="layui-icon '.$data['access_menu'][$router]['icon'].'"></i>' : '',
            empty($name) ? $data['access_menu'][$router]['name'] : $name
        ], $button);
    }
}

/**
 * 递归读取目录内容
 * @param string $root_path
 * @return array
 * @date 2020/8/6 21:24
 */
function folder_read($root_path=''){
    $files     = [];
    if(!is_dir($root_path)) return [];
    $dh = opendir($root_path);
    while ($file = readdir($dh)) {
        if($file == '.' || $file == '..') {
            continue;
        }
        if(is_dir($root_path.$file)) {
            $files[$file] = folder_read($root_path.$file.'/');
        }else {
            $files[] = $file;
        }
    }
    closedir($dh);
    return $files;
}

/**
 * 生成随机字符串
 * @param int $lenth
 * @return string
 */
function str_random($lenth=6) {
    $base = 'qwertyuiopasdfghjklzxcvbnm0123456789QWERTYUIOPASDFGHJKLZXCVBNM';
    $str = '';
    for($i=1; $i<=$lenth; $i++) {
        $str .= $base[mt_rand(0, strlen($base) - 1)];
    }
    return $str;
}

/**
 * 大写字母转下划线加小写字母(忽略首字母)
 * @param string $name
 * @return string
 */
function str_format($name='') {
    $temp_array = array();
    for($i=0; $i<strlen($name); $i++) {
        $ascii_code = ord($name[$i]);
        if($ascii_code >= 65 && $ascii_code <= 90){
            if($i == 0) {
                $temp_array[] = chr ($ascii_code + 32);
            }else {
                $temp_array[] = '_'.chr ($ascii_code + 32);
            }
        } else{
            $temp_array[] = $name[$i];
        }
    }
    return implode('',$temp_array);
}

/**
 * 数组无限级分类
 * @param $arr
 * @param bool $sub_list // 是否放在子数组内
 * @param $key_val // 第一级的上级ID参数值
 * @param array $config
 * @param int $level
 * @return array
 */
function arr_tree($arr, $sub_list=false, $key_val=0, $config=[], $level=1) {
    $parent_key = isset($config['parent_key']) ? $config['parent_key'] : 'parent_id'; // 上级ID参数名称
    $key        = isset($config['key']) ? $config['key'] : 'id'; // 主键ID参数名称
    $res = array();
    foreach ($arr as $k=>$item) {
        if($item[$parent_key] == $key_val) {
            unset($arr[$k]);
            $item['level'] = $level;
            if($sub_list) {
                $item['sub_list'] = arr_tree($arr, $sub_list, $item[$key], $config, $level + 1);
                $res[] = $item;
            }else {
                $res[] = $item;
                $res = array_merge($res , arr_tree($arr, $sub_list, $item[$key], $config,$level + 1));
            }
        }
    }
    return $res;
}

/**
 * xml转数组
 * @param $xml
 * @return mixed
 * @date 2020/6/12 18:26
 */
function xml_to_array($xml) {
    //将XML转为array
    $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array_data;
}

/**
 * 数组转xml
 * @param $arr
 * @return string
 * @date 2020/6/12 18:26
 */
function array_to_xml($arr) {
    if(!is_array($arr) || count($arr) <= 0) {
        json_response(0, "数组数据异常！");
    }
    $xml = "<xml>";
    foreach ($arr as $key=>$val)
    {
        if (is_numeric($val)) {
            $xml.="<".$key.">".$val."</".$key.">";
        }else{
            $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
    }
    $xml .= "</xml>";
    return $xml;
}

/**
 * 取出html内的img地址
 * @param string $content
 * @return array
 */
function html_parse_img($content='') {
    preg_match_all('/<img.*?src="(.*?)".*?>/', $content, $matches);
    return isset($matches[1]) ? $matches[1] : [];
}

/**
 * 解析百度编辑器内容
 * @param string $text
 * @return array
 * @date 2020/8/17 13:57
 */
function parse_ueditor($text='') {
    // 正则取出富文本内容
    preg_match_all("/<p.*?>(.*?)<\/p>/", $text, $p_list);
    $content = [];
    foreach ($p_list[1] as $p_key=>$p_item) {
        preg_match('/<img.*?src="(.*?)".*?\/>/', $p_item, $img);
        preg_match('/<embed.*?src="(.*?)".*?\/>/', $p_item, $video);
        if(empty($img[1]) && empty($video[1])) {
            if(strpos($p_list[0][$p_key], 'center')) {
                $p_item = str_replace('&nbsp;', '', $p_item);
                $indent = 2;
            }else if(strpos($p_item, '&nbsp;') === 0){
                $p_item = str_replace('&nbsp;', '', $p_item);
                $indent = 1;
            }else {
                $indent = 0;
            }
            $content[] = [
                'type'   => 'text',
                'value'  => trim(strip_tags($p_item)),
                'indent' => $indent
            ];
        }else if(!empty($img[1])) {
            $content[] = [
                'type'  => 'img',
                'value' => $img[1]
            ];
        }else if(!empty($video[1])) {
            $content[] = [
                'type'  => 'video',
                'value' => $video[1]
            ];
        }
    }
    return $content;
}

/**
 * 递归创建目录
 * @param string $dir
 * @return bool
 */
function folder_build($dir='') {
    if(!is_dir($dir)) {
        while(!is_dir(dirname($dir))) {
            if(!folder_build(dirname($dir))) {
                json_response(0, $dir.'目录写入失败');
            }
        }
        if(!is_writable($dir)) {
            return mkdir($dir, 0777, true);
        }else {
            json_response(0,$dir.'目录不可写');
        }
    }
}

/**
 * JSON格式返回数据
 * @param int $code
 * @param string $msg
 * @param array $data
 */
function json_response($code=0, $msg='', $data=[]) {
    echo json_encode([
        'code' => $code,
        'msg'  => $msg,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

/**
 * 参数检查
 * @param string $name
 * @param bool $default
 * @param string $tips
 * @return array|bool
 */
function param_check($name, $default=false, $tips='') {
    $val = input($name);
    if(!empty($val)) {
        return $val;
    }else {
        if($default !== false) return $default;
        json_response(0, empty($tips) ? "{$name}不能为空" : $tips);
    }
}

/**
 * Curl操作
 * @param string $type 请求类型 'POST' 或 'GET' 大小写都可以
 * @param string $url 请求地址 url
 * @param array $data 数组 cookie 请求cookie data post请求数据
 * @param bool $headerFile 返回头信息 如果页面做了跳转 则可以从返回头信息获得跳转地址，应用场景不多
 * @return bool|mixed
 */
function curl($type, $url, $data=[], $headerFile=false) {
    $type = strtoupper($type);
    $type_list = ['POST', 'GET', 'PUT'];
    if(!in_array($type, $type_list)) $type = 'POST';
    $ch = curl_init();
    // 请求类型
    if($type == 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
    }else if($type == 'PUT') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PUT"); //设置请求方式
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //绕过ssl验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_ENCODING, ''); // 这个是解释gzip内容, 解决获取结果乱码 gzip,deflate
    // 是否存在请求字段信息
    if(!empty($data['data']) && $type == 'POST') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data['data']);
    }
    // 是否存在cookie
    if(!empty($data['cookie'])) {
        curl_setopt($ch, CURLOPT_COOKIE, $data['cookie']);
    }
    // 请求头
    if(!empty($data['header'])) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $data['header']);
    }

    // 证书
    if(!empty($data['ssl_cert'])) {
        curl_setopt($ch,CURLOPT_SSLCERT, $data['ssl_cert']);
    }
    if(!empty($data['ssl_key'])) {
        curl_setopt($ch,CURLOPT_SSLKEY, $data['ssl_key']);
    }

    // 返回ResponseHeader
    if($headerFile) {
        curl_setopt($ch, CURLOPT_HEADER, 1);
    }
    // 设置请求超时时间
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    // 发送请求
    $result = curl_exec($ch);
    if (curl_errno($ch)) return false;
    curl_close($ch);
    return $result;
}

/**
 * 数组转csv
 * @param array $data 数组
 * @param string $file_name 文件名字
 * @param array $fields 字段介绍
 */

function array_to_csv($data=[], $file_name='', $fields=[]) {
    // 表头
    header('Content-Type: application/vnd.ms-excel');   // header设置
    header("Content-Disposition: attachment;filename=".($file_name ? $file_name : '导出').".csv");
    header('Cache-Control: max-age=0');
    $fp = fopen('php://output','a');
    $header = empty($fields) ? array_keys($data[0]) : array_values($fields);
    $head = [];
    foreach($header as $i=>$value) {
        $value = is_array($value) ? $value[0] : $value;
        $head[$i] = iconv("UTF-8","GBK", $value);
    }
    fputcsv($fp,$head);
    foreach ($data as $i=>$item) {
        $list = [];
        foreach($fields as $k=>$v) {
            $value = isset($item[$k]) ? $item[$k] : '';
            if(is_array($v)) {
                if(is_array($v[1])) {
                    // 数组类型处理
                    $value = $v[1][$value];
                }else if(is_callable($v[1])) {
                    // 匿名函数处理
                    $value = $v[1]($item);
                }else if(is_string($v[1])) {
                    // 字符串类型处理
                    if($v[1]  == 'datetime') {
                        // 格式化时间戳
                        $value = $value > 0 ? date('Y-m-d H:i:s', $value) : '';
                    }else if(!empty($v[1])) {
                        // 设置字段默认值
                        $value = $v[1];
                    }
                }
            }
            // 处理数字变为科学计数法的问题
            $value .= "\t";
            $list[$k] = iconv("UTF-8","GBK", (string)$value);
        }
        fputcsv($fp, $list);
    }
    exit();
}

/**
 * 读取csv文件转换成数组
 * @param string $csv
 * @return array
 * @date 2020/8/21 16:11
 */
function csv_to_array($csv=''){
    setlocale(LC_ALL, 'zh_CN');
    set_time_limit(0);
    $data = [];
    $fs = fopen($csv,'r');
    $i = 0;
    while ($row = fgetcsv($fs)) {
        $i += 1;
        if($i == 1) continue;
        foreach($row as &$value) {
            $value = iconv('GBK', 'UTF-8', $value);
        }
        $data[] = $row;
    }
    fclose($fs);
    @unlink($csv);
    return $data;
}

/**
 * 获得当前完整URL
 * @return string
 */
function url_current() {
    $redirect_uri = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $redirect_uri;
}

/**
 * 获取redis对象实例
 * @return Redis
 * @date 2020/6/4 14:04
 */
function redis_instance() {
    global $redis;
    if($redis) return $redis;
    $config = config('redis');
    $redis  = new \Redis();
    $redis->connect($config['redis_host'], $config['redis_port']);
    $redis->auth($config['redis_pass']);
    $redis->select($config['redis_index']);
    return $redis;
}

/**
 * redis锁
 * @param $lock
 * @param $param
 * @param $func
 * @param int $ttl
 * @date 2020/8/17 15:31
 */
function redis_lock($lock, $param, $func, $ttl=15) {
    $redis = redis_instance();
    $res   = $redis->setnx($lock, '1');
    if(!$res) json_response(0, '请求过快，请稍后再试哦~');
    $redis->expire($lock, $ttl);
    $result = $func($param, $redis);
    if($result) $redis->del($lock);
}

/**
 * 计算分页
 * @param int $page 页码
 * @param int $limit 每页展示条数
 * @return string
 * @date 2020/6/15 16:29
 */
function paginator($page=0, $limit=0) {
    if(empty($page))  $page  = param_check('page', 1);
    if(empty($limit)) $limit = param_check('limit', 15);
    return ($page - 1) * $limit . ',' . $limit;
}

/**
 * aes加密数据
 * @param string $data 加密前的字符串
 * @param string $key key
 * @param string $iv iv
 * @param string $method 加密方法
 * @return string
 * @date 2020/6/22 15:38
 *
 */
function aes_encrypt($data='', $key='', $iv='', $method='AES-128-ECB') {
    return openssl_encrypt($data, $method, $key, 0, $iv);
}

/**
 * aes解密
 * @param string $data 加密前的字符串
 * @param string $key key
 * @param string $iv iv
 * @param string $method 加密方法
 * @return string
 * @date 2020/6/22 15:40
 */
function aes_decrypt($data='', $key='', $iv='', $method='AES-128-ECB') {
    return openssl_decrypt($data, $method, $key, 0, $iv);
}