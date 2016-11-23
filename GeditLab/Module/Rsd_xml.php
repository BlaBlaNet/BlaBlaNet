<?php
namespace GeditLab\Module;

class Rsd_xml extends \GeditLab\Web\Controller {

	function init() {
		header ("Content-Type: text/xml");
		echo replace_macros(get_markup_template('rsd.tpl'),array(
			'$project' => \GeditLab\Lib\System::get_platform_name(),
			'$baseurl' => z_root(),
			'$apipath' => z_root() . '/api/'
		));
		killme();
	}

}

