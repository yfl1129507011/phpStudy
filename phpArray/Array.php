<?php
/**
 * Created by PhpStorm.
 * User: yangfeilong
 * Date: 2018/5/14
 * Time: 23:47
 */

# php中常见的数组函数

/**
 * 将一个数组分割成多个
 * array array_chunk(array $input, int $size [, bool $preserve_keys = false])
 */
$input = array('a', 'b', 'c', 'd', 'e');
# 例子1
$chunk_1 = array_chunk($input, 3);
/*Array
(
    [0] => Array
        (
            [0] => a
            [1] => b
            [2] => c
        )

    [1] => Array
        (
            [0] => d
            [1] => e
        )

)*/
# 例子2
$chunk_2 = array_chunk($input, 3, true);
/*Array
(
    [0] => Array
        (
            [0] => a
            [1] => b
            [2] => c
        )

    [1] => Array
        (
            [3] => d
            [4] => e
        )

)*/


/***
 * 返回数组中指定的列
 * array array_column(array $input, mixed $column_key [, mixed $index_key])
 */
$records = array(
    array(
        'id' => 2135,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ),
    array(
        'id' => 3245,
        'first_name' => 'Sally',
        'last_name' => 'Smith',
    ),
    array(
        'id' => 5342,
        'first_name' => 'Jane',
        'last_name' => 'Jones',
    ),
    array(
        'id' => 5623,
        'first_name' => 'Peter',
        'last_name' => 'Doe',
    )
);
# 例子1
$column_1 = array_column($records, 'first_name');
/*Array
(
    [0] => John
    [1] => Sally
    [2] => Jane
    [3] => Peter
)*/
# 例子2
$column_2 = array_column($records, 'first_name', 'id');
/*Array
(
    [2135] => John
    [3245] => Sally
    [5342] => Jane
    [5623] => Peter
)*/

/**
 * 用给定的值填充数组
 * array array_fill(int $start_index, int $num, mixed $value)
 */
# 例子1
$fill_1 = array_fill(0, 5, 'fenlon');
/*Array
(
    [0] => fenlon
    [1] => fenlon
    [2] => fenlon
    [3] => fenlon
    [4] => fenlon
)*/
# 例子2
$fill_2 = array_fill(5, 6, '925');
/*Array
(
    [5] => 925
    [6] => 925
    [7] => 925
    [8] => 925
    [9] => 925
    [10] => 925
)*/

/**
 * 建立一个包含指定范围单元的数组
 * array range(mixed $start, mixed $limit, [, number $step = 1])
 */
# 例子1
$range_1 = range(1, 5);
/*Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [3] => 4
    [4] => 5
)*/
# 例子2
$range_2 = range(0, 100, 20);
/*Array
(
    [0] => 0
    [1] => 20
    [2] => 40
    [3] => 60
    [4] => 80
    [5] => 100
)*/

/**
 * 计算数组的差集, 可以传递多个数组
 * array array_diff(array $array1, array $array2 [, array $...])
 */
$array1 = array("a" => "green", "red", "blue", "red");
$array2 = array("b" => "green", "yellow", "red");
# 例子1
$diff_1 = array_diff($array1, $array2);
/*Array
(
    [1] => blue
)*/
# 例子2
$diff_2 = array_diff($array2, $array1);
/*Array
(
    [0] => yellow
)*/

/**
 * 计算数组的交集, 可以传递多个数组
 * array array_intersect(array $array1, array $array2 [, array $...])
 */
$array1 = array("a" => "green", "red", "blue", "red");
$array2 = array("b" => "green", "yellow", "red");
# 例子1
$intersect_1 = array_intersect($array1, $array2);
/*Array
(
    [a] => green
    [0] => red
    [2] => red
)*/
# 例子2
$intersect_2 = array_intersect($array2, $array1);
/*Array
(
    [b] => green
    [1] => red
)*/

/**
 * 检查给定的键名或索引是否存在于数组中
 * bool array_key_exists(mixed $key, array $search)
 */
$search_array = array('first' => 1, 'second' => 4);
$key_exists_1 = array_key_exists('first', $search_array);  # true
$key_exists_2 = array_key_exists('five', $search_array);  # false

/**
 * 返回数组部分或全部的键值
 * array array_keys(array $array [, mixed $search [, bool $strict = false]])
 */
# 例子1
$array = array(0 => 100, "color" => "red");
$keys_1 = array_keys($array);
/*Array
(
    [0] => 0
    [1] => color
)*/
# 例子2
$array = array("blue", "red", "green", "blue", "blue");
$keys_2 = array_keys($array, 'blue');
/*Array
(
    [0] => 0
    [1] => 3
    [2] => 4
)*/
# 例子3
$array = array(
    "color" => array("blue", "red", "green"),
    "size"  => array("small", "medium", "large")
);
$keys_3 = array_keys($array);
/*Array
(
    [0] => color
    [1] => size
)*/

/**
 * 将回调函数作用到给定数组的单元上
 * array array_map(callable $callback, array $arr1 [, array $...])
 */
$func = function ($v){
    return $v * 2;
};
$map_1 = array_map($func, range(1,5));
/*Array
(
    [0] => 2
    [1] => 4
    [2] => 6
    [3] => 8
    [4] => 10
)*/
$a = array(1, 2, 3, 4, 5);
$b = array("uno", "dos", "tres", "cuatro", "cinco");
function map_spanish($n, $m){
    return (array($n => $m));
}
$map_2 = array_map('map_spanish', $a, $b);
/*Array
(
    [0] => Array
    (
        [1] => uno
    )

    [1] => Array
    (
        [2] => dos
    )

    [2] => Array
    (
        [3] => tres
    )

    [3] => Array
    (
        [4] => cuatro
    )

    [4] => Array
    (
        [5] => cinco
    )
)*/

$a = array(1, 2, 3, 4, 5);
$b = array("one", "two", "three", "four", "five");
$c = array("uno", "dos", "tres", "cuatro", "cinco");
$map_3 = array_map(null, $a, $b, $c);
/*Array
(
    [0] => Array
    (
        [0] => 1
        [1] => one
        [2] => uno
    )
    [1] => Array
    (
        [0] => 2
        [1] => two
        [2] => dos
    )
    [2] => Array
    (
        [0] => 3
        [1] => three
        [2] => tres
    )
    [3] => Array
    (
        [0] => 4
        [1] => four
        [2] => cuatro
    )
    [4] => Array
    (
        [0] => 5
        [1] => five
        [2] => cinco
    )
)*/
echo '<pre>';
print_r($map_3);