<?php
  

/**
 * 
 * @author royalwang
 * 
 * Inc对象默认数据值参考
 * "appid":"sdf",
 * "appkey":"sdf",
 * "callback":"sdfsdf",
 * "scope":"get_user_info",
 * "errorReport":true,
 *
 */
class Recorder
{

    private static $data;

    private $inc;

    private $error;

    public function __construct(array $configure )
    {
        $this->error = new ErrorCase($configure);
        
        $this->inc = json_decode(json_encode($configure));
        if (empty($this->inc)) {
            $this->error->showError("20001");
        }
        
        if (empty($_SESSION['QC_userData'])) {
            self::$data = array();
        } else {
            self::$data = $_SESSION['QC_userData'];
        }
    }

    public function write($name, $value)
    {
        self::$data[$name] = $value;
    }

    public function read($name)
    {
        if (empty(self::$data[$name])) {
            return null;
        } else {
            return self::$data[$name];
        }
    }

    public function writeInc($name, $value)
    {
        $this->inc->$name = $value;
    }

    public function readInc($name)
    {
        if (empty($this->inc->$name)) {
            return null;
        } else {
            return $this->inc->$name;
        }
    }

    public function delete($name)
    {
        unset(self::$data[$name]);
    }

    function __destruct()
    {
        $_SESSION['QC_userData'] = self::$data;
    }
}

// end
