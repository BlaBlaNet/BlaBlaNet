<?php
namespace GeditLab\Module;
/**
 * load view/theme/$current_theme/style.php with BlaBlaNet context
 */
 

class View extends \GeditLab\Web\Controller {

	function init() {
		header("Content-Type: text/css");
			
		$theme = argv(2);
		$THEMEPATH = "view/theme/$theme";
		if(file_exists("view/theme/$theme/php/style.php"))
			require_once("view/theme/$theme/php/style.php");	
		killme();
	}
	
}
