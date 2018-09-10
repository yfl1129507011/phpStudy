<?php
/**
 * Created by PhpStorm.
 * User: yfl
 * Date: 2018/9/10
 * Time: 13:58
 * 单例模式
 */

class Single {
    private static $instance = null;

     final protected function __construct(){}

    private function __clone(){}

    public static function getInstance(){
        /*if(!self::$instance instanceof self){
            self::$instance = new self;
        }*/
        if(!self::$instance instanceof static){
            self::$instance = new static;
        }

        return self::$instance;
    }
}

class A extends Single {
}

$s1 = A::getInstance();
var_dump($s1);
$s2 = Single::getInstance();
var_dump($s2);
$s3 = A::getInstance();
var_dump($s3);