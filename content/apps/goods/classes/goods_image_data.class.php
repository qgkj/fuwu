<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 图片处理类
 * @author royalwang
 */
RC_Loader::load_app_class('goods_imageutils', 'goods', false);
RC_Loader::load_app_class('goods_image_format', 'goods', false);
class goods_image_data {
	protected $file_path;

	protected $auto_generate_thumb = true;
	
	protected $goods_format;
	protected $gallery_format;
	
	protected $goods_id;
	
	protected $img_desc;
	protected $img_ext;
	
	/**
	 * 构造函数
	 * @param array $file 上传后返回的文件信息
	 */
	public function __construct($file_name, $file_path, $img_ext, $goods_id) {
	    $this->goods_id = $goods_id;
	    $this->img_ext = $img_ext;
	    $this->img_desc = $file_name;
	    $this->file_path = $file_path;

	    $this->goods_format = new goods_image_format($goods_id, $img_ext, goods_image_format::GOODS_IMAGE);
	    $this->gallery_format = new goods_image_format($goods_id, $img_ext, goods_image_format::GOODS_GALLERY);
	    
	    $this->create_dir();
	}
	
	protected function create_dir() {
	    $images_path = RC_Upload::upload_path() . $this->goods_format->filePathPrefix() . DS;
	    goods_imageutils::createImagesDirectory($images_path);
	}
	
	/**
	 * 保存某商品的相册图片
	 * @param   int     $goods_id
	 * @return  void
	 */
	protected function generate_goods() {
	    /* 重新格式化图片名称 */
	    $img_path = goods_imageutils::getAbsolutePath($this->goods_format->getGoodsimgPostion());
	    $original_path = goods_imageutils::getAbsolutePath($this->goods_format->getSourcePostion());

	    // 生成缩略图
	    if ($this->auto_generate_thumb) {
	        $thumb_path      = goods_imageutils::getAbsolutePath($this->goods_format->getThumbPostion());
	        goods_imageutils::makeThumb($this->file_path, $thumb_path, $this->img_ext, ecjia::config('thumb_width'), ecjia::config('thumb_height'));
	    }

	    goods_imageutils::addWatermark($this->file_path, $img_path);
	    goods_imageutils::copyImage($this->file_path, $original_path);
	}
	
	/**
	 * 保存某商品的相册图片
	 * @param   int     $goods_id
	 * @return  void
	 */
	protected function generate_gallery() {
	    $original_path = goods_imageutils::getAbsolutePath($this->gallery_format->getSourcePostion());
	    $img_path = goods_imageutils::getAbsolutePath($this->gallery_format->getGoodsimgPostion());
	    $thumb_path = goods_imageutils::getAbsolutePath($this->gallery_format->getThumbPostion());
	
	    // 生成缩略图
	    goods_imageutils::makeThumb($this->file_path, $thumb_path, $this->img_ext, ecjia::config('thumb_width'), ecjia::config('thumb_height'));
	    goods_imageutils::addWatermark($this->file_path, $img_path);
	    goods_imageutils::copyImage($this->file_path, $original_path);
	}
	
	/**
	 * 设置是否需要自动生成缩略图，默认为自动生成缩略图
	 * @param boolean $bool
	 */
	public function set_auto_thumb($bool) {
	    if (is_bool($bool)) {
	        $this->auto_generate_thumb = $bool;
	    }
	}
	
	/**
	 * 更新商品图片
	 * @param int $goods_id
	 * @param string $img_desc
	 * @return ecjia_error
	 */
	public function update_goods($img_desc = null) {
	    if (empty($img_desc)) {
	        $img_desc = $this->img_desc;
	    }

	    $this->generate_goods();

	    $goods_img = $this->goods_format->getGoodsimgPostion();
	    $goods_original = $this->goods_format->getSourcePostion();
	    $goods_thumb = $this->auto_generate_thumb ? $this->goods_format->getThumbPostion() : '';
	    
	    if (!$goods_original || !$goods_img) {
	        return new ecjia_error('upload_goods_image_error', RC_Lang::get('goods::goods.upload_goods_image_error'));
	    }
	    
	    $db_goods = RC_Model::model('goods/goods_model');
	    
	    /* 如果有上传图片，删除原来的商品图 */
	    $row = $db_goods->field('goods_thumb,goods_img,original_img')->find(array('goods_id' => $this->goods_id));

	    $data = array(
			'goods_img'      => $goods_img,
	        'goods_thumb'    => $goods_thumb,
	        'original_img'   => $goods_original,
		);
		$db_goods->where(array('goods_id' => $this->goods_id))->update($data);
		
		/* 先存储新的图片，再删除原来的图片 */
		if ($row['goods_thumb']) {
		    goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($row['goods_thumb']));
		}
		if ($row['goods_img']) {
		    goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($row['goods_img']));
		}
		if ($row['original_img']) {
		    goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($row['original_img']));
		}
	    
	    /* 复制一份相册图片 */
	    /* 添加判断是否自动生成相册图片 */
	    if (ecjia::config('auto_generate_gallery')) {
	        $data = $this->update_gallery($img_desc);
	        if (empty($data['img_id'])) {
	            return new ecjia_error('copy_gallery_image_fail', RC_Lang::get('goods::goods.copy_gallery_image_fail'));
	        }
	    }
	    
// 	    goods_imageutils::deleteImage($this->file_path);

	    /* 不保留商品原图的时候删除原图 */
	    if (!ecjia::config('retain_original_img') && !empty($goods_original)) {
	        $db_goods->where(array('goods_id' => $this->goods_id))->update(array('original_img' => ''));
	        goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($goods_original));
	    }

	}
	
	/**
	 * 更新商品缩略图
	 * @param int $goods_id
	 * @param string $img_desc
	 * @return ecjia_error
	 */
	public function update_thumb() {
	    $thumb_path = goods_imageutils::getAbsolutePath($this->goods_format->getThumbPostion());
	    goods_imageutils::copyImage($this->file_path, $thumb_path);

	    $goods_thumb = $this->goods_format->getThumbPostion();
	    if (!$goods_thumb) {
	        return new ecjia_error('upload_thumb_error', RC_Lang::get('goods::goods.upload_thumb_error'));
	    }
	     
	    $db_goods = RC_Model::model('goods/goods_model');
	    
	    /* 如果有上传图片，删除原来的商品图 */
	    $row = $db_goods->field('goods_thumb')->find(array('goods_id' => $this->goods_id));
	     
	    $data = array('goods_thumb' => $goods_thumb);
	    $db_goods->where(array('goods_id' => $this->goods_id))->update($data);
	    
	    /* 先存储新的图片，再删除原来的图片 */
	    if ($row['goods_thumb'] != '') {
	        goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($row['goods_thumb']));
	    }
	     
// 	    goods_imageutils::deleteImage($this->file_path);
	}

	public function update_gallery($img_desc = null) {
	    if (empty($img_desc)) {
	        $img_desc = $this->img_desc;
	    }
	    
	    $this->generate_gallery();
	    
	    $goods_img = $this->gallery_format->getGoodsimgPostion();
	    $goods_original = $this->gallery_format->getSourcePostion();
	    $goods_thumb = $this->gallery_format->getThumbPostion();
	    
	    if (!$goods_original || !$goods_img) {
	        return new ecjia_error('upload_goods_gallery_error', RC_Lang::get('goods::goods.upload_goods_image_error'));
	    }

	    $db_goods_gallery = RC_Model::model('goods/goods_gallery_model');
	    
	    $data = array(
	        'goods_id' 		=> $this->goods_id,
	        'img_url' 		=> $goods_img,
	        'img_desc' 		=> $img_desc,
	        'thumb_url' 	=> $goods_thumb,
	        'img_original' 	=> $goods_original . '?999',
	    );
	    $data['img_id'] = $db_goods_gallery->insert($data);
	    
// 	    goods_imageutils::deleteImage($this->file_path);
	    
	    /* 不保留商品原图的时候删除原图 */
	    if (!ecjia::config('retain_original_img') && !empty($data['img_original'])) {
	        $db_goods_gallery->where(array('goods_id' => $this->goods_id))->update(array('img_original' => ''));
	        goods_imageutils::deleteImage(goods_imageutils::getAbsolutePath($data['img_original']));
	    }
	    
	    return $data;
	}

}

// end