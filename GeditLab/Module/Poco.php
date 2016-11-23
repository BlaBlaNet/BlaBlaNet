<?php
namespace GeditLab\Module;

require_once('include/socgraph.php');


class Poco extends \GeditLab\Web\Controller {

	function init() {
		poco($a,false);
	}
	
}
