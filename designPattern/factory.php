<?php
/**
 * Created by PhpStorm.
 * User: yfl
 * Date: 2018/9/10
 * Time: 14:17
 * 工厂模式
 */

# 接口
interface Db{
    public function connect();
}

class Mysql implements Db{
    public function connect()
    {
        // TODO: Implement connect() method.
        echo 'connect mysql service'.PHP_EOL;
    }
}

class Sqlsrv implements Db{
    public function connect()
    {
        // TODO: Implement connect() method.
        echo 'connect SQLserver service'.PHP_EOL;
    }
}

# 工厂类
class Factory {
    public static function getDb($type){
        try{
            $type = ucfirst($type);
            if(!class_exists($type)){
                throw new Exception('Error:['.$type.'] classname is not exists!');
            }
            return new $type;
        } catch(Exception $e){
            echo $e->getMessage();die;
        }
    }
}

$db = Factory::getDb('mysql');
$db->connect();
$db = Factory::getDb('sqlsrv');
$db->connect();
$db = Factory::getDb('oracle');
$db->connect();
