<?php
/**
 * Name: Random Planet, Empirial Version
 * Description: Sample Friendica plugin/addon. Set a random planet from the Emprire when posting.
 * Version: 1.0
 * Author: Mike Macgirvin <http://macgirvin.com/profile/mike>
 * Author: Tony Baldwin <https://free-haven.org/profile/tony>
 * Maintainer: none
 */


function planets_load() {

	/**
	 * 
	 * Our demo plugin will attach in three places.
	 * The first is just prior to storing a local post.
	 *
	 */

	register_hook('post_local', 'addon/planets/planets.php', 'planets_post_hook');

	/**
	 *
	 * Then we'll attach into the plugin settings page, and also the 
	 * settings post hook so that we can create and update
	 * user preferences.
	 *
	 */

	register_hook('feature_settings', 'addon/planets/planets.php', 'planets_settings');
	register_hook('feature_settings_post', 'addon/planets/planets.php', 'planets_settings_post');

	logger("loaded planets");
}


function planets_unload() {

	/**
	 *
	 * unload unregisters any hooks created with register_hook
	 * during load. It may also delete configuration settings
	 * and any other cleanup.
	 *
	 */

	unregister_hook('post_local',    'addon/planets/planets.php', 'planets_post_hook');
	unregister_hook('feature_settings', 'addon/planets/planets.php', 'planets_settings');
	unregister_hook('feature_settings_post', 'addon/planets/planets.php', 'planets_settings_post');


	logger("removed planets");
}



function planets_post_hook($a, &$item) {

	/**
	 *
	 * An item was posted on the local system.
	 * We are going to look for specific items:
	 *      - A status post by a profile owner
	 *      - The profile owner must have allowed our plugin
	 *
	 */

	logger('planets invoked');

	if(! local_channel())   /* non-zero if this is a logged in user of this system */
		return;

	if(local_channel() != $item['uid'])    /* Does this person own the post? */
		return;

	if($item['parent'])   /* If the item has a parent, this is a comment or something else, not a status post. */
		return;

	/* Retrieve our personal config setting */

	$active = get_pconfig(local_channel(), 'planets', 'enable');

	if(! $active)
		return;

	/**
	 *
	 * OK, we're allowed to do our stuff.
	 * Here's what we are going to do:
	 * load the list of timezone names, and use that to generate a list of world planets.
	 * Then we'll pick one of those at random and put it in the "location" field for the post.
	 *
	 */

	$planets = array('Alderaan','Tatooine','Dagoba','Polis Massa','Coruscant','Hoth','Endor','Kamino','Rattatak','Mustafar','Iego','Geonosis','Felucia','Dantooine','Ansion','Artaru','Bespin','Boz Pity','Cato Neimoidia','Christophsis','Kashyyk','Kessel','Malastare','Mygeeto','Nar Shaddaa','Ord Mantell','Saleucami','Subterrel','Death Star','Teth','Tund','Utapau','Yavin');

	$planet = array_rand($planets,1);
	$item['location'] = '#[url=http://starwars.com]' . $planets[$planet] . '[/url]';

	return;
}




/**
 *
 * Callback from the settings post function.
 * $post contains the $_POST array.
 * We will make sure we've got a valid user account
 * and if so set our configuration setting for this person.
 *
 */

function planets_settings_post($a,$post) {
	if(! local_channel())
		return;
	if($_POST['planets-submit']) {
		set_pconfig(local_channel(),'planets','enable',intval($_POST['planets']));
		info( t('Planets Settings updated.') . EOL);
	}
}


/**
 *
 * Called from the Plugin Setting form. 
 * Add our own settings info to the page.
 *
 */



function planets_settings(&$a,&$s) {

	if(! local_channel())
		return;

	/* Add our stylesheet to the page so we can make our settings look nice */

	//App::$page['htmlhead'] .= '<link rel="stylesheet"  type="text/css" href="' . z_root() . '/addon/planets/planets.css' . '" media="all" />' . "\r\n";

	/* Get the current state of our config variable */

	$enabled = get_pconfig(local_channel(),'planets','enable');

	$checked = (($enabled) ? 1 : false);

	/* Add some HTML to the existing form */

	$sc .= replace_macros(get_markup_template('field_checkbox.tpl'), array(
		'$field'	=> array('planets', t('Enable Planets Plugin'), $checked, '', array(t('No'),t('Yes'))),
	));

	$s .= replace_macros(get_markup_template('generic_addon_settings.tpl'), array(
		'$addon' 	=> array('planets',t('Planets Settings'), '', t('Submit')),
		'$content'	=> $sc
	));
}
