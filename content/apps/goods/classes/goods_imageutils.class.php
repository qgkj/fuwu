<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 图片处理类
 * @author royalwang
 */
class goods_imageutils {

    /**
     * 创建图片文件目录
     * @param string $path
     */
	public static function createImagesDirectory($path)
	{
	    RC_Filesystem::disk()->mkdir($path . 'source_img');
	    RC_Filesystem::disk()->mkdir($path . 'goods_img');
	    RC_Filesystem::disk()->mkdir($path . 'thumb_img');
	}
	
	/**
	 * 生成随机文件名
	 */
	public static function generateRandomName() 
	{
	    $rand_name = RC_Time::gmtime() . sprintf("%03d", mt_rand(1,999));
	    return $rand_name;
	}
	
	/**
	 * 获取上传图片的绝对路径
	 * @param string $path 数据库中存储的地址
	 * @return string|boolean
	 */
	public static function getAbsolutePath($path) {
	    if ($path) {
	        return RC_Upload::upload_path() . str_replace('/', DS, $path);
	    }
	    return false;
	}
	
	/**
	 * 获取上传图片的绝对地址
	 * @param string $path 数据库中存储的地址
	 * @return string|boolean
	 */
	public static function getAbsoluteUrl($path) {
	    if ($path) {
	        return RC_Upload::upload_url() . '/' . $path;
	    }
	    return false;
	}

	
    /**
     * 创建图片的缩略图
     *
     * @access public
     * @param string $img 原始图片的路径
     * @param strint $thumbname 生成图片的文件名
     * @param int $thumb_width 缩略图宽度
     * @param int $thumb_height 缩略图高度
     * @return mix 如果成功返回缩略图的路径，失败则返回false
     */
    public static function makeThumb($img, $thumb_img, $img_ext, $thumb_width = 0, $thumb_height = 0)
    {
        $file_name = '/' . basename($img) . '_thumb';
        $dir_name = dirname($img);
        $thumbname = $dir_name . $file_name;
    	$thumbname = RC_Image::thumb($img, $thumbname, $img_ext, $thumb_width, $thumb_height);
    	
    	return self::copyImage($thumbname, $thumb_img);
    }
    
    /**
     * 为图片增加水印
     *
     * @access      public
     * @param       string      filename            原始图片文件名，包含完整路径
     * @param       string      target_file         需要加水印的图片文件名，包含完整路径。如果为空则覆盖源文件
     * @param       string      $watermark          水印完整路径
     * @param       int         $watermark_place    水印位置代码
     * @return      mix         如果成功则返回文件路径，否则返回false
     */
    public static function addWatermark($filename, $target_file = '', $watermark = '', $watermark_place = '', $watermark_alpha = 0.65) {
        return self::copyImage($filename, $target_file);
    }

	
    /**
     * 复制图片
     * @param string $source
     * @param string $dest
     * @return boolean
     */
    public static function copyImage($source_path, $dest_path) {
        if (is_file($source_path) && RC_Filesystem::disk()->is_writable(dirname($dest_path))) {
            return RC_Filesystem::disk()->copy($source_path, $dest_path);
        }
        return false;
    }
    
    /**
     * 删除图片
     * @param string $source
     * @param string $dest
     * @return boolean
     */
    public static function deleteImage($img_path) {
        return RC_Filesystem::disk()->delete($img_path);
    }

}

// end