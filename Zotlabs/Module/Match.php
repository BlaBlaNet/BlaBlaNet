<?php
namespace Zotlabs\Module;

/**
 * @brief Controller for /match.
 *
 * It takes keywords from your profile and queries the directory server for
 * matching keywords from other profiles.
 *
 * @FIXME this has never been properly ported from Friendica.
 *
 * @param App &$a
 * @return void|string
 */

class Match extends \Zotlabs\Web\Controller {

	function get() {
	
		$o = '';
		if (! local_channel())
			return;
	
		$_SESSION['return_url'] = z_root() . '/' . \App::$cmd;
	
		$o .= '<h2>' . t('Profile Match') . '</h2>';
	
		$r = q("SELECT `keywords` FROM `profile` WHERE `is_default` = 1 AND `uid` = %d LIMIT 1",
			intval(local_channel())
		);
		if (! count($r))
			return;
	
		if (! $r[0]['keywords']) {
			notice( t('No keywords to match. Please add keywords to your default profile.') . EOL);
			return;
		}
	
		$params = array();
		$tags = trim($r[0]['keywords']);
	
		if ($tags) {
			$params['s'] = $tags;
			if (\App::$pager['page'] != 1)
				$params['p'] = \App::$pager['page'];
	
	//		if(strlen(get_config('system','directory_submit_url')))
	//			$x = post_url('http://dir.friendica.com/msearch', $params);
	//		else
	//			$x = post_url(z_root() . '/msearch', $params);
	
			$j = json_decode($x);
	
			if ($j->total) {
				\App::set_pager_total($j->total);
				\App::set_pager_itemspage($j->items_page);
			}
	
			if (count($j->results)) {
				$tpl = get_markup_template('match.tpl');
				foreach ($j->results as $jj) {
					$connlnk = z_root() . '/follow/?url=' . $jj->url;
					$o .= replace_macros($tpl,array(
						'$url' => zid($jj->url),
						'$name' => $jj->name,
						'$photo' => $jj->photo,
						'$inttxt' => ' ' . t('is interested in:'),
						'$conntxt' => t('Connect'),
						'$connlnk' => $connlnk,
						'$tags' => $jj->tags
					));
				}
			} else {
				info( t('No matches') . EOL);
			}
		}
	
		$o .= cleardiv();
		$o .= paginate($a);
	
		return $o;
	}
	
}
