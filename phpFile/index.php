<?php
/**
 * Created by PhpStorm.
 * User: yfl
 * Date: 2018/4/22
 * Time: 16:17
 */
namespace phpFile;

include 'File.php';
include 'CacheFile.php';
$path = 'book.txt';
//$data = File::readFileByLine($path);
/*$iterator = File::readFileByYield($path);
foreach($iterator as $iteration){
    echo $iteration.'<br/>';
}*/

//$res = File::writeFile('fenlon', $path);

$cache = new CacheFile();

//$cache->set('name', 'fenlon');
var_dump($cache->get('name'));

print(File::formatBytes(memory_get_peak_usage()));