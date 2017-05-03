<?php 
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * Memcache 缓存
 *
 * 通过K-V存储的API来把memcache作为Smarty的输出缓存器。
 *
 * 注意memcache要求key的长度只能是256个字符以内，
 * 所以程序中，key都进行sha1哈希计算后才使用。
 */
class Smarty_CacheResource_Ecjia_memcache extends Smarty_CacheResource_KeyValueStore {	
	/**
     * memcache 对象
     * @var Memcache
     */
    protected $memcache = null;
    
    public function __construct() {
        $this->memcache = new Memcache();
        $this->memcache->addServer( '127.0.0.1', 11211 );
    }
    
    /**
	 * 从memcache中获取一系列key的值。
     *
     * @param array $keys 多个key
     * @return array 按key的顺序返回的对应值
     * @return boolean 成功返回true，失败返回false
     */
    protected function read(array $keys) {
        $_keys = $lookup = array();
        foreach ($keys as $k) {
            $_k = sha1($k);
            $_keys[] = $_k;
            $lookup[$_k] = $k;
        }
        $_res = array();
        $res = $this->memcache->get($_keys);
        foreach ($res as $k => $v) {
            $_res[$lookup[$k]] = $v;
        }
        return $_res;
    }
    
    /**
	 * 将一系列的key对应的值存储到memcache中。
     *
     * @param array $keys 多个kv对应的数据值
     * @param int $expire 过期时间
     * @return boolean 成功返回true，失败返回false
     */
    protected function write(array $keys, $expire=null) {
        foreach ($keys as $k => $v) {
            $k = sha1($k);
            $this->memcache->set($k, $v, 0, $expire);
        }
        return true;
    }

    /**
	 * 从memcache中删除
     *
     * @param array $keys 待删除的多个key
     * @return boolean 成功返回true，失败返回false
     */
    protected function delete(array $keys) {
        foreach ($keys as $k) {
            $k = sha1($k);
            $this->memcache->delete($k);
        }
        return true;
    }

    /**
     * 清空全部的值
     *
     * @return boolean 成功返回true，失败返回false
     */
    protected function purge() {
        return $this->memcache->flush();
    }
}