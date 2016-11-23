<?php
namespace GeditLab\Module;


class Toggle_mobile extends \GeditLab\Web\Controller {

	function init() {
	
		if(isset($_GET['off']))
			$_SESSION['show_mobile'] = false;
		else
			$_SESSION['show_mobile'] = true;
	
		if(isset($_GET['address']))
			$address = $_GET['address'];
		else
			$address = z_root();
	
		goaway($address);
	}
	
	
}
