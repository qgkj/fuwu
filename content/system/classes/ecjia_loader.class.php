<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_loader {
	/**
	 * Register all ECJia scripts.
	 *
	 * Localizes some of them.
	 * args order: $scripts->add( 'handle', 'url', 'dependencies', 'query-string', 1 );
	 * when last arg === 1 queues the script for the footer
	 *
	 * @since 1.0.0
	 *
	 * @param object $scripts WP_Scripts object.
	 */
	public static function default_scripts( &$scripts ) {
		$develop_src = false !== strpos( Royalcms\Component\Foundation\Royalcms::VERSION, '-src' );

		if ( ! defined( 'SCRIPT_DEBUG' ) ) {
			define( 'SCRIPT_DEBUG', $develop_src );
		}


		$scripts->base_url = RC_Uri::system_static_url();
		$scripts->content_url = RC_Uri::system_static_url();
		$scripts->default_version = VERSION;
		$scripts->default_dirs = array('/content/system/statics/');

		$suffix = SCRIPT_DEBUG ? '' : '.min';
		$dev_suffix = $develop_src ? '' : '.min';

		// 添加 ecjia-js
		$scripts->add( 'ecjia', 				'/lib/ecjia-js/ecjia.js', array('jquery') );
		$scripts->add( 'ecjia-region', 			'/lib/ecjia-js/ecjia.region.js', array('ecjia') );
		$scripts->add( 'ecjia-ui', 				'/lib/ecjia-js/ecjia.ui.js', array('ecjia') );
		$scripts->add( 'ecjia-utils', 			'/lib/ecjia-js/ecjia.utils.js', array('ecjia') );

// 		$scripts->add( 'ecjia-addon', 			'statics/lib/ecjia-js/ecjia.addon.js', array('ecjia') );
// 		$scripts->add( 'ecjia-autocomplete', 	'statics/lib/ecjia-js/ecjia.autocomplete.js', array('ecjia') );
// 		$scripts->add( 'ecjia-browser', 		'statics/lib/ecjia-js/ecjia.browser.js', array('ecjia') );
// 		$scripts->add( 'ecjia-colorselecter', 	'statics/lib/ecjia-js/ecjia.colorselecter.js', array('ecjia') );
// 		$scripts->add( 'ecjia-compare', 		'statics/lib/ecjia-js/ecjia.compare.js', array('ecjia') );
// 		$scripts->add( 'ecjia-cookie', 			'statics/lib/ecjia-js/ecjia.cookie.js', array('ecjia') );
// 		$scripts->add( 'ecjia-flow', 			'statics/lib/ecjia-js/ecjia.flow.js', array('ecjia') );
// 		$scripts->add( 'ecjia-goods', 			'statics/lib/ecjia-js/ecjia.goods.js', array('ecjia') );
// 		$scripts->add( 'ecjia-lefttime', 		'statics/lib/ecjia-js/ecjia.lefttime.js', array('ecjia') );
// 		$scripts->add( 'ecjia-listtable', 		'statics/lib/ecjia-js/ecjia.listtable.js', array('ecjia') );
// 		$scripts->add( 'ecjia-listzone', 		'statics/lib/ecjia-js/ecjia.listzone.js', array('ecjia') );
// 		$scripts->add( 'ecjia-message', 		'statics/lib/ecjia-js/ecjia.message.js', array('ecjia') );
// 		$scripts->add( 'ecjia-orders', 			'statics/lib/ecjia-js/ecjia.orders.js', array('ecjia') );
// 		$scripts->add( 'ecjia-selectbox', 		'statics/lib/ecjia-js/ecjia.selectbox.js', array('ecjia') );
// 		$scripts->add( 'ecjia-selectzone', 		'statics/lib/ecjia-js/ecjia.selectzone.js', array('ecjia') );
// 		$scripts->add( 'ecjia-shipping', 		'statics/lib/ecjia-js/ecjia.shipping.js', array('ecjia') );
// 		$scripts->add( 'ecjia-showdiv', 		'statics/lib/ecjia-js/ecjia.showdiv.js', array('ecjia') );
// 		$scripts->add( 'ecjia-todolist', 		'statics/lib/ecjia-js/ecjia.todolist.js', array('ecjia') );
// 		$scripts->add( 'ecjia-topbar', 			'statics/lib/ecjia-js/ecjia.topbar.js', array('ecjia') );
// 		$scripts->add( 'ecjia-user', 			'statics/lib/ecjia-js/ecjia.user.js', array('ecjia') );
// 		$scripts->add( 'ecjia-validator', 		'statics/lib/ecjia-js/ecjia.validator.js', array('ecjia') );
// 		$scripts->add( 'ecjia-editor', 			'statics/lib/ecjia-js/ecjia.editor.js', array('ecjia') );

		// 添加jquery
		$scripts->add( 'jquery', 				"/js/jquery$suffix.js" );
		$scripts->add( 'jquery-pjax', 			"/js/jquery-pjax.js", array('jquery') );
		$scripts->add( 'jquery-peity', 			"/js/jquery-peity$suffix.js", array('jquery'), false, 1  );
		$scripts->add( 'jquery-mockjax', 		"/js/jquery-mockjax$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-wookmark', 		"/js/jquery-wookmark$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-migrate', 		"/js/jquery-migrate$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-cookie', 		"/js/jquery-cookie$suffix.js", array('jquery'), true, 1 );
		$scripts->add( 'jquery-actual', 		"/js/jquery-actual$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-debouncedresize',"/js/jquery-debouncedresize$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-easing', 		"/js/jquery-easing$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-mediaTable', 	"/js/jquery-mediaTable$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-imagesloaded', 	"/js/jquery-imagesloaded$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-gmap3', 			"/js/jquery-gmap3$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-autosize', 		"/js/jquery-autosize$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-counter', 		"/js/jquery-counter$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-inputmask', 		"/js/jquery-inputmask$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-progressbar',	"/js/jquery-anim_progressbar$suffix.js", array('jquery'), false, 1 );

		$scripts->add( 'js-json', 				"/js/json2.js", array(), false, 1 );

		// 添加jquery-ui
		$scripts->add( 'jquery-ui-touchpunch',	"/js/ui/jquery-ui-touchpunch$suffix.js", array('jquery-ui'), false, 1 );
		$scripts->add( 'jquery-ui-totop',		"/js/ui/jquery-ui-totop$suffix.js", array('jquery'), false, 1 );


		// 添加ecjia-admin
		$scripts->add( 'ecjia-admin', 			     '/ecjia/ecjia-admin.js', array('ecjia', 'jquery-pjax', 'jquery-cookie', 'jquery-quicksearch', 'jquery-mousewheel', 'jquery-ui-totop') );// 'nicescroll',

		// 添加ecjia admin lib
		$scripts->add( 'ecjia-admin_cache',           '/ecjia/ecjia-admin_cache.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_logs',            '/ecjia/ecjia-admin_logs.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_message_list',    '/ecjia/ecjia-admin_message_list.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_nav',             '/ecjia/ecjia-admin_nav.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_region',          '/ecjia/ecjia-admin_region.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_role',            '/ecjia/ecjia-admin_role.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_template',        '/ecjia/ecjia-admin_template.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_upgrade',         '/ecjia/ecjia-admin_upgrade.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_application',     '/ecjia/ecjia-application.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_dashboard',       '/ecjia/ecjia-dashboard.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_team',       	  '/ecjia/ecjia-about_team.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_plugin',          '/ecjia/ecjia-plugin_list.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_privilege',       '/ecjia/ecjia-privilege.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_shop_config',     '/ecjia/ecjia-shop_config.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_template_setup',  '/ecjia/ecjia-template_setup.js', array('ecjia-admin'), false, 1 );
		$scripts->add( 'ecjia-admin_license',         '/ecjia/ecjia-admin_license.js', array('ecjia-admin'), false, 1 );


		// 添加lib
		$scripts->add( 'bootstrap', 				"/lib/bootstrap/js/bootstrap$suffix.js" );
		$scripts->add( 'jquery-ui',					"/lib/jquery-ui/jquery-ui$suffix.js", array('jquery') );
		$scripts->add( 'jquery-validate',			"/lib/validation/jquery.validate$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-uniform',			"/lib/uniform/jquery.uniform$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'smoke',						"/lib/smoke/smoke$suffix.js", array(), false, 1 );
		$scripts->add( 'jquery-chosen', 			"/lib/chosen/chosen.jquery$suffix.js", array('jquery'), false, 1 );

		$scripts->add( 'bootstrap-placeholder',     "/lib/jasny-bootstrap/js/bootstrap-placeholder$suffix.js", array('bootstrap') );

		$scripts->add( 'jquery-flot', 				"/lib/flot/jquery.flot$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-flot-curvedLines', 	"/lib/flot/jquery.flot.curvedLines$suffix.js", array('jquery-flot'), false, 1 );
		$scripts->add( 'jquery-flot-multihighlight',"/lib/flot/jquery.flot.multihighlight$suffix.js", array('jquery-flot'), false, 1 );
		$scripts->add( 'jquery-flot-orderBars', 	"/lib/flot/jquery.flot.orderBars$suffix.js", array('jquery-flot'), false, 1 );
		$scripts->add( 'jquery-flot-pie', 			"/lib/flot/jquery.flot.pie$suffix.js", array('jquery-flot'), false, 1 );
		$scripts->add( 'jquery-flot-pyramid', 		"/lib/flot/jquery.flot.pyramid$suffix.js", array('jquery-flot'), false, 1 );
		$scripts->add( 'jquery-flot-resize', 		"/lib/flot/jquery.flot.resize$suffix.js", array('jquery-flot'), false, 1 );

        $scripts->add( 'antiscroll', 				"/lib/antiscroll/antiscroll$suffix.js", array('jquery'), false, 1 );
        $scripts->add( 'jquery-mousewheel', 		"/lib/antiscroll/jquery-mousewheel.js", array('jquery','antiscroll'), false, 1 );
		// $scripts->add( 'nicescroll', 				"/lib/nicescroll/jquery.nicescroll$suffix.js", array('jquery'), false, 1 );

		$scripts->add( 'jquery-colorbox', 			"/lib/colorbox/jquery.colorbox$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-qtip', 				"/lib/qtip2/jquery.qtip$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-sticky', 			"/lib/sticky/sticky$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-jBreadCrumb', 		"/lib/jBreadcrumbs/js/jquery.jBreadCrumb$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-form', 				"/lib/jquery-form/jquery.form$suffix.js", array('jquery'), false, 1 );

		$scripts->add( 'ios-orientationchange',		"/lib/ios-fix/ios-orientationchange-fix$suffix.js", array(), false, 1 );
		$scripts->add( 'google-code-prettify',		"/lib/google-code-prettify/prettify$suffix.js", array(), false, 1 );
		$scripts->add( 'selectnav',					"/lib/selectnav/selectnav$suffix.js", array(), false, 1 );

		$scripts->add( 'jquery-dataTables', 			"/lib/datatables/jquery.dataTables$suffix.js", array('jquery'), false, 1 );
		$scripts->add( 'jquery-dataTables-sorting',		"/lib/datatables/jquery.dataTables.sorting$suffix.js", array('jquery-dataTables'), false, 1 );
		$scripts->add( 'jquery-dataTables-bootstrap',	"/lib/datatables/jquery.dataTables.bootstrap$suffix.js", array('jquery-dataTables'), false, 1 );


		$scripts->add( 'jquery-stepy',					"/lib/stepy/js/jquery.stepy$suffix.js", array(), false, 1 );

		$scripts->add( 'jquery-quicksearch',			"/lib/multi-select/js/jquery.quicksearch.js", array(), false, 1);


		// 添加vendor
		$scripts->add( 'tinymce',				RC_Uri::vendor_url('tinymce/tinymce') . "$suffix.js", array(), false, 1 );
		
		
		
		$admin_jslang = array(
			'ok'				=> __('确定'),
			'cancel'			=> __('取消'),
			'confirm_del'		=> __('您确定要删除这条记录吗？'),
			'error'				=> __('参数错误，无法删除！'),
			'confirm'			=> __('您确定要操作所有选中项吗？'),
			'please_select'		=> __('请先选中操作项！'),
			'batch_error'		=> __('批量操作缺少参数！'),
			'parameter_error'	=> __('参数错误，无法选择！'),
			'status_success'	=> __('状态修改成功！'),
			'clone'				=> __('clone-obj方法未设置data-parent参数。'),
			'missing_parameters'	=> __('缺少参数'),
			'confirm_delete_file'	=> __('您确定要删除此文件吗？'),
		
		);
		RC_Script::localize_script('ecjia.ui', 'admin_lang', $admin_jslang);
	}


	/**
	 * Assign default styles to $styles object.
	 *
	 * Nothing is returned, because the $styles parameter is passed by reference.
	 * Meaning that whatever object is passed will be updated without having to
	 * reassign the variable that was passed back to the same value. This saves
	 * memory.
	 *
	 * Adding default styles is not the only task, it also assigns the base_url
	 * property, the default version, and text direction for the object.
	 *
	 * @since 1.0.0
	 *
	 * @param object $styles
	 */
	public static function default_styles( &$styles ) {
		$develop_src = false !== strpos( Royalcms\Component\Foundation\Royalcms::VERSION, '-src' );

		if ( ! defined( 'SCRIPT_DEBUG' ) ) {
			define( 'SCRIPT_DEBUG', $develop_src );
		}

		$styles->base_url = RC_Uri::system_static_url();
		$styles->content_url = RC_Uri::system_static_url();
		$styles->default_version = VERSION;
		$styles->text_direction = function_exists( 'is_rtl' ) && is_rtl() ? 'rtl' : 'ltr';
		$styles->default_dirs = array('/content/system/statics/');

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		// ECJia CSS
		$styles->add( 'ecjia',           			"/styles/ecjia.css" );
		$styles->add( 'ecjia-ui',           		"/styles/ecjia.ui.css", array('ecjia') );
		$styles->add( 'ecjia-function',           	"/styles/ecjia.function.css" );
		$styles->add( 'ecjia-skin-blue',         	"/styles/ecjia.skin.blue.css", array('ecjia') );


		// lib css
		$styles->add( 'bootstrap',         			"/lib/bootstrap/css/bootstrap$suffix.css" );
		$styles->add( 'bootstrap-responsive',       "/lib/bootstrap/css/bootstrap-responsive$suffix.css", array('bootstrap') );

		$styles->add( 'jquery-ui-aristo', 			"/lib/jquery-ui/css/Aristo/Aristo.css" );
		$styles->add( 'jquery-qtip', 				"/lib/qtip2/jquery.qtip$suffix.css" );
		$styles->add( 'jquery-jBreadCrumb', 		"/lib/jBreadcrumbs/css/BreadCrumb.css" );
		$styles->add( 'jquery-colorbox', 			"/lib/colorbox/colorbox.css" );
		$styles->add( 'jquery-sticky', 				"/lib/sticky/sticky.css" );

		$styles->add( 'google-code-prettify', 		"/lib/google-code-prettify/prettify.css" );
		$styles->add( 'splashy', 					"/images/splashy/splashy.css" );
		$styles->add( 'flags', 						"/images/flags/flags.css" );

		$styles->add( 'datatables-TableTools', 		"/lib/datatables/extras/TableTools/media/css/TableTools.css" );
		$styles->add( 'fontello', 					"/lib/fontello/css/fontello.css" );
		$styles->add( 'chosen', 					"/lib/chosen/chosen.css" );
		$styles->add( 'uniform-aristo', 			"/lib/uniform/Aristo/uniform.aristo.css" );

		$styles->add( 'jquery-stepy',				"/lib/stepy/css/jquery.stepy.css" );


	}


	/**
	 * Hooks to print the scripts and styles in the footer.
	 *
	 * @since 1.0.0
	 */
	public static function admin_print_footer_scripts() {
		/**
		 * Fires when footer scripts are printed.
		 *
		 * @since 1.0.0
		 */
		RC_Hook::do_action( 'admin_print_footer_scripts' );
	}

	/**
	 * Wrapper for do_action('enqueue_scripts')
	 *
	 * Allows plugins to queue scripts for the front end using wp_enqueue_script().
	 * Runs first in admin_head() where all is_home(), is_page(), etc. functions are available.
	 *
	 * @since 1.0.0
	 */
	public static function admin_enqueue_scripts() {
		/**
		 * Fires when scripts and styles are enqueued.
		 *
		 * @since 1.0.0
		 */
		RC_Hook::do_action( 'admin_enqueue_scripts' );
	}


	/**
	 * Prints the script queue in the HTML head on admin pages.
	 *
	 * Postpones the scripts that were queued for the footer.
	 * print_footer_scripts() is called in the footer to print these scripts.
	 *
	 * @since 1.0.0
	 *
	 * @see admin_print_scripts()
	 */
	public static function print_head_scripts() {
		if ( ! RC_Hook::did_action('rc_print_scripts') ) {
			RC_Hook::do_action( 'rc_print_scripts' );
		}

		RC_Script::instance()->do_head_items();

		/**
		 * Filter whether to print the head scripts.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $print Whether to print the head scripts. Default true.
		*/
		if ( RC_Hook::apply_filters( 'print_head_scripts', true ) ) {
			self::_print_scripts();
		}

		RC_Script::instance()->reset();
		return RC_Script::instance()->done;
	}


	/**
	 * Prints the scripts that were queued for the footer or too late for the HTML head.
	 *
	 * @since 1.0.0
	 */
	public static function print_footer_scripts() {
// 		if ( !is_a($wp_scripts, 'WP_Scripts') )
// 			return array(); // No need to run if not instantiated.

// 		script_concat_settings();
// 		$wp_scripts->do_concat = $concatenate_scripts;
		RC_Script::instance()->do_footer_items();

		/**
		 * Filter whether to print the footer scripts.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $print Whether to print the footer scripts. Default true.
		*/
		if ( RC_Hook::apply_filters( 'print_footer_scripts', true ) ) {
			self::_print_scripts();
		}

		RC_Script::instance()->reset();
		return RC_Script::instance()->done;
	}


	/**
	 * @internal use
	 */
	public static function _print_scripts() {

		// 		$zip = $compress_scripts ? 1 : 0;
		// 		if ( $zip && defined('ENFORCE_GZIP') && ENFORCE_GZIP )
			// 			$zip = 'gzip';

		// 		if ( $concat = trim( $wp_scripts->concat, ', ' ) ) {

		// 			if ( !empty($wp_scripts->print_code) ) {
		// 				echo "\n<script type='text/javascript'>\n";
		// 				echo "/* <![CDATA[ */\n"; // not needed in HTML 5
		// 				echo $wp_scripts->print_code;
		// 				echo "/* ]]> */\n";
		// 				echo "</script>\n";
		// 			}

		// 			$concat = str_split( $concat, 128 );
		// 			$concat = 'load%5B%5D=' . implode( '&load%5B%5D=', $concat );

		// 			$src = $wp_scripts->base_url . "/wp-admin/load-scripts.php?c={$zip}&" . $concat . '&ver=' . $wp_scripts->default_version;
		// 			echo "<script type='text/javascript' src='" . esc_attr($src) . "'></script>\n";
		// 		}

		if ( !empty(RC_Script::instance()->print_html) )
				echo RC_Script::instance()->print_html;
	}


	/**
	 * for use in *_footer_scripts hooks
	 *
	 * @since 1.0.0
	 */
	public static function _admin_footer_scripts() {
		self::print_late_styles();
		self::print_footer_scripts();
	}


	/**
	 * Prints the styles queue in the HTML head on admin pages.
	 *
	 * @since 1.0.0
	 */
	public static function print_admin_styles() {
// 		global $wp_styles, $concatenate_scripts, $compress_css;

// 		if ( !is_a($wp_styles, 'WP_Styles') )
// 			$wp_styles = new WP_Styles();

// 		script_concat_settings();
// 		RC_Style::instance()->do_concat = $concatenate_scripts;
// 		$zip = $compress_css ? 1 : 0;
// 		if ( $zip && defined('ENFORCE_GZIP') && ENFORCE_GZIP )
// 			$zip = 'gzip';

		RC_Style::instance()->do_items(false);

		/**
		 * Filter whether to print the admin styles.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $print Whether to print the admin styles. Default true.
		*/
		if ( RC_Hook::apply_filters( 'print_admin_styles', true ) ) {
			self::_print_styles();
		}

		RC_Style::instance()->reset();
		return RC_Style::instance()->done;
	}


	/**
	 * Prints the styles that were queued too late for the HTML head.
	 *
	 * @since 1.0.0
	 */
	public static function print_late_styles() {
// 		global $wp_styles, $concatenate_scripts;

// 		if ( !is_a($wp_styles, 'WP_Styles') )
// 			return;

// 		RC_Style::instance()->do_concat = $concatenate_scripts;
		RC_Style::instance()->do_footer_items();

		/**
		 * Filter whether to print the styles queued too late for the HTML head.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $print Whether to print the 'late' styles. Default true.
		*/
		if ( RC_Hook::apply_filters( 'print_late_styles', true ) ) {
			self::_print_styles();
		}

		RC_Style::instance()->reset();
		return RC_Style::instance()->done;
	}


	/**
	 * @internal use
	 */
	public static function _print_styles() {
// 		global $wp_styles, $compress_css;

// 		$zip = $compress_css ? 1 : 0;
// 		if ( $zip && defined('ENFORCE_GZIP') && ENFORCE_GZIP )
// 			$zip = 'gzip';

		if ( !empty(RC_Style::instance()->concat) ) {
// 			$dir = RC_Style::instance()->text_direction;
// 			$ver = RC_Style::instance()->default_version;
// 			$href = RC_Style::instance()->base_url . "/wp-admin/load-styles.php?c={$zip}&dir={$dir}&load=" . trim(RC_Style::instance()->concat, ', ') . '&ver=' . $ver;
// 			echo "<link rel=\"stylesheet\" href=\"" . RC_Format::esc_attr($href) . "\" type=\"text/css\" media=\"all\" />\n";

			if ( !empty(RC_Style::instance()->print_code) ) {
				echo "<style type='text/css'>\n";
				echo RC_Style::instance()->print_code;
				echo "\n</style>\n";
			}
		}

		if ( !empty(RC_Style::instance()->print_html) )
			echo RC_Style::instance()->print_html;
	}

}

// end
