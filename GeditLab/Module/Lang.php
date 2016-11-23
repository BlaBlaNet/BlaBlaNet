<?php
namespace GeditLab\Module;


class Lang extends \GeditLab\Web\Controller {

	function get() {
		return lang_selector();
	}
	
	
}
