<?php
namespace GeditLab\Module;

require_once('include/socgraph.php');


class Xpoco extends \GeditLab\Web\Controller {

	function init() {
		poco($a,true);
	}
	
}
