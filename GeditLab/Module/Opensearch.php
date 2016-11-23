<?php
namespace GeditLab\Module;


class Opensearch extends \GeditLab\Web\Controller {

	function init() {
	    	
		$tpl = get_markup_template('opensearch.tpl');
		
		header("Content-type: application/opensearchdescription+xml");
		
		$o = replace_macros($tpl, array(
			'$baseurl'  => z_root(),
			'$nodename' => \App::get_hostname(),
		));
			
		echo $o;
			
		killme();
			
	}
	
}
