<?php
/**
 * Created by PhpStorm.
 * User: hylanda69874
 * Date: 2018/6/19
 * Time: 18:46
 * Mysqli数据库驱动类
 */
namespace phpDb;

class Mysqli {
    // 当前数据库操作对象
    private $db = null;
    // 当前执行的SQL语句
    private $queryStr   = '';
    // 最后插入ID
    private $lastInsID  = null;
    // 事务状态
    private $transStatus = false;
    private $error      = '';

    public function __construct($config)
    {
        if(!extension_loaded('mysqli')){
            throw new \Exception('not support mysqli');
        }
        $this->db = new \mysqli($config['hostname'], $config['username'], $config['password'], $config['database'], $config['port']?intval($config['port']):3306);
        if(mysqli_connect_error()){
            throw new \Exception(mysqli_connect_error());
        }

        // 设置数据库编码
        $dbCharset = isset($config['charset'])?$config['charset']:'utf8';
        $this->db->query("SET NAMES '".$dbCharset."'");
    }

    /**
     * 执行查询 返回数据集
     * @param $str
     * @return array|bool
     */
    public function query($str){
        if(!$this->db) return false;
        $this->queryStr = $str;
        // 执行SQL语句
        $queryID = $this->db->query($str);
        if(false === $queryID || $queryID->num_rows){
            return false;
        }else{
            $result = array();
            for($i=0; $i<$queryID->num_rows; $i++){
                // 一条条获取数据
                $result[$i] = $queryID->fetch_assoc();
            }
            // 调整结果指针到第一行
            $queryID->data_seek(0);
            // 释放结果集
            $queryID->free_result();
            return $result;
        }
    }

    /**
     * 执行语句
     * @param $str
     * @return bool|int
     */
    public function execute($str){
        if(!$this->db) return false;
        $this->queryStr = $str;
        $result = $this->db->query($str);
        if(false === $result){
            return false;
        }else{
            $this->lastInsID = $this->db->insert_id;
            // 返回影响的记录数
            return $this->db->affected_rows;
        }
    }

    /**
     * 启动事务
     */
    public function startTrans(){
        if(false === $this->transStatus){
            // 关闭自动提交功能
            $this->db->autocommit(false);
        }
        $this->transStatus = true;
        return ;
    }

    /**
     * 事务提交
     * @return bool
     */
    public function commit(){
        if(true === $this->transStatus){
            $result = $this->db->commit();
            $this->db->autocommit(true);
            $this->transStatus = false;
            if(!$result){
                return false;
            }
        }
        return true;
    }

    /**
     * 事务回滚
     * @return bool
     */
    public function rollback(){
        if(true === $this->transStatus){
            $result = $this->db->rollback();
            $this->db->autocommit(true);
            $this->transStatus = false;
            if(!$result){
                return false;
            }
        }
        return true;
    }

    /**
     * 获取最近一次查询的sql语句
     * @access public
     * @return string
     */
    public function getLastSql() {
        return $this->queryStr;
    }

    /**
     * 获取最近插入的ID
     * @access public
     * @return string
     */
    public function getLastInsID() {
        return $this->lastInsID;
    }

    /**
     * 获取最近的错误信息
     * @access public
     * @return string
     */
    public function getError() {
        return $this->error;
    }

    /**
     * SQL指令安全过滤
     * @param $str
     * @return string
     */
    public function escapeString($str){
        if($this->db){
            return $this->db->real_escape_string($str);
        }else {
            return addslashes($str);
        }
    }

    public function __destruct()
    {
        if($this->db){
            $this->db->close();
        }
        $this->db = null;
    }
}