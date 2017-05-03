<?php
  
/**
 * @brief ErrorCase类，封闭异常
 **/
class ErrorCase {
    private $errorMsg;

    public function __construct(array $inc){
        $this->errorMsg = array(
            "20001" => "<h2>配置文件损坏或无法读取，请重新执行intall</h2>",
            "30001" => "<h2>The state does not match. You may be a victim of CSRF.</h2>",
            "50001" => "<h2>可能是服务器无法请求https协议</h2>可能未开启curl支持,请尝试开启curl支持，重启web服务器，如果问题仍未解决，请联系我们"
            );
        $this->inc = $inc;
    }

    /**
     * showError
     * 显示错误信息
     * @param int $code    错误代码
     * @param string $description 描述信息（可选）
     */
    public function showError($code, $description = '$'){
//         $inc = array (
//           'appid' => 'sdf',
//           'appkey' => 'sdf',
//           'callback' => 'sdfsdf',
//           'scope' => 'get_user_info',
//           'errorReport' => '1',
//           'storageType' => 'file',
//           'host' => 'localhost',
//           'user' => 'root',
//           'password' => 'root',
//           'database' => 'test',
//         );
        $recorder = new Recorder($this->inc);
        
        if(! $recorder->readInc("errorReport")){
            die();//die quietly
        }


        echo "<meta charset=\"UTF-8\">";
        if($description == "$"){
            die($this->errorMsg[$code]);
        }else{
            echo "<h3>error:</h3>$code";
            echo "<h3>msg  :</h3>$description";
            exit(); 
        }
    }
    
    public function showTips($code, $description = '$'){
    }
}

// end
