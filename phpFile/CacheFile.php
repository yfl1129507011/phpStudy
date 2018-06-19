<?php
/**
 * Created by PhpStorm.
 * User: hylanda69874
 * Date: 2018/6/19
 * Time: 16:08
 * 文件缓存类
 */
namespace phpFile;

class CacheFile {
    private $tempDir = './Temp/';

    public function __construct()
    {
        if(!is_dir($this->tempDir)){
            mkdir($this->tempDir, 0755, true);
        }
    }

    public function filename($name){
        $filename = md5($name).'.php';
        return $this->tempDir.$filename;
    }

    /**
     * 读取缓存
     * @param $name
     * @return bool|mixed|string
     */
    public function get($name){
        $filename = $this->filename($name);
        if(!is_file($filename)){
            return false;
        }
        $content = file_get_contents($filename);
        if($content){
            $expire = (int) substr($content, 8, 12);
            if(0 != $expire && time() > filemtime($filename) + $expire){
                unlink($filename);
                return false;
            }
            $content = substr($content, 20, -3);
            $content = unserialize($content);
            return $content;
        }else{
            return false;
        }

    }

    /**
     * 写入缓存
     * @param $name  缓存变量名
     * @param $value  存储数据
     * @param int $expire  有效时间 0为永久
     * @return bool
     */
    public function set($name, $value, $expire=0){
        $expire = intval($expire);
        $filename = $this->filename($name);
        $data = serialize($value);
        $data = "<?php\n//" . sprintf('%012d', $expire) . $data . "\n?>";
        $res = file_put_contents($filename, $data);
        if($res){
            clearstatcache();
            return true;
        }else{
            return false;
        }
    }

    /**
     * 删除缓存
     * @param $name
     * @return bool
     */
    public function rm($name){
        return unlink($this->filename($name));
    }
}