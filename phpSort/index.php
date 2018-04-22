<?php
/**
 * Created by PhpStorm.
 * User: yangfeilong
 * Date: 2018/3/26
 * Time: 22:03
 *
 */

require 'Sort.php';

$list = [2,3,1,6,8,4,9,0,7,3,-1,5,10,0,5,-3];

var_dump($list);


// 冒泡
/*$list = \phpSort\Sort::bubble($list);
var_dump($list);*/

// 插入
//$list = \phpSort\Sort::binaryInsert($list);  // 二分插入排序
//$list = \phpSort\Sort::directInsert($list);  // 直接插入排序

// 选择排序
//$list = \phpSort\Sort::selection($list);

// 快速排序
//$list = \phpSort\Sort::quick($list);
//\phpSort\Sort::quick_two($list);
\phpSort\Sort::quick_three($list);
var_dump($list);
