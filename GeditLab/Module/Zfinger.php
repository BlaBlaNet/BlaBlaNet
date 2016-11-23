<?php
namespace GeditLab\Module;


class Zfinger extends \GeditLab\Web\Controller {

	function init() {
	
		require_once('include/zot.php');
		require_once('include/crypto.php');
	
	
		$x = zotinfo($_REQUEST);
		json_return_and_die($x);
	
	}
	
}
