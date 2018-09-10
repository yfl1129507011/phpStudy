<?php
/**
 * Created by PhpStorm.
 * User: yfl
 * Date: 2018/9/10
 * Time: 14:39
 * 迭代器模式
 */

class MyIterator implements Iterator {
    private $_items = array(1,2,3,4,5,6);
    private $index = 0;

    // 重置
    public function rewind()
    {
        // TODO: Implement rewind() method.
        $this->index = 0;
    }

    // 返回当前元素
    public function current()
    {
        // TODO: Implement current() method.
        return $this->_items[$this->index];
    }

    // 返回当前键
    public function key()
    {
        // TODO: Implement key() method.
        return $this->index;
    }

    // 移动下一个元素
    public function next()
    {
        // TODO: Implement next() method.
        ++$this->index;
    }

    // 检查当前元素是否有效
    public function valid()
    {
        // TODO: Implement valid() method.
        return isset($this->_items[$this->index]);
    }
}

$iterator = new MyIterator();
foreach ($iterator as $v){
    var_dump($v);
}