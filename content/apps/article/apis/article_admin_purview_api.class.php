<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author songqian
 */
class article_admin_purview_api extends Component_Event_Api {
    public function call(&$options) {
        $purviews = array(
        	array('action_name' => RC_Lang::get('article::article.article_manage'), 	'action_code' => 'article_manage', 		'relevance' => ''),
        	array('action_name' => RC_Lang::get('article::article.article_update'), 	'action_code' => 'article_update', 		'relevance' => ''),
        	array('action_name' => RC_Lang::get('article::article.article_remove'), 	'action_code' => 'article_delete', 		'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('article::article.cat_manage'), 		'action_code' => 'article_cat_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('article::article.cat_update'), 		'action_code' => 'article_cat_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('article::article.cat_remove'), 		'action_code' => 'article_cat_delete', 	'relevance' => ''),
        		
            array('action_name' => RC_Lang::get('article::article.shopinfo_manage'), 	'action_code' => 'shopinfo_manage', 	'relevance' => ''),
            array('action_name' => RC_Lang::get('article::article.shophelp_manage'), 	'action_code' => 'shophelp_manage', 	'relevance' => ''),
        		
        	array('action_name' =>__('文章自动发布'), 'action_code' => 'article_auto_manage', 'relevance' => ''),
     
        );
        return $purviews;
    }
}

// end