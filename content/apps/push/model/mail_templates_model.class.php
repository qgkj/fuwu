<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mail_templates_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name 	= 'mail_templates';
		parent::__construct();
	}

	/**
	 * 加载指定的模板内容
	 *
	 * @access  public
	 * @param   string  $temp   邮件模板的ID
	 * @return  array
	 */
	public function load_template($tpl) {
		$row = $this->field('template_subject, template_content, is_html')->find(array('template_code' => $tpl));
		return $row;
	}
	
	public function template_select($where, $field='*') {
		return $this->field($field)->where($where)->select();
	}

	public function is_only($where) {
		return $this->where($where)->count();
	}

	public function template_manage($parameter) {
//		if (!isset($parameter['template_id'])) {
//			$id = $this->insert($parameter);
//		} else {
//			$where = array('template_id' => $parameter['template_id']);
//
//			$this->where($where)->update($parameter);
//			$id = $parameter['template_id'];
//		}
//		return $id;
       $db_mail_templates = RC_DB::table('mail_templates');
		if (!isset($parameter['template_id'])) {
			$id = $db_mail_templates->insertGetId($parameter);
		} else {
			$db_mail_templates->where('template_id',$parameter['template_id'])->update($parameter);
			$id = $parameter['template_id'];
		}
        return $id;
	}

	public function template_find($where) {
		return $this->where($where)->find();
	}

	public function template_remove($where) {
		return $this->where($where)->delete();
	}
}

// end