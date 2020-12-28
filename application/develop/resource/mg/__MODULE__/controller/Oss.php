<?php


namespace app\__MODULE__\controller;


use OSS\OssClient;

// 阿里云oss上传服务
class Oss
{
    /**
     * OSS单文件上传
     */
    public function upload_file() {
        try {
            if(empty($_FILES['file'])) json_response(1, '文件不能为空');
            // 多文件上传
            if(is_array($_FILES['file']['name'])) {
                $file_list = [];
                foreach ($_FILES['file'] as $key=>$item) {
                    for($i=0; $i<count($item); $i++) {
                        $file_list[$i][$key] = $item[$i];
                        if($key == 'size' && $item[$i] > 1024*1024*2) {
                            json_response(1, '最大上传2M');
                        }
                    }
                }
                $config = config('oss');
                $ossClient = new OssClient($config['access_key_id'], $config['access_key_secret'], $config['upload_url'], false);
                $src_list = [];
                foreach ($file_list as $file) {
                    $arr = explode('.', $file['name']);
                    $ext = count($arr) > 1 ? end($arr) : '';
                    $save_name = $config['static_path'].'/'.date('Ymd').'/'.time().uniqid().(empty($ext) ? '' : ".{$ext}");
                    $res = $ossClient->uploadFile($config['bucket_name'], $save_name, $file['tmp_name']);
                    // 删除临时文件
                    @unlink($file);
                    $src_list[] = $config['static_url'].'/'.$save_name;
                }
                json_response(0, '上传成功', [
                    'src' => $src_list
                ]);
            }else { // 单文件上传
                if($_FILES['file']['size'] > 1024*1024*200) json_response(1, '最大上传2M');
                $file = $_FILES['file']['tmp_name'];
                // 开始上传
                $config = config('oss');
                $ossClient = new OssClient($config['access_key_id'], $config['access_key_secret'], $config['upload_url'], false);
                $arr = explode('.', $_FILES['file']['name']);
                $ext = count($arr) > 1 ? end($arr) : '';
                $save_name = $config['static_path'].'/'.date('Ymd').'/'.time().uniqid().(empty($ext) ? '' : ".{$ext}");
                $res = $ossClient->uploadFile($config['bucket_name'], $save_name, $file);
                // 删除临时文件
                @unlink($file);
                if(!empty($res['info']['url'])) {
                    json_response(0, '上传成功', [
                        'src' => $config['static_url'].'/'.$save_name
                    ]);
                }else {
                    json_response(1, '上传失败');
                }
            }
        }catch (\Exception $e) {
            dump(config('oss'));
            json_response(1, '上传失败');
        }
    }

    /**
     * 读取网络图片并存储到OSS
     * @param string $url
     * @param string $ext
     * @return string
     * @throws \OSS\Core\OssException
     * @date 2020/6/3 18:13
     */
    public function read_img_save($url='', $ext='png') {
        $img = chunk_split(base64_encode(file_get_contents($url)));
        $img = str_replace(" ", '+', $img);
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace('data:image/jpg;base64,', '', $img);
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = base64_decode($img);
        $config = config('oss');
        $ossClient = new OssClient($config['access_key_id'], $config['access_key_secret'], $config['upload_url'], false);
        $save_name = $config['static_path'].'/'.date('Ymd').'/'.time().uniqid().(empty($ext) ? '' : ".{$ext}");
        $res = $ossClient->putObject($config['bucket_name'], $save_name, $img);
        return $config['static_url'].'/'.$save_name;
    }

    /**
     * 百度编辑器上传
     * @date 2020/6/10 16:41
     */
    public function editor_upload() {
        $response = [
            'state'    => 'SUCCESS',
            'url'      => '',
            'title'    => '',
            'original' => '',
            'type'     => '',
            'size'     => ''
        ];
        $action = empty($_GET['action']) ? 'config' : $_GET['action'];
        if($action == 'config') {
            $url = app()->env->get('resource_url').'ueditor/php/config.json';
            if(!file_exists($url)) $url = 'https://sx100.gongyiweilai.org.cn/backend/good100/public/static/resource/ueditor/php/config.json';
            exit(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($url)));
        }else if($action == 'uploadimage') {
            // {"state":"SUCCESS","url":"\/ueditor\/php\/upload\/image\/20200610\/1591781657896167.png","title":"1591781657896167.png","original":"default.png","type":".png","size":5327}
            $key = 'upfile';
            if($_FILES[$key]['size'] > 1024*1024*2) json_response(1, '最大上传2M');
            $file = $_FILES[$key]['tmp_name'];
            // 开始上传
            $config = config('oss');
            $ossClient = new OssClient($config['access_key_id'], $config['access_key_secret'], $config['upload_url'], false);
            $arr = explode('.', $_FILES[$key]['name']);
            $ext = count($arr) > 1 ? end($arr) : '';
            $save_name = $config['static_path'].'/'.date('Ymd').'/'.time().uniqid().(empty($ext) ? '' : ".{$ext}");
            $res = $ossClient->uploadFile($config['bucket_name'], $save_name, $file);
            // 删除临时文件
            @unlink($file);
            if(!empty($res['info']['url'])) {
                $response['url']    = $config['static_url'].'/'.$save_name;
            }else {
                $response['state'] = '上传失败';
            }
        }else if($action == 'uploadvideo') {
            $key = 'upfile';
            if($_FILES[$key]['size'] > 1024*1024*16) json_response(1, '最大上传16M');
            $file = $_FILES[$key]['tmp_name'];
            // 开始上传
            $config = config('oss');
            $ossClient = new OssClient($config['access_key_id'], $config['access_key_secret'], $config['upload_url'], false);
            $arr = explode('.', $_FILES[$key]['name']);
            $ext = count($arr) > 1 ? end($arr) : '';
            $save_name = $config['static_path'].'/'.date('Ymd').'/'.time().uniqid().(empty($ext) ? '' : ".{$ext}");
            $res = $ossClient->uploadFile($config['bucket_name'], $save_name, $file);
            // 删除临时文件
            @unlink($file);
            if(!empty($res['info']['url'])) {
                $response['url']    = $config['static_url'].'/'.$save_name;
            }else {
                $response['state'] = '上传失败';
            }
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 下载多个文件
     * @param array $file_list 一维数组 键值对是文件名=>文件地址
     * @date 2020/9/3 18:01
     */
    public function download_files($file_list) {
        // 设置临时内存大小
        ini_set('memory_limit', '500M');
        set_time_limit(0);
        $file_name = time().'.zip';
        $zip = new \ZipArchive();
        // 创建一个空ZIP文件
        if ($zip->open($file_name, \ZipArchive::CREATE) === TRUE) {
            foreach ($file_list as $key => $value) {
                if(is_numeric($key)) {
                    $name = $key.'.png';
                }else {
                    $name = $key;
                }
                $zip->addFromString($name , file_get_contents($value));
            }
            $zip->close();
            $fp = fopen($file_name,"r");
            $file_size = filesize($file_name);//获取文件的字节
            //下载文件需要用到的头
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length:".$file_size);
            Header("Content-Disposition: attachment; filename=$file_name");
            $buffer=1024; //设置一次读取的字节数，每读取一次，就输出数据（即返回给浏览器）
            $file_count=0; //读取的总字节数
            //向浏览器返回数据 如果下载完成就停止输出，如果未下载完成就一直在输出。根据文件的字节大小判断是否下载完成
            while(!feof($fp) && $file_count<$file_size){
                $file_con=fread($fp,$buffer);
                $file_count+=$buffer;
                echo $file_con;
            }
            fclose($fp);
            //下载完成后删除压缩包，临时文件夹
            if($file_count >= $file_size) {
                unlink($file_name);
            }
        }
        exit;
    }

    /**
     * base64上传
     * @param string $base64
     * @param string $ext
     * @return string
     * @throws \OSS\Core\OssException
     * @date 2020/8/10 18:37
     */
    public function base64_upload($base64='', $ext='.png') {
        if(empty($base64)) json_response(0, 'base64文件不能为空');
        $base64 = str_replace(" ", '+', $base64);
        $base64 = str_replace('data:image/jpeg;base64,', '', $base64);
        $base64 = str_replace('data:image/jpg;base64,', '', $base64);
        $base64 = str_replace('data:image/png;base64,', '', $base64);
        $base64 = base64_decode($base64);
        // 开始上传
        $config = config('oss');
        $ossClient = new OssClient($config['access_key_id'], $config['access_key_secret'], $config['upload_url'], false);
        $save_name = $config['static_path'].date('Ymd').'/'.time().uniqid().$ext;
        $res = $ossClient->putObject($config['bucket_name'], $save_name, $base64);
        if(!empty($res['info']['url'])) {
            return $config['static_url'].'/'.$save_name;
        }else {
            json_response(1, '上传失败');
        }
    }

}