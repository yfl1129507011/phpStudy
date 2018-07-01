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
    // 事务状态
    private $transStatus = false;
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
                throw new \Exception( $error[1].':'.$error[2]);
                return false;
            }else {
                $result = $PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            }
        }catch (\PDOException $e){
            $e->errorInfo();
            throw new \Exception( $error[1].':'.$error[2]);
            return false;
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