<?php
  
defined ( 'IN_ECJIA' ) or exit ( 'No permission resources.' );

class mail_templates_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'mail_templates';
		parent::__construct ();
	}
}

// end