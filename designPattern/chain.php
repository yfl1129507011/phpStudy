<?php
/**
 * Created by PhpStorm.
 * User: yfl
 * Date: 2018/9/10
 * Time: 15:37
 *
 * 责任链模式
 */

# 底层链
class Chain {
    // 级别标识
    private $level = 1;
    // 上级类名
    private $top = 'Leader';

    public function process($level){
        if($this->level == $level){
            echo '底层处理'.PHP_EOL;
        }else{
            (new $this->top)->process($level);
        }
    }
}

# 领导
class Leader {
    private $level = 2;
    private $top = 'Boss';

    public function process($level){
        if($this->level == $level){
            echo '领导处理'.PHP_EOL;
        }else{
            (new $this->top)->process($level);
        }
    }
}

# 老板
class Boss {
    private $level = null;
    private $top = null;
    public function process($level){
        echo '老板处理'.PHP_EOL;
    }
}

$chain = new Chain();
$level = mt_rand(1,3);
$chain->process($level);