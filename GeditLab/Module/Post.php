<?php
namespace GeditLab\Module;

/**
 * @file mod/post.php
 *
 * @brief Zot endpoint.
 *
 */

require_once('include/zot.php');


class Post extends \GeditLab\Web\Controller {

	function init() {
	
		if (array_key_exists('auth', $_REQUEST)) {
			$x = new \GeditLab\Zot\Auth($_REQUEST);
			exit;
		}
	
	}
	
	
		function post() {
	
		$z = new \GeditLab\Zot\Receiver($_REQUEST['data'],get_config('system','prvkey'), new \GeditLab\Zot\ZotHandler());
		
		// notreached;
	
		exit;
	
	}
	
}
