<?php
namespace GeditLab\Module;


class Siteinfo_json extends \GeditLab\Web\Controller {

	function init() {
	
		$data = get_site_info();
		json_return_and_die($data);
	
	}
	
}
