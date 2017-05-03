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

}

// end