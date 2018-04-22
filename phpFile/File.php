<?php
/**
 * Created by PhpStorm.
 * User: yfl
 * Date: 2018/4/22
 * Time: 11:07
 */
namespace phpFile;

class File {
    /**
     * @param $path  读取的文件路径
     * @return array
     *
     * 逐行读取文件
     */
    static public function readFileByLine($path){
        $lines = array();
        if(is_file($path)) {
            $fh = fopen($path, 'r');
            while (!feof($fh)) {
                $lines[] = trim(fgets($fh));
            }
            fclose($fh);
        }
        return $lines;
    }

    /**
     * @param $path
     * @return \Generator
     *
     * 通过生成器逐行读取文件
     */
    static public function readFileByYield($path){
        if(is_file($path)){
            $fh = fopen($path, 'r');
            while(!feof($fh)){
                yield trim(fgets($fh));
            }
            fclose($fh);
        }
    }

    /**
     * @param $source
     * @param $dest
     * 通过流式方式拷贝文件
     * @return bool
     */
    static public function copyFile($source,$dest){
        if(is_file($source)){
            $fh_s = fopen($source, 'r');
            $fh_d = fopen($dest, 'w');
            stream_copy_to_stream($fh_s,$fh_d);
            fclose($fh_s);
            fclose($fh_d);
            return true;
        }

        return false;
    }

    /**
     * @param $dir
     * @param int $level
     * @return mixed
     *
     * 遍历一个目录并返回文件信息
     */
    static public function scan_dir($dir, $level=0){
        static $dirArr = array();
        $finfo = new \finfo(FILEINFO_MIME);
        $fileInfo = array();
        $fileInfo['name'] = basename($dir);
        is_file($dir) && $fileInfo['size'] = self::formatBytes(filesize($dir));   // 文件大小
        $fileInfo['atime'] = date('Y-m-d H:i:s', fileatime($dir));   // 文件上次修改时间
        $fileInfo['inode'] = fileinode($dir);   // 文件inode号
        $fileInfo['ctime'] = date('Y-m-d H:i:s', filectime($dir));   // 文件修改时间
        $fileInfo['mime'] = $finfo->file($dir);
        $fileInfo['dir'] = dirname($dir);
        $dirArr[$fileInfo['dir']][] = $fileInfo;
        $dirArr[$fileInfo['dir']]['level'] = $level;

        if(is_dir($dir)){
            $dh = opendir($dir);
            while(false !== ($filename = readdir($dh))){
                if(in_array($filename, ['.','..'])) continue;
                self::scan_dir($dir.DIRECTORY_SEPARATOR.$filename, $dirArr[dirname($dir)]['level']+1);
            }
        }

        return $dirArr;
    }

    /**
     * @param $bytes
     * @param int $precision
     * @return string
     * 显示格式化的字节大小
     */
    static public function formatBytes($bytes, $precision=2){
        $units = array('b','kb','mb','gb','tb');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes?log($bytes):0)/log(1024));
        $pow = min($pow, count($units)-1);
        $bytes /= (1<<(10*$pow));
        return round($bytes, $precision).''.$units[$pow];
    }

}