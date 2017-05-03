<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 生成验证码
 * @author royalwang
 * 类用法
 * $checkcode = new captcha();
 * $checkcode->generate_image();
 * //取得验证
 * $checkcode->record_word(); // $_SESSION['code']
 */

RC_Loader::load_app_class('captcha_abstract', 'captcha', false);
class captcha_royalcms_image extends captcha_abstract {
    /**
     * 存在session中的名称
     * @var string	$session_word
     */
    private $session_word 	= 'captcha_word';

    /**
     * 验证码的宽度
     * @var integrate
     */
	public $width			= 130;
	
	/**
	 * 验证码的高
	 * @var integrate
	 */
	public $height			= 50;
	
	/**
	 * 设置字体的地址
	 * @var string
	 */
	public $font;
	
	/**
	 * 设置字体色
	 * @var string
	 */
	public $font_color;
	
	/**
	 * 设置随机生成因子
	 * @var string
	 */
	public $charset 		= 'abcdefghkmnprstuvwyzABCDEFGHKLMNPRSTUVWYZ23456789';
	
	/**
	 * 设置背景色
	 * @var string
	 */
	public $background 		= '#FFFFFF';
	
	/**
	 * 生成验证码字符数
	 * @var integrate
	 */
	public $code_len 		= 4;
	
	/**
	 * 字体大小
	 * @var integrate
	 */
	public $font_size 		= 20;
	
	/**
	 * 验证码
	 * @var string
	 */
	private $code;
	
	/**
	 * 图片内存
	 * @var bin
	 */
	private $img;
	
	/**
	 * 文字X轴开始的地方
	 * @var integrate
	 */
	private $x_start;
		
	function __construct($config = array()) {
		$this->font = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'font' . DIRECTORY_SEPARATOR . 'elephant.ttf';
		parent::__construct($config);
	}
	
	/**
	 * 生成随机验证码。
	 */
	protected function creat_code() {
		$code = '';
		$charset_len = strlen($this->charset)-1;
		for ($i=0; $i<$this->code_len; $i++) {
			$code .= $this->charset[rand(1, $charset_len)];
		}
		$this->code = $code;
	}
	
	/**
	 * 生成验证码
	 */
	protected function record_word() {
		$_SESSION[$this->session_word] = strtolower($this->code);
	}
	
	
	/**
	 * 验证码校验
	 */
	public function verify_word($word) {
		$word = strtolower($word);
		if ($_SESSION[$this->session_word] == $word) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 生成图片
	 */
	public function generate_image() {
		$this->creat_code();
		$this->record_word();
		$this->img = imagecreatetruecolor($this->width, $this->height);
		if (!$this->font_color) {
			$this->font_color = imagecolorallocate($this->img, rand(0,156), rand(0,156), rand(0,156));
		} else {
			$this->font_color = imagecolorallocate($this->img, hexdec(substr($this->font_color, 1,2)), hexdec(substr($this->font_color, 3,2)), hexdec(substr($this->font_color, 5,2)));
		}
		//设置背景色
		$background = imagecolorallocate($this->img,hexdec(substr($this->background, 1,2)),hexdec(substr($this->background, 3,2)),hexdec(substr($this->background, 5,2)));
		//画一个柜形，设置背景颜色。
		imagefilledrectangle($this->img,0, $this->height, $this->width, 0, $background);
		$this->creat_font();
		$this->creat_line();
		$this->output();
	}
	
	/**
	 * 生成文字
	 */
	private function creat_font() {
		$x = $this->width/$this->code_len;
		for ($i=0; $i<$this->code_len; $i++) {
			imagettftext($this->img, $this->font_size, rand(-30,30), $x*$i+rand(0,5), $this->height/1.4, $this->font_color, $this->font, $this->code[$i]);
			if($i==0)$this->x_start=$x*$i+5;
		}
	}
	
	/**
	 * 画线
	 */
	private function creat_line() {
		imagesetthickness($this->img, 3);
	    $xpos   = ($this->font_size * 2) + rand(-5, 5);
	    $width  = $this->width / 2.66 + rand(3, 10);
	    $height = $this->font_size * 2.14;
	
	    if ( rand(0,100) % 2 == 0 ) {
	      $start = rand(0,66);
	      $ypos  = $this->height / 2 - rand(10, 30);
	      $xpos += rand(5, 15);
	    } else {
	      $start = rand(180, 246);
	      $ypos  = $this->height / 2 + rand(10, 30);
	    }
	
	    $end = $start + rand(75, 110);
	
	    imagearc($this->img, $xpos, $ypos, $width, $height, $start, $end, $this->font_color);
	
	    if ( rand(1,75) % 2 == 0 ) {
	      $start = rand(45, 111);
	      $ypos  = $this->height / 2 - rand(10, 30);
	      $xpos += rand(5, 15);
	    } else {
	      $start = rand(200, 250);
	      $ypos  = $this->height / 2 + rand(10, 30);
	    }
	
	    $end = $start + rand(75, 100);
	
	    imagearc($this->img, $this->width * .75, $ypos, $width, $height, $start, $end, $this->font_color);
	}
	
	//输出图片
	private function output() {
		header("content-type:image/png\r\n");
		imagepng($this->img);
		imagedestroy($this->img);
	}
}

// end