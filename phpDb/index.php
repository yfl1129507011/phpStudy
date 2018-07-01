<?php
/**
 * Created by PhpStorm.
 * User: hylanda69874
 * Date: 2018/6/20
 * Time: 11:26
 */
namespace phpDb;

$config = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '123456',
    'database' => 'zhongmiao',
    'port' => '',
);
/*include('mysqli.php');
$mysql = new Mysqli($config);
$res = $mysql->query("SELECT * FROM `zm_user_visit_log` LIMIT 5;");
var_dump($res);*/

/*$db = new \mysqli('localhost', 'root', '123456', 'zhongmiao', 3306);
$sql = "SELECT * FROM `zm_user_visit_log` LIMIT 5;";
$queryID = $db->query($sql);
var_dump($queryID->num_rows);die;
$res = $queryID->fetch_assoc();
//$queryID->free_result();
var_dump($res);
$res = $queryID->fetch_assoc();
var_dump($res);*/

$db = new \PDO('mysql:host=localhost;dbname=fenlon;port=3306','root','123456');
/*$stmt = $db->prepare("SELECT * FROM `users` LIMIT 5");
$stmt->execute();
$res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
var_dump($res);*/

/*$stmt = $db->prepare("insert `users` (username, password) values (:name, :password)");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':password', $password);

$name = 'fenlon';
$password = 'md5("fenlon")';
$stmt->execute();

$name = 'messi';
$password = 'md5("messi")';
$stmt->execute();*/

$stmt = $db->prepare("insert `users` (username, password) values (?, ?)");
$stmt->bindParam(1, $name);
$stmt->bindParam(2, $password);
$name = 'one';
$password = '123456';
/*$stmt->bindValue(1,'three');
$stmt->bindValue(2,'abcdefg');*/
$stmt->execute();
var_dump($db->lastInsertId());
var_dump($stmt->rowCount());