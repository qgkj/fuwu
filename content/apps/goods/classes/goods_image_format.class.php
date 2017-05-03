<?php
  

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 图片处理类
 * @author royalwang
 */
RC_Loader::load_app_class('goods_imageutils', 'goods', false);
class goods_image_format {
    /**
     * 商品ID
     * @var integer
     */
    protected $goods_id;
    /**
     * 商品分隔符
     * @var String
     */
    protected $goods_separator;
    /**
     * 商品缩略图分隔符
     * @var String
     */
    protected $goods_thumb_separator;
    /**
     * 随机名
     * @var String
     */
    protected $goods_random_name;
    /**
     * 扩展名
     * @var String
     */
    protected $goods_ext_name;
    
    /**
     * 原图位置
     * @var String
     */
    protected $goods_source_postion;
    
    /**
     * 缩略图位置
     * @var String
     */
    protected $goods_thumb_postion;
    
    /**
     * 商品图位置
     * @var String
     */
    protected $goods_img_postion;
    
    protected $dir = 'images';
    
    const GOODS_IMAGE = 'goods';
    const GOODS_GALLERY = 'gallery';
	
	/**
	 * 构造函数
	 */
	public function __construct($goods_id, $img_ext, $type = self::GOODS_IMAGE) 
	{
	    $this->goods_id = $goods_id;
        $this->goods_ext_name = '.' . $img_ext;
        $this->goods_random_name = goods_imageutils::generateRandomName();
        
        if ($type == self::GOODS_IMAGE) {
            $this->goods_separator = '_G_';
            $this->goods_thumb_separator = '_thumb_G_';
        } elseif ($type == self::GOODS_GALLERY) {
            $this->goods_separator = '_P_';
            $this->goods_thumb_separator = '_thumb_P_';
        }

        $this->goods_source_postion = $this->filePathPrefix() . 'source_img/' . $this->spliceFileName();
        $this->goods_img_postion = $this->filePathPrefix() . 'goods_img/' . $this->spliceFileName();
        $this->goods_thumb_postion = $this->filePathPrefix() . 'thumb_img/' . $this->spliceFileName();
	}
	
	/**
	 * 拼接文件名
	 */
	protected function spliceFileName($is_thumb = false)
	{
	    if ($is_thumb) {
	        return $this->getThumbFileName();
	    } else {
	        return $this->getFileName();
	    }
	}
	
	public function filePathPrefix()
	{
	    $sub_dir = date('Ym', RC_Time::gmtime());
	    $path = $this->dir . '/' . $sub_dir . '/';
	    return $path;
	}
	
	public function getGoodsId() {
	    return $this->goods_id;
	}
	
	public function getExtName() {
	    return $this->goods_ext_name;
	}
	
	public function getSourcePostion() {
	    return $this->goods_source_postion;
	}
	
	public function getThumbPostion() {
	    return $this->goods_thumb_postion;
	}
	
	public function getGoodsimgPostion() {
	    return $this->goods_img_postion;
	}
	
	public function getFileName() {
	    return $this->goods_id . $this->goods_separator . $this->goods_random_name . $this->goods_ext_name;
	}
	
	public function getThumbFileName() {
	    return $this->goods_id . $this->goods_thumb_separator . $this->goods_random_name . $this->goods_ext_name;
	}

}

// end