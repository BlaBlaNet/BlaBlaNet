<?php
namespace Zotlabs\Module;




class Webfinger extends \Zotlabs\Web\Controller {

	function get() {
	
	
		$o .= '<h3>Webfinger Diagnostic</h3>';
	
		$o .= '<form action="webfinger" method="get">';
		$o .= 'Lookup address: <input type="text" style="width: 250px;" name="addr" value="' . $_GET['addr'] .'" />';
		$o .= '<input type="submit" name="submit" value="Submit" /></form>'; 
	
		$o .= '<br /><br />';
		
		$old = false;
		if(x($_GET,'addr')) {
			$addr = trim($_GET['addr']);
	//		if(strpos($addr,'@') !== false) {
				$res = webfinger_rfc7033($addr,true);
				if(! $res) {
					$res = old_webfinger($addr);
					$old = true;
				}
	//		}
	//		else {
	//			if(function_exists('lrdd'))
	//				$res = lrdd($addr);
	//		}
	
			if($res && $old) {
				foreach($res as $r) {
					if($r['@attributes']['rel'] === 'http://microformats.org/profile/hcard') {
						$hcard = unamp($r['@attributes']['href']);
						require_once('library/HTML5/Parser.php');
						$res['vcard'] = scrape_vcard($hcard);
						break;
					}
				}
			}
	
	
			$o .= '<pre>';
			$o .= str_replace("\n",'<br />',print_r($res,true));
			$o .= '</pre>';
		}
		return $o;
	}
	
}
