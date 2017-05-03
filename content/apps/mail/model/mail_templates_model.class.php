<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mail_templates_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name	= 'mail_templates';
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
		return RC_DB::table('mail_templates')
			->where('template_code', $tpl)
			->select('template_subject', 'template_content', 'is_html')
			->first();
	}
	
	public function mail_templates_find($id) {
		return RC_DB::table('mail_templates')->where('template_id', $id)->first();
	}
	
	public function mail_templates_select($where, $field='*') {
		return RC_DB::table('mail_templates')
			->where('type', $where)
			->select($field)
			->get();
	}
	
	public function mail_templates_update($where, $data) {
		return RC_DB::table('mail_templates')
			->where('template_code', $where)
			->update($data);
	}
}

// end