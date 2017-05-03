<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('cycleimage', RC_Lang::get('cycleimage::flashplay.cycle_image'));
}

function get_url_image($url) {
	$ext = strtolower(end(explode('.', $url)));
	if ($ext != "gif" && $ext != "jpg" && $ext != "png" && $ext != "bmp" && $ext != "jpeg") {
		return $url;
	}

	$name = date('Ymd');
	for ($i = 0; $i < 6; $i++) {
		$name .= chr(mt_rand(97, 122));
	}
	$name  .= '.' . $ext;
	$target = ROOT_PATH . DATA_DIR . '/afficheimg/' . $name;

    $tmp_file = DATA_DIR . '/afficheimg/' . $name;
    $filename = ROOT_PATH . $tmp_file;

    $img      = file_get_contents($url);

    $fp       = @fopen($filename, "a");
    fwrite($fp, $img);
	fclose($fp);

	return $tmp_file;
}

// end