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
        $len = count($data);
        if ($len > 1) {
            $isSort = true;  //标识是否已经排好序
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
        $len = count($data);
        if ($len > 1){
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
        $len = count($data);
        if ($len > 1){
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
        $len = count($data);
        if ($len > 1){
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


    /**
     * @param array $data
     * @return array
     *
     * 快速排序
     */
    // 快速排序方式一 以增加辅助空间为代价
    static public function quick(array $data){
        $len = count($data);
        if($len > 1){
            $left = array();
            $right = array();
            $midVal = $data[0];unset($data[0]);
            foreach ($data as $v){
                if($v < $midVal){
                    array_push($left, $v);
                }else{
                    array_push($right, $v);
                }
            }

            $data = array_merge(self::quick($left),(array)$midVal,self::quick($right));
        }

        return $data;
    }

    // 快速排序方式二  没有用到辅助空间递归方式
    static public function quick_two(array &$data, $low=false, $high=false){
        $len = count($data);
        if($len > 1) {
            if ($low === false) $low = 0;
            if ($high === false) $high = $len-1;
            if($low < $high) {
                $tmp = self::quick_partition($data, $low, $high);
                self::quick_two($data, $low, $tmp - 1);
                self::quick_two($data, $tmp + 1, $high);
            }
        }
    }

    // 快速排序划分
    static private function quick_partition(&$data, $low, $high){
        $midVal = $data[$low];

        while ($low < $high){
            while ($low < $high && $data[$high] >= $midVal) $high--;
            $data[$low] = $data[$high];
            while ($low < $high && $data[$low] <= $midVal) $low++;
            $data[$high] = $data[$low];
        }

        //$data[$high] = $midVal;
        $data[$low] = $midVal;

        return $low;
    }


    // 快速排序方式三  没有用到辅助空间堆栈方式
    static public function quick_three(&$data){
        $len = count($data);
        $stack = array();
        if($len > 1){
            $tmp = self::quick_partition($data,0,$len-1);
            array_push($stack, array(0,$tmp-1));
            array_push($stack, array($tmp+1,$len-1));
        }

        while ($stack){
            $node = array_pop($stack);
            $tmp = self::quick_partition($data,$node[0],$node[1]);
            if($node[0] < $tmp-1){
                array_push($stack,array($node[0], $tmp-1));
            }
            if($tmp+1 < $node[1]){
                array_push($stack,array($tmp+1, $node[1]));
            }
        }
    }

}