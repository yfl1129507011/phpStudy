<?php
/**
 * Created by PhpStorm.
 * User: yfl
 * Date: 2018/6/24
 * Time: 16:45
 */
namespace phpDb;

class Pdo {
    // 当前数据库操作对象
    private $db = null;
    // 当前执行的SQL语句
    private $queryStr   = '';
    // 最后插入ID
    private $lastInsID  = null;
    private $error      = '';

    // PDO连接参数
    protected $options = array(
        \PDO::ATTR_CASE => \PDO::CASE_LOWER,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_ORACLE_NULLS => \PDO::NULL_NATURAL,
        \PDO::ATTR_STRINGIFY_FETCHES => false,
    );

    /**
     * 解析pdo连接的dsn信息
     * @param $config
     * @return string
     */
    protected function parseDsn($config){
        $dsn = 'mysql:dbname=' . $config['database'] . ';host=' . $config['hostname'];
        if(!empty($config['port'])){
            $dsn .= ';port=' . $config['port'];
        }
        if(!empty($config['charset'])){
            $dsn .= ';charset=' . $config['charset'];
        }

        return $dsn;
    }

    public function __construct($config)
    {
        try{
            if(empty($config['dsn'])){
                $config['dsn'] = $this->parseDsn($config);
            }
            if(version_compare(PHP_VERSION, '5.3.6', '<=')){
                // 禁用模拟预处理语句
                $this->options[\PDO::ATTR_EMULATE_PREPARES] = false;
            }
            $this->db = new \PDO($config['dsn'], $config['username'], $config['password'], $this->options);
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }

        // 设置字符编码
        $this->db->exec('SET NAMES UTF8');
    }

    /**
     * 执行查询 返回数据集
     * @param $str
     * @param array $bind
     * @return array|bool
     * @throws \Exception
     *
     * egg:
     * $str =  "select `username`, `password` from `user` where `username`=:name and `password`=:password)"
     * $str =  "insert into user (username, password) values (:name, :password)"
     * $bind = array(
     *      ':name' => 'fenlen',
     *      ':password' => array('123456',\PDO::PARAM_STR),
     * )
     * query($str, $bind)
     *
     */
    public function query($str, $bind=array()){
        if(!$this->db) return false;
        $this->queryStr = $str;
        if(!empty($bind)){
            $that = $this;
            $this->queryStr = strtr($this->queryStr,
                array_map(function($val) use($that) {
                    return '\''.$that->escapeString($val).'\'';
                }, $bind)
            );
        }
        $PDOStatement = $this->db->prepare($str);
        if(false === $PDOStatement){
            return false;
        }
        foreach($bind as $k=>$v){
            // 参数绑定
            if(is_array($v)){
                $PDOStatement->bindValue($k, $v[0], $v[1]);
            }else{
                $PDOStatement->bindValue($k, $v);
            }
        }
        try{
            $result = $PDOStatement->execute();
            if(false === $result){
                $error = $PDOStatement->errorInfo();
                $this->error =  $error[1].':'.$error[2];
                return false;
            }else {
                // 返回所有结果
                $result = $PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            }
        }catch (\PDOException $e){
            $error = $e->errorInfo();
            $this->error =  $error[1].':'.$error[2];
            throw new \Exception( $error[1].':'.$error[2]);
            return false;
        }
    }

    public function execute($str, $bind=array()){
        if(!$this->db) return false;
        $this->queryStr = $str;
        $PDOStatement = $this->db->prepare($str);
        if(false === $PDOStatement){
            return false;
        }
        foreach($bind as $k=>$v){
            // 参数绑定
            if(is_array($v)){
                $PDOStatement->bindValue($k, $v[0], $v[1]);
            }else{
                $PDOStatement->bindValue($k, $v);
            }
        }
        $result = $PDOStatement->execute();
        if(false === $result){
            $error = $PDOStatement->errorInfo();
            $this->error =  $error[1].':'.$error[2];
            return false;
        }else{
            if(preg_match("/^\s*(INSERT\s+INTO|REPLACE\s+INTO)\s+/i", $str)) {
                $this->lastInsID = $this->db->lastInsertId();
            }
            return $PDOStatement->rowCount();
        }
    }

    /**
     * SQL指令安全过滤
     * @access public
     * @param string $str  SQL字符串
     * @return string
     */
    public function escapeString($str) {
        return addslashes($str);
    }
}