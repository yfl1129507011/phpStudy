<?php
/**
 * Created by PhpStorm.
 * User: yfl
 * Date: 2018/9/10
 * Time: 15:55
 *
 * 策略模式
 */

# 计算机接口
interface Calc{
    public function handle($a, $b);
}

# 加法
class AddCalc implements Calc{
    public function handle($a, $b)
    {
        // TODO: Implement handle() method.
        return $a+$b;
    }
}

# 乘法
class MulCalc implements Calc{
    public function handle($a, $b)
    {
        // TODO: Implement handle() method.
        return $a*$b;
    }
}

# 计算机类

class Calculate {
    private $calc = null;
    public function __construct($op)
    {
        $op = ucfirst($op).'Calc';
        $this->calc = new $op;
    }

    public function handle($a, $b){
        return $this->calc->handle($a, $b);
    }
}

$calculate = new Calculate('add');
var_dump($calculate->handle(2,5));
$calculate = new Calculate('mul');
var_dump($calculate->handle(6,2));