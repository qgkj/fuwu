<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 图片处理类
 * @author royalwang
 */
class goods_image {
	private    $uploaded_info = array();
	private    $uploaded_file_path;
	
	private    $dir = 'images';
	
	private    $uploaded_file_name;
	
	private    $auto_thumb = true;
	
	/**
	 * 构造函数
	 * @param array $file 上传后返回的文件信息
	 */
	public function __construct($file) {
	    $this->uploaded_info       = $file;
	    $this->uploaded_file_path  = RC_Upload::upload_path() . $file['savepath'] . DS . $file['savename'];
	    $this->uploaded_file_name  = $file['name'];
	}
	
	
	/**
	 * 设置是否需要自动生成缩略图，默认为自动生成缩略图
	 * @param boolean $bool
	 */
	public function set_auto_thumb($bool) {
	    if (is_bool($bool)) {
	        $this->auto_thumb = $bool;
	    }
	}
	
	
	/**
	 * 保存某商品的相册图片
	 * @param   int     $goods_id
	 * @return  void
	 */
	public function generate_goods($goods_id) {
	    /* 重新格式化图片名称 */
	    $original_path   = $this->reformat_image_name('goods', $goods_id, 'source');
	    $img_path        = $this->reformat_image_name('goods', $goods_id, 'goods');
	    
	    // 生成缩略图
	    if ($this->auto_thumb) {
	        $thumb_path      = $this->reformat_image_name('goods_thumb', $goods_id, 'thumb');
	        $this->make_thumb($this->uploaded_file_path, $thumb_path, ecjia::config('thumb_width'), ecjia::config('thumb_height'));
	    } else {
	        $thumb_path = '';
	    }
	    
	    $this->add_watermark($this->uploaded_file_path, $img_path);
	    $this->copy_image($this->uploaded_file_path, $original_path);
	
	    $img_original   = $this->get_image_url($original_path);
	    $img_url        = $this->get_image_url($img_path);
	    $thumb_url      = $this->get_image_url($thumb_path);
	    return array($img_url, $thumb_url, $img_original);
	}
	
	/**
	 * 更新商品图片
	 * @param int $goods_id
	 * @param string $img_desc
	 * @return ecjia_error
	 */
	public function update_goods($goods_id, $img_desc = '') {
	    if (empty($img_desc)) {
	        $img_desc = $this->uploaded_file_name;
	    }
	    
	    list($goods_img, $goods_thumb, $goods_original) = $this->generate_goods($goods_id);
	    
	    if (!$goods_original || !$goods_img) {
	        return new ecjia_error('upload_goods_image_error', RC_Lang::get('goods::goods.upload_goods_image_error'));
	    }
	    
	    $this->db_goods = RC_Loader::load_app_model('goods_model', 'goods');
	    
	    
	    /* 如果有上传图片，删除原来的商品图 */
	    $row = $this->db_goods->join(null)->field('goods_thumb,goods_img,original_img')->find(array('goods_id' => $goods_id));
	    
	    
	    $data = array(
			'goods_img'      => $goods_img,
	        'goods_thumb'    => $goods_thumb,
	        'original_img'   => $goods_original,
		);
		$this->db_goods->join(null)->where(array('goods_id' => $goods_id))->update($data);
		
		/* 先存储新的图片，再删除原来的图片 */
		if ($row['goods_thumb'] != '') {
		    $this->delete_image(self::get_absolute_path($row['goods_thumb']));
		}
		if ($row['goods_img'] != '') {
		    $this->delete_image(self::get_absolute_path($row['goods_img']));
		}
		if ($row['original_img'] != '') {
		    $this->delete_image(self::get_absolute_path($row['original_img']));
		}
	    
	    /* 复制一份相册图片 */
	    /* 添加判断是否自动生成相册图片 */
	    if (ecjia::config('auto_generate_gallery')) {
	        $data = $this->update_gallery($goods_id, $img_desc);
	        if (empty($data['img_id'])) {
	            return new ecjia_error('copy_gallery_image_fail', RC_Lang::get('goods::goods.copy_gallery_image_fail'));
	        }
	    }
	    
	    $this->delete_image($this->uploaded_file_path);
	    
	    /* 不保留商品原图的时候删除原图 */
	    if (!ecjia::config('retain_original_img') && !empty($goods_original)) {
	        $this->db_goods->join(null)->where(array('goods_id' => $goods_id))->update(array('original_img' => ''));
	        $this->delete_image(RC_Upload::upload_path() . str_replace('/', DS, $goods_original));
	    }
	}
	
	/**
	 * 更新商品缩略图
	 * @param int $goods_id
	 * @param string $img_desc
	 * @return ecjia_error
	 */
	public function update_thumb($goods_id) {
	    $thumb_path      = $this->reformat_image_name('goods_thumb', $goods_id, 'thumb');
	    $this->copy_image($this->uploaded_file_path, $thumb_path);

	    $goods_thumb     = $this->get_image_url($thumb_path);
	    if (!$goods_thumb) {
	        return new ecjia_error('upload_thumb_error', RC_Lang::get('goods::goods.upload_thumb_error'));
	    }
	     
	    $this->db_goods = RC_Loader::load_app_model('goods_model', 'goods');
	     
	    $data = array('goods_thumb' => $goods_thumb);
	    $this->db_goods->join(null)->where(array('goods_id' => $goods_id))->update($data);
	     
	    $this->delete_image($this->uploaded_file_path);
	}
	
	/**
	 * 保存某商品的相册图片
	 * @param   int     $goods_id
	 * @return  void
	 */
	public function generate_gallery($goods_id) {
        /* 重新格式化图片名称 */
        $original_path   = $this->reformat_image_name('gallery', $goods_id, 'source');
        $img_path        = $this->reformat_image_name('gallery', $goods_id, 'goods');
        $thumb_path      = $this->reformat_image_name('gallery_thumb', $goods_id, 'thumb');
        
        // 生成缩略图
        $this->make_thumb($this->uploaded_file_path, $thumb_path, ecjia::config('thumb_width'), ecjia::config('thumb_height'));
        $this->add_watermark($this->uploaded_file_path, $img_path);
        $this->copy_image($this->uploaded_file_path, $original_path);
        
        $img_original   = $this->get_image_url($original_path);
        $img_url        = $this->get_image_url($img_path);
        $thumb_url      = $this->get_image_url($thumb_path);
        return array($img_url, $thumb_url, $img_original);
	}
	
	
	
	public function update_gallery($goods_id, $img_desc = '') {
	    if (empty($img_desc)) {
	        $img_desc = $this->uploaded_file_name;
	    }
	    
	    list($goods_img, $goods_thumb, $img_original) = $this->generate_gallery($goods_id);
	    
	    if (!$img_original || !$goods_img) {
	        return new ecjia_error('upload_goods_image_error', RC_Lang::get('goods::goods.upload_goods_image_error'));
	    }
	    
	    $this->delete_image($this->uploaded_file_path);
	    
	    $db_goods_gallery = RC_Loader::load_app_model('goods_gallery_model', 'goods');
	    
	    $data = array(
	        'goods_id' => $goods_id,
	        'img_url' => $goods_img,
	        'img_desc' => $img_desc,
	        'thumb_url' => $goods_thumb,
	        'img_original' => $img_original . '?999',
	    );
	    $data['img_id'] = $db_goods_gallery->insert($data);
	    
	    /* 不保留商品原图的时候删除原图 */
	    if (!ecjia::config('retain_original_img') && !empty($data['img_original'])) {
	        $this->db_goods_gallery->where(array('goods_id' => $goods_id))->update(array('img_original' => ''));
	        $this->delete_image(RC_Upload::upload_path() . str_replace('/', DS, $data['img_original']));
	    }
	    
	    return $data;
	}
	
	
	
	/**
	 * 格式化商品图片名称（按目录存储）
	 *
	 */
	public function reformat_image_name($type, $goods_id, $position = '')
	{
	    $rand_name = RC_Time::gmtime() . sprintf("%03d", mt_rand(1,999));
	    $img_ext = '.' . $this->uploaded_info['ext'];
        
	    $sub_dir = date('Ym', RC_Time::gmtime());
	    
	    $path = RC_Upload::upload_path() . $this->dir . DS . $sub_dir . DS;
	    
	    royalcms('files')->makeDirectory($path . 'source_img');
	    royalcms('files')->makeDirectory($path . 'goods_img');
	    royalcms('files')->makeDirectory($path . 'thumb_img');
	    
        $original_img_path = $path . 'source_img' . DS;
        $goods_img_path = $path . 'goods_img' . DS;
        $goods_thumb_path = $path . 'thumb_img' . DS;

	    switch($type) {
	    	case 'goods':
	    	    $img_name = $goods_id . '_G_' . $rand_name;
	    	    break;
	    	case 'goods_thumb':
	    	    $img_name = $goods_id . '_thumb_G_' . $rand_name;
	    	    break;
	    	case 'gallery':
	    	    $img_name = $goods_id . '_P_' . $rand_name;
	    	    break;
	    	case 'gallery_thumb':
	    	    $img_name = $goods_id . '_thumb_P_' . $rand_name;
	    	    break;
	    }
	
	    if ($position == 'source') {
	        return $original_img_path . $img_name . $img_ext;
	    } elseif ($position == 'thumb') {
	        return $goods_thumb_path . $img_name . $img_ext;
	    } else {
	        return $goods_img_path . $img_name . $img_ext;
	    }
	    return false;
	}
	
	/**
	 * 获取相对上传目录的图片路径
	 * @param string $path
	 * @return string
	 */
	public function get_image_url($path) {
	    if ($path) {
	        return str_replace(DS, '/', str_replace(RC_Upload::upload_path(), '', $path));
	    }
	    return false;
	}
	
	/**
	 * 获取上传图片的绝对路径
	 * @param string $path 数据库中存储的地址
	 * @return string|boolean
	 */
	public static function get_absolute_path($path) {
	    if ($path) {
	        return RC_Upload::upload_path() . $path;
	    }
	    return false;
	}
	
	/**
	 * 获取上传图片的绝对地址
	 * @param string $path 数据库中存储的地址
	 * @return string|boolean
	 */
	public static function get_absolute_url($path) {
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
    public function make_thumb($img, $thumbname, $thumb_width = 0, $thumb_height = 0)
    {
    	$image_name = RC_Image::thumb($img, $thumbname, $this->uploaded_info['ext'], $thumb_width, $thumb_height);
    	return $image_name;
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
    public function add_watermark($filename, $target_file='', $watermark='', $watermark_place='', $watermark_alpha = 0.65) {
        return $this->copy_image($filename, $target_file);
    }

	
    /**
     * 复制图片
     * @param string $source
     * @param string $dest
     * @return boolean
     */
    public function copy_image($source_path, $dest_path) {
        if (is_file($source_path) && is_writable(dirname($dest_path))) {
            return @copy($source_path, $dest_path);
        }
        
        return false;
    }
    
    /**
     * 删除图片
     * @param string $source
     * @param string $dest
     * @return boolean
     */
    public function delete_image($img_path = '') {
        if (!$img_path) {
            $img_path = $this->uploaded_file_path; 
        }
        
        if (!is_file($img_path)) {
            return false;
        }
        
        return @unlink($img_path);
    }

}

// end