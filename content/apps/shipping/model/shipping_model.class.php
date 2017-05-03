<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class shipping_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'shipping';
		parent::__construct();
	}
	
	public function shipping_find($where, $field='*') {
		$shipping = RC_DB::table('shipping');
		if (!empty($where)) {
			foreach ($where as $key => $val) {
				$shipping->where($key, $val);
			}
		}
		return $shipping->select($field)->first();
	}
	
	public function shipping_field($where, $field) {
		$shipping = RC_DB::table('shipping');
		if (!empty($where)) {
			foreach ($where as $key => $val) {
				$shipping->where($key, $val);
			}
		}
		return $shipping->pluck($field);
	}
	
	public function shipping_select($field='*', $where='', $order='') {
		$shipping = RC_DB::table('shipping');
		if (!empty($where)) {
			foreach ($where as $key => $val) {
				$shipping->where($key, $val);
			}
		}
		
		if (empty($order)) {
			return $shipping->select($field)->get();
		} else {
			return $shipping->orderBy($order)->select($field)->get();
		}
	}
	
	public function is_only($where) {
		$shipping = RC_DB::table('shipping');
		if (!empty($where)) {
			foreach ($where as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $key => $val) {
						if ($key == 'neq') {
							$shipping->where($k, '!=', $val);
						}
					}
				} else {
					$shipping->where($k, $v);
				}
			}
		}
		return $shipping->count();
	}
	
	public function shipping_update($where, $data) {
		$shipping = RC_DB::table('shipping');
		if (!empty($where)) {
			foreach ($where as $key => $val) {
				$shipping->where($key, $val);
			}
		}
		return $shipping->update($data);
	}
}

// end