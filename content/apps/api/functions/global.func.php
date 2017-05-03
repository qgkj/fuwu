<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

function em_autoload($className) {
    return RC_Loader::load_app_class($className, 'api', false);
}

function getValueByDefault($value, $default) {
    if (!is_array($value)) {
        $whiteList = array();
        if (is_array($default)) {
            $whiteList = $default;
            $default = isset($default[0]) ? $default[0] : $default;
        } elseif ($value == '') {
            return $default;
        }

        if (is_string($default)) {
            $value = trim($value);
        } elseif (is_int($default)) {
            $value = intval($value);
        } elseif (is_array($default)) {
            if ($value == '') {
                return $default;
            }
            $value = (array)$value;
        } else {
            $value = floatval($value);
        }

        if ($whiteList && !in_array($value, $whiteList)) {
            $value = $default;
        }

    } else {
        foreach ($value as $key => $val) {
            $t = isset($default[$key]) ? $default[$key] : '';
            $value[$key] = getValueByDefault($value[$key], $t);
        }
        if (is_array($default)) {
            $value += $default;
        }
    }

    return $value;
}

function _GET($key = '', $default = '') {
    if (empty($key)) {
        return $_GET;
    }

    if (!isset($_GET[$key])) {
        $_GET[$key] = '';
    }
    $value = getValueByDefault($_GET[$key], $default);

    return $value;
}

function _POST($key = '', $default = '') {
    if (empty($key)) {
        return $_POST;
    }

    if (!isset($_POST[$key])) {
        $_POST[$key] = '';
    }
    $value = getValueByDefault($_POST[$key], $default);

    return $value;
}

function getImage($img) {
    if (substr($img, 0, 4) == 'http') {
        return $img;
    }

//     return dirname($GLOBALS['ecs']->url()).'/'.ltrim($img, '/');
    return RC_Upload::upload_url() .'/'.ltrim($img, '/');
}

function formatTime($Time) {	
	if (strlen($Time) == strlen(intval($Time))) {
		if ($Time == 0) {
			return '';
		}
		$unixTime = $Time;
	} else {
		$unixTime = strtotime($Time);
	}
	return date('Y/m/d H:i:s O', $unixTime);
}

function bjTime($Time) {
	// $unixTime = $Time + 8*3600;
	// return date('Y/m/d H:i:s O', $unixTime);
	
	return RC_Time::local_date('Y/m/d H:i:s O', $Time);
}

function API_DATA($type, $readData) {
	$outData = array();
	if (empty($readData)) {
		return $outData;
	}
	if (is_array($readData)) {
		$first = current($readData);
		if ($first && is_array($first)) {
			foreach ($readData as $key => $value) {
				$outData[] = API_DATA($type, $value);
			}
			return array_filter($outData);
		}
	}

	switch ($type) {
		case 'PHOTO':
            $outData = getImage($readData);
			break;
		case 'SIMPLEGOODS':
			$outData = array(
			  "goods_id" => $readData['goods_id'],
			  "name" => $readData['goods_name'],
			  "market_price" => $readData['market_price'],
			  "shop_price" => $readData['shop_price'],
			  "promote_price" => $readData['promote_price'],
			  "img" => array(
				'thumb'=>API_DATA('PHOTO', $readData['goods_img']),
				'url' => API_DATA('PHOTO', $readData['original_img']),
                'small' => API_DATA('PHOTO', $readData['goods_thumb'])
				)
			);
			break;
		case 'ADDRESS':
			$outData = array(
				"id"       => 15,
				"consignee"  => "联系人姓名",
				"email"    => "联系人email",
				"country"  => "国家id",
				"province" => "省id",
				"city"     => "城市id",
				"district" => "地区id",
				"address"  => "详细地址",
				"zipcode"  => "邮政编码",
				"tel"      => "联系电话",
				"mobile"   => "手机",
				"sign_building" => "标志建筑",
				"best_time" => "最佳送货时间"	
			);
			break;
		case 'SIGNUPFIELDS':
			$outData = array(
				"id"  => 12,
			  	"name"  => "说明",
			  	"need"  => 0
			);
			break;
		case 'CONFIG':
			$outData = array(
				"shop_closed" => 0,
			  	"close_comment" => "关闭原因"
			);
			break;
		case 'CATEGORY':
			$outData = array(
				"id"    => 12,
			  	"name"  => "分类名称",
			  	"children"  => array(
			  		'id'   =>  13,
					'name' => 'ssss'
			  	)
			);
			break;
		case 'SIMPLEORDER':
			$outData = array(
			  "id" => $readData['order_id'],
			  "order_sn" => $readData['order_sn'],
			  "order_time" => $readData['order_time'],
			  "order_status" => $readData['order_status'],
			  "total_fee" => $readData['total_fee'],
			);
			break;
		case 'GOODS':
            $readData['original_img'] || $readData['original_img'] = $readData['goods_thumb'];
			$outData = array(
				"id"  =>  $readData['goods_id'],
				"cat_id" => $readData['cat_id'],
				"goods_sn" => $readData['goods_sn'],
				"goods_name" => $readData['goods_name'],
				// "goods_desc"=>$readData['goods_desc'],
                "collected" => $readData['collected'],
				"market_price" => $readData['market_price'],
				"shop_price" => $readData['shop_price'] > 0 ? price_format($readData['shop_price']) : __('免费'),
				"integral" => $readData['integral'],
				"click_count" => $readData['click_count'],
				"brand_id" => $readData['brand_id'],
                // fix 没有goods_number值
				"goods_number" => is_numeric($readData['goods_number']) ? $readData['goods_number'] : 65535,
				"goods_weight" =>  $readData['goods_weight'],
				"promote_price" => $readData['promote_price_org'],
				"formated_promote_price" => price_format($readData['promote_price_org'], false),//$readData['promote_price'],
				"promote_start_date" => bjTime($readData['promote_start_date']),
				"promote_end_date"  => bjTime($readData['promote_end_date']),
				"is_shipping" => $readData['is_shipping'],
				"img" => array(
					'thumb'=>API_DATA('PHOTO', $readData['goods_img']),
					'url' => API_DATA('PHOTO', $readData['original_img']),
					'small'=>API_DATA('PHOTO', $readData['goods_thumb'])
				 ),
				"rank_prices" => array(),
				"pictures" => array(),
				"properties" => array(),
				"specification" => array()
			);
			foreach ($readData['rank_prices'] as $key => $value) {
				$outData['rank_prices'][] = array(
					"id"   =>  $key,
					"rank_name" => $value['rank_name'],
					'unformatted_price' => $value['unformatted_price'],
					"price" => $value['price']
				);
			}

			foreach ($readData['pictures'] as $key => $value) {
				$outData['pictures'][] = array(
					"small"=>API_DATA('PHOTO', $value['thumb_url']),
					"thumb"=>API_DATA('PHOTO', $value['thumb_url']),
					"url"=>API_DATA('PHOTO', $value['img_url'])
				);
			}

            if (!empty($readData['properties'])) {
                // $readData['properties'] = current($readData['properties']);
    			foreach ($readData['properties'] as $key => $value) {
                    // 处理分组
                    foreach ($value as $k => $v) {
                        $v['value'] = strip_tags($v['value']);
        				$outData['properties'][] = $v;
                    }
    			}
            }

			foreach ($readData['specification'] as $key => $value) {
				if (!empty($value['values'])) {
					$value['value'] = $value['values'];
					unset($value['values']);	
				}
				$outData['specification'][] = $value;
			}
			break;
        default:
            break;
    }
    return $outData;
}

// end