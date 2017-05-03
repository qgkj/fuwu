<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取push模板内容的接口
 * @author royalwang
 */
class push_push_template_api extends Component_Event_Api {
	
    /**
     * @param $options[array] 
     *          $options['tpl_name'] 模板代码
     *
     * @return array
     */
	public function call(&$options) {	
	    if (is_string($options)) {
	        $tpl_name = $options;
	    } else {
	        $tpl_name = $options['tpl_name'];
	    }

	    if (empty($tpl_name)) {
	        return false;
	    }
		
		$db = RC_Model::model('mail/mail_templates_model');
		return $db->field('template_id, template_subject, is_html, template_content')->find(array('template_code' => $tpl_name));
	}
}

// end