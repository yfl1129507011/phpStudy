<?php
/**
 * Created by PhpStorm.
 * User: yangfeilong
 * Date: 2018/3/26
 * Time: 22:10
 *
 * php排序算法
 *
 */

class Sort {

    /**
     * @param array $data
     * @return array
     *
     * 冒泡排序
     */
    static public function bubble(array $data){
        if (!empty($data)) {
            $isSort = true;  //标识是否已经排好序
            $len = count($data);
            while ($len--) {
                for ($i = 0; $i < $len; $i++) {
                    if ($data[$i] > $data[$i + 1]) {
                        $isSort = false;  //表示没有排好序
                        list($data[$i], $data[$i + 1]) = array($data[$i + 1], $data[$i]);
                    }
                }

                if ($isSort) break;
                else $isSort = true;  // 状态还原
            }
        }

        return $data;
    }


    /**
     * @param array $data
     * @return array
     *
     * 插入排序
     */
    // 直接插入排序
    static public function directInsert(array $data){
        if (!empty($data)){
            $len = count($data);

            for ($i=1; $i<$len; $i++){
                $inx = $data[$i];  //要插入的数据
                $j = $i;
                while ($j--){
                    if ($inx < $data[$j]){
                        $data[$j+1] = $data[$j];  //往右偏移
                    } else {
                        break;  // 表明要插入的数据在已经排好序中最大
                    }
                }
                $data[$j+1] = $inx;
            }
        }

        return $data;
    }

    // 二分插入排序
    static public function binaryInsert(array $data){
        if (!empty($data)){
            $len = count($data);
            for ($i=1; $i<$len; $i++){
                $inx = $data[$i];
                $low = 0;
                $high = $i-1;
                while ($low <= $high){
                    $mid = floor(($low+$high)/2);
                    if($inx < $data[$mid]){
                        $high = $mid-1;
                    }else{
                        $low = $mid+1;
                    }
                }

                for ($j=$i; $j>$low; $j--){
                    $data[$j] = $data[$j-1];
                }

                $data[$low] = $inx;
            }
        }
        return $data;
    }


    /**
     * @param array $data
     * @return array
     *
     * 选择排序
     */
    static public function selection(array $data){
        if (!empty($data)){
            $len = count($data);
            for ($i=0; $i<$len; $i++){
                for ($j=$i+1; $j<$len; $j++){
                    if($data[$i] > $data[$j]){
                        list($data[$i],$data[$j]) = array($data[$j],$data[$i]);
                    }
                }
            }
        }

        return $data;
    }
}