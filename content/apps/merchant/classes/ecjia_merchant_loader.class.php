<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_merchant_loader {
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
		$base_url = dirname(RC_App::app_dir_url(__FILE__)) . '/statics';

		$scripts->remove('jquery');
		$scripts->remove('bootstrap');

		$scripts->add( 'bootstrap', 		        $base_url.'/mh-js/bootstrap.min.js' );
		$scripts->add( 'jquery', 			        $base_url.'/mh-js/jquery-1.11.1.min.js' );
		$scripts->add( 'ecjia-merchant', 			$base_url.'/ecjia/ecjia-merchant.js', array('jquery', 'ecjia') );
		$scripts->add( 'ecjia-merchant-ui', 		$base_url.'/ecjia/ecjia-merchant-ui.js', array('jquery', 'ecjia') );

		// 添加 merchant-template-js
		$scripts->add( 'ecjia-mh-jquery-customSelect',   $base_url.'/mh-js/jquery.customSelect.min.js', array('jquery'), false, 1 );

	    $scripts->add( 'ecjia-mh-jquery-dcjqaccordion',  $base_url.'/mh-js/jquery.dcjqaccordion.2.7.min.js', array('jquery'), false, 1 );

		$scripts->add( 'ecjia-mh-jquery-nicescroll',     $base_url.'/mh-js/jquery.nicescroll.js', array('jquery'), false, 1 );
		$scripts->add( 'ecjia-mh-jquery-scrollTo',  $base_url.'/mh-js/jquery.scrollTo.min.js', array('jquery'), false, 1 );
		$scripts->add( 'ecjia-mh-jquery-sparkline', $base_url.'/mh-js/jquery.sparkline.js', array('jquery'), false, 1 );
		$scripts->add( 'ecjia-mh-jquery-stepy',     $base_url.'/mh-js/jquery.stepy.js', array('jquery'), false, 1 );
		$scripts->add( 'ecjia-mh-jquery-tagsinput', $base_url.'/mh-js/jquery.tagsinput.js', array('jquery'), false, 1 );
		$scripts->add( 'ecjia-mh-jquery-validate',  $base_url.'/mh-js/jquery.validate.min.js', array('jquery'), false, 1 );
		$scripts->add( 'ecjia-mh-jquery-actual',   	$base_url.'/mh-js/jquery-actual.min.js', array('jquery'), false, 1 );
		$scripts->add( 'ecjia-mh-jquery-migrate',   $base_url.'/mh-js/jquery-migrate.min.js', array('jquery'), false, 1 );
		$scripts->add( 'ecjia-mh-jquery-quicksearch',   $base_url.'/mh-js/jquery.quicksearch.js', array('jquery'), false, 1 );

		$scripts->add( 'ecjia-mh-jquery-easy-pie-chart',  $base_url.'/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js', array('jquery'), false, 1 );

		$scripts->add( 'ecjia-mh-owl-carousel',     $base_url.'/mh-js/owl.carousel.js', array(), false, 1 );
		$scripts->add( 'ecjia-mh-respond',          $base_url.'/mh-js/respond.min.js', array(), false, 1 );
		$scripts->add( 'ecjia-mh-sparkline-chart',  $base_url.'/mh-js/sparkline-chart.js', array(), false, 1 );

		$scripts->add( 'ecjia-mh-chosen-jquery',    $base_url.'/assets/chosen/chosen.jquery.min.js', array(), false, 1 );
		$scripts->add( 'ecjia-mh-chart',    $base_url.'/assets/Chart/Chart.min.js', array(), false, 1 );

		$scripts->add( 'ecjia-mh-bootstrap-fileupload-js',	$base_url.'/assets/bootstrap-fileupload/bootstrap-fileupload.js', array(), false, 1 );
		$scripts->add( 'ecjia-mh-editable-js',    $base_url.'/assets/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, 1 );
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
		$base_url = dirname(RC_App::app_dir_url(__FILE__)) . '/statics';

		$styles->remove('bootstrap');
		$styles->remove('bootstrap-reset');

		$styles->add( 'bootstrap',         	              $base_url."/mh-css/bootstrap.min.css" );
		$styles->add( 'bootstrap-reset',                  $base_url."/mh-css/bootstrap-reset.css" );
		$styles->add( 'ecjia-merchant-ui',		          $base_url."/mh-css/ecjia-merchant.ui.css", array('bootstrap') );

		// lib css
		$styles->add( 'ecjia-mh-font-awesome',            $base_url."/mh-css/font-awesome.min.css" );
		$styles->add( 'ecjia-mh-owl-carousel',            $base_url."/mh-css/owl.carousel.css" );
		$styles->add( 'ecjia-mh-owl-theme',               $base_url."/mh-css/owl.theme.css" );
		$styles->add( 'ecjia-mh-owl-transitions',         $base_url."/mh-css/owl.transitions.css" );
		$styles->add( 'ecjia-mh-table-responsive',        $base_url."/mh-css/table-responsive.css" );

		$styles->add( 'ecjia-mh-jquery-easy-pie-chart',   $base_url."/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" );

		$styles->add( 'ecjia-mh-function',         		  $base_url."/mh-css/ecjia.function.css" );
		$styles->add( 'ecjia-mh-page',         		      $base_url."/mh-css/page.css" );
		$styles->add( 'ecjia-mh-chosen',         		  $base_url."/assets/chosen/chosen.css" );

		$styles->add( 'googleapis-fonts',         	      $base_url."/mh-css/fonts/fonts.googleapis.css" );

		$styles->add( 'ecjia-mh-bootstrap-fileupload-css', $base_url."/assets/bootstrap-fileupload/bootstrap-fileupload.css" );
		$styles->add( 'ecjia-mh-editable-css', $base_url.'/assets/x-editable/bootstrap-editable/css/bootstrap-editable.css' );
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
