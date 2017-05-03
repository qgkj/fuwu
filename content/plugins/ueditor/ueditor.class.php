<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 文本编辑器扩展类
 */
class ueditor extends Component_Editor_Editor {

	private $editor_id;
	
	/**
	 * 编辑器模式
	 * 基础模式 base
	 * 简洁模式 simple
	 * 代码模式 code
	 * 标准模式 standard
	 * 高级模式 advanced
	 * @var string
	 */
	private $mode;

	public function editor_settings($editor_id, $set) {
		$first_run = false;
		$this->mode = isset($set['mode']) ? $set['mode'] : 'standard';
		if (!in_array($this->mode, array('base', 'simple', 'code', 'standard', 'advanced'))) {
		    $this->mode = 'standard';
		}

		if (empty($this->first_init)) {
			if (defined('IN_ADMIN') && IN_ADMIN) {
				if (is_pjax()) {
					RC_Hook::add_action('admin_pjax_footer', array(&$this, 'editor_js'), 50);
					RC_Hook::add_action('admin_pjax_footer', array(&$this, 'enqueue_scripts'), 1);
				} else {
					RC_Hook::add_action('admin_footer', array(&$this, 'editor_js'), 50);
					RC_Hook::add_action('admin_footer', array(&$this, 'enqueue_scripts'), 1);
				}
			} elseif (defined('IN_MERCHANT') && IN_MERCHANT) {
			    if (is_pjax()) {
			        RC_Hook::add_action('merchant_pjax_footer', array(&$this, 'editor_js'), 50);
			        RC_Hook::add_action('merchnat_pjax_footer', array(&$this, 'enqueue_scripts'), 1);
			    } else {
			        RC_Hook::add_action('merchant_footer', array(&$this, 'editor_js'), 50);
			        RC_Hook::add_action('merchant_footer', array(&$this, 'enqueue_scripts'), 1);
			    }
			} else {
				RC_Hook::add_action('front_print_footer_scripts', array(&$this, 'editor_js'), 50);
				RC_Hook::add_action('front_print_footer_scripts', array(&$this, 'enqueue_scripts'), 1);
			}

			$this->editor_id = $editor_id;
		}
	}

	public function enqueue_scripts() {}

	public function editor_js()
	{
		echo $this->create($this->editor_id, '');
	}

	/**
	 * 创建编辑器
	 *
	 * @param   string $input_name
	 * @param   string $input_value
	 * @return  string
	 */
	public function create($input_name, $input_value)
	{
		$input_value = htmlspecialchars($input_value);
		$home_url = RC_Plugin::plugins_url('/', __FILE__) . 'resources/';
		$item = htmlspecialchars($input_name);
		
		$editor_config = RC_Config::get('ueditor::ueditor.editor');
		$editor_mode = RC_Config::get('ueditor::ueditor.toolbars');
		$editor_config['UEDITOR_HOME_URL'] = $home_url;
		$editor_config['serverUrl'] = RC_Uri::site_url().$editor_config['serverUrl'];
		$editor_config['lang'] = RC_Config::get('system.locale');
		$editor_config['toolbars'] = $editor_mode[$this->mode];
		$editor_config_json = json_encode($editor_config);
		
		$editor = <<<STR
				<input type="hidden" id="{$input_name}" name="{$input_name}" value="{$input_value}" />
				<script type="text/plain" name="content" id="container"></script>
				<script type="text/javascript" src="{$home_url}ueditor.all.min.js"></script>
				<script type="text/javascript">
					var cBox = $('#$item');
					var editor = UE.getEditor('$input_name', $editor_config_json);
					editor.addListener('ready', function() {
						var content = cBox.val();
						editor.setContent(content);
					});
					//触发同步
					editor.addListener("contentChange", function() {
						    setSync()
	                });
					//自动同步
					window.setInterval("setSync()", 1000);
					function setSync() {
					   var content = editor.getContent();
					   cBox.val(content);
				    }
				</script>
STR;
		return $editor;
	}
}

// end