<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sql_parse
{
    /** 
     * 表名
     * @var string      $tableName     
     */
    private $tableName;
    
    /**
     * 数据库字符编码
     *
     * @var      string     $charset
     */
    private $dbCharset;
    
    /**
     * 表中字段列表
     * 
     * @var array $fields
     */
    private $fields = array();
    
    /**
     * 索引列表
     * 
     * @var array $indexes
     */
    private $indexes = array();
    
    
    public function __construct($tableName, $dbCharset, $fields, $indexes) 
    {
        $this->tableName = $tableName;
        $this->dbCharset = $dbCharset;
        $this->fields = $fields;
        $this->indexes = $indexes;
    }
    
    /**
     * 解析出CHANGE操作
     *
     * @param   string      $query_item     SQL查询项
     * @return  array       返回一个以CHANGE操作串和其它操作串组成的数组
     */
    public function parseChangeQuery($query)
    {
        $result = array('', $query);

        $matches = array();
        /* 第1个子模式匹配old_col_name，第2个子模式匹配column_definition，第3个子模式匹配new_col_name */
        $pattern = '/\s*CHANGE\s*`?(\w+)`?\s*`?(\w+)`?([^,(]+\([^,]+?(?:,[^,)]+)*\)[^,]+|[^,;]+)\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                /* 如果表中存在原列名 */
                if (in_array($matches[$i][1], $this->fields))
                {
                    $sql .= $matches[$i][0];
                }
                /* 如果表中存在新列名 */
                elseif (in_array($matches[$i][2], $this->fields))
                {
                    $sql .= 'CHANGE ' . $matches[$i][2] . ' ' . $matches[$i][2] . ' ' . $matches[$i][3] . ',';
                }
                else /* 如果两个列名都不存在 */
                {
                    $sql .= 'ADD ' . $matches[$i][2] . ' ' . $matches[$i][3] . ',';
                    $sql = preg_replace('/(\s+AUTO_INCREMENT)/i', '\1 PRIMARY KEY', $sql);
                }
            }
            $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
            $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//存储CHANGE操作，已过滤末尾的逗号
            $result[0] = $this->insertCharset($result[0]);//加入字符集设置
            $result[1] = preg_replace($pattern, '', $query);//存储其它操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1]: '';
        }
        
        return $result;
    }
    
    /**
     * 解析出DROP COLUMN操作
     *
     * @param   string      $query     SQL查询项
     * @return  array       返回一个以DROP COLUMN操作和其它操作组成的数组
     */
    public function parseDropColumnQuery($query)
    {
        $result = array('', $query);
        
        $matches = array();
        /* 子模式存储列名 */
        $pattern = '/\s*DROP(?:\s+COLUMN)?(?!\s+(?:INDEX|PRIMARY))\s*`?(\w+)`?\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                if (in_array($matches[$i][1], $this->fields))
                {
                    $sql .= 'DROP ' . $matches[$i][1] . ',';
                }
            }
            if ($sql)
            {
                $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
                $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//过滤末尾的逗号
            }
            $result[1] = preg_replace($pattern, '', $query);//过滤DROP COLUMN操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1] : '';
        }
    }
    
    /**
     * 解析出ADD [COLUMN]操作
     *
     * @param   string      $query     SQL查询项
     * @return  array       返回一个以ADD [COLUMN]操作和其它操作组成的数组
     */
    public function parseAddColumnQuery($query)
    {
        $result = array('', $query);
        
        $matches = array();
        /* 第1个子模式存储列定义，第2个子模式存储列名 */
        $pattern = '/\s*ADD(?:\s+COLUMN)?(?!\s+(?:INDEX|UNIQUE|PRIMARY))\s*(`?(\w+)`?(?:[^,(]+\([^,]+?(?:,[^,)]+)*\)[^,]+|[^,;]+))\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $mysql_ver = $this->db->version();
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                if (in_array($matches[$i][2], $this->fields))
                {
                    /* 如果为低版本MYSQL，则把非法关键字过滤掉 */
                    if  ($mysql_ver < '4.0.1' )
                    {
                        $matches[$i][1] = preg_replace('/\s*(?:AFTER|FIRST)\s*.*$/i', '', $matches[$i][1]);
                    }
                    $sql .= 'CHANGE ' . $matches[$i][2] . ' ' . $matches[$i][1] . ',';
                }
                else
                {
                    $sql .= 'ADD ' . $matches[$i][1] . ',';
                }
            }
            $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
            $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//过滤末尾的逗号
            $result[0] = $this->insertCharset($result[0]);//加入字符集设置
            $result[1] = preg_replace($pattern, '', $query);//过滤ADD COLUMN操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1] : '';
        }
        
        return $result;
    }
    
    /**
     * 解析出DROP INDEX操作
     *
     * @param   string      $query     SQL查询项
     * @return  array       返回一个以DROP INDEX操作和其它操作组成的数组
     */
    public function parseDropIndexQuery($query)
    {
        $result = array('', $query);
        
        /* 子模式存储键名 */
        $pattern = '/\s*DROP\s+(?:PRIMARY\s+KEY|INDEX\s*`?(\w+)`?)\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                /* 如果子模式为空，删除主键 */
                if (empty($matches[$i][1]))
                {
                    $sql .= 'DROP PRIMARY KEY,';
                }
                /* 否则删除索引 */
                elseif (in_array($matches[$i][1], $this->indexes))
                {
                    $sql .= 'DROP INDEX ' . $matches[$i][1] . ',';
                }
            }
            if ($sql)
            {
                $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
                $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//存储DROP INDEX操作，已过滤末尾的逗号
            }
            $result[1] = preg_replace($pattern, '', $query);//存储其它操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1] : '';
        }
        
        return $result;
    }
    
    /**
     * 解析出ADD INDEX操作
     *
     * @param   string      $query     SQL查询项
     * @return  array       返回一个以ADD INDEX操作和其它操作组成的数组
     */
    public function parseAddIndexQuery($query)
    {
        $result = array('', $query);
        
        /* 第1个子模式存储索引定义，第2个子模式存储"PRIMARY KEY"，第3个子模式存储键名，第4个子模式存储列名 */
        $pattern = '/\s*ADD\s+((?:INDEX|UNIQUE|(PRIMARY\s+KEY))\s*(?:`?(\w+)`?)?\s*\(\s*`?(\w+)`?\s*(?:,[^,)]+)*\))\s*,?/i';
        if (preg_match_all($pattern, $query, $matches, PREG_SET_ORDER))
        {
            $num = count($matches);
            $sql = '';
            for ($i = 0; $i < $num; $i++)
            {
                $index = !empty($matches[$i][3]) ? $matches[$i][3] : $matches[$i][4];
                if (!empty($matches[$i][2]) && in_array('PRIMARY', $this->indexes))
                {
                    $sql .= 'DROP PRIMARY KEY,';
                }
                elseif (in_array($index, $this->indexes))
                {
                    $sql .= 'DROP INDEX ' . $index . ',';
                }
                $sql .= 'ADD ' . $matches[$i][1] . ',';
            }
            $sql = 'ALTER TABLE ' . $this->tableName . ' ' . $sql;
            $result[0] = preg_replace('/\s*,\s*$/', '', $sql);//存储ADD INDEX操作，已过滤末尾的逗号
            $result[1] = preg_replace($pattern, '', $query);//存储其它的操作
            $result[1] = $this->hasOtherQuery($result[1]) ? $result[1] : '';
        }
        
        return $result;
    }
    
    /**
     * 判断是否还有其它的查询
     *
     * @param   string      $sql     SQL查询串
     * @return  boolean     有返回true，否则返回false
     */
    private function hasOtherQuery($sql)
    {
        return preg_match('/^\s*ALTER\s+TABLE\s*`\w+`\s*\w+/i', $sql);
    }
    
    /**
     * 在查询串中加入字符集设置
     *
     * @param  string      $sql     SQL查询串
     * @return  string     含有字符集设置的SQL查询串
     */
    private function insertCharset($sql)
    {
        $sql = preg_replace('/(TEXT|CHAR\(.*?\)|VARCHAR\(.*?\))\s+/i',
                '\1 CHARACTER SET ' . $this->dbCharset . ' ',
                $sql);
    
        return $sql;
    }
}

//end