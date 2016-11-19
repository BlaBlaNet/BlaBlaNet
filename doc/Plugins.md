
Creating Plugins/Addons for $Projectname
==========================================


So you want to make $Projectname do something it doesn't already do. There are lots of ways. But let's learn how to write a plugin or addon. 


In your $Projectname folder/directory, you will probably see a sub-directory called 'addon'. If you don't have one already, go ahead and create it. 


	mkdir addon

Then figure out a name for your addon. You probably have at least a vague idea of what you want it to do. For our example I'm going to create a plugin called 'randplace' that provides a somewhat random location for each of your posts. The name of your plugin is used to find the functions we need to access and is part of the function names, so to be safe, use only simple text characters.

Once you've chosen a name, create a directory beneath 'addon' to hold your working file or files.

	mkdir addon/randplace

Now create your plugin file. It needs to have the same name, and it's a PHP script, so using your favourite editor, create the file

	addon/randplace/randplace.php

The very first line of this file needs to be

	<?php

Then we're going to create a comment block to describe the plugin. There's a special format for this. We use /* ... */ comment-style and some tagged lines consisting of

	/**
	 *
	 * Name: Random Place (here you can use better descriptions than you could in the filename)
	 * Description: Sample $Projectname plugin, Sets a random place when posting.
	 * Version: 1.0
	 * Author: Mike Macgirvin <mike@zothub.com>
	 *
	 */

These tags will be seen by the site administrator when he/she installs or manages plugins from the admin panel. There can be more than one author. Just add another line starting with 'Author:'.

The typical plugin will have at least the following functions:

* pluginname_load()
* pluginname_unload()

In our case, we'll call them randplace_load() and randplace_unload(), as that is the name of our plugin. These functions are called whenever we wish to either initialise the plugin or remove it from the current webpage. Also if your plugin requires things like altering the database schema before it can run for the very first time, you would likely place these instructions in the functions named

* pluginname_install()
* pluginname_uninstall()


Next we'll talk about **hooks**. Hooks are places in $Projectname code where we allow plugins to do stuff. There are a [lot of these](help/Hooks), and they each have a name. What we normally do is use the pluginname_load() function to register a "handler function" for any hooks you are interested in. Then when any of these hooks are triggered, your code will be called.

We register hook handlers with the 'register_hook()' function. It takes 3 arguments. The first is the hook we wish to catch, the second is the filename of the file to find our handler function (relative to the base of your $Projectname installation), and the third is the function name of your handler function. So let's create our randplace_load() function right now. 


	function randplace_load() {
	    register_hook('post_local', 'addon/randplace/randplace.php', 'randplace_post_hook');

    	register_hook('feature_settings', 'addon/randplace/randplace.php', 'randplace_settings');
    	register_hook('feature_settings_post', 'addon/randplace/randplace.php', 'randplace_settings_post');

	}


So we're going to catch three events, 'post_local' which is triggered when a post is made on the local system, 'feature_settings' to set some preferences for our plugin, and 'feature_settings_post' to store those settings. 

Next we'll create an unload function. This is easy, as it just unregisters our hooks. It takes exactly the same arguments. 

	function randplace_unload() {
	    unregister_hook('post_local', 'addon/randplace/randplace.php', 'randplace_post_hook');

    	unregister_hook('feature_settings', 'addon/randplace/randplace.php', 'randplace_settings');
    	unregister_hook('feature_settings_post', 'addon/randplace/randplace.php', 'randplace_settings_post');

	}


Hooks are called with two arguments. The first is always $a, which is our global App structure and contains a huge amount of information about the state of the web request we are processing; as well as who the viewer is, and what our login state is, and the current contents of the web page we're probably constructing.

The second argument is specific to the hook you're calling. It contains information relevant to that particular place in the program, and often allows you to look at, and even change it. In order to change it, you need to add '&' to the variable name so it is passed to your function by reference. Otherwise it will create a copy and any changes you make will be lost when the hook process returns. Usually (but not always) the second argument is a named array of data structures. Please see the "hook reference" (not yet written as of this date) for details on any specific hook. Occasionally you may need to view the program source to see precisely how a given hook is called and how the results are processed. 

Let's go ahead and add some code to implement our post_local hook handler. 

	function randplace_post_hook($a, &$item) {

	    /**
    	 *
	     * An item was posted on the local system.
    	 * We are going to look for specific items:
	     *      - A status post by a profile owner
    	 *      - The profile owner must have allowed our plugin
	     *
    	 */

	    logger('randplace invoked');

	    if(! local_channel())   /* non-zero if this is a logged in user of this system */
	        return;

	    if(local_channel() != $item['uid'])    /* Does this person own the post? */
	        return;

	    if(($item['parent']) || (! is_item_normal($item))) {
		    /* If the item has a parent, or isn't "normal", this is a comment or something else, not a status post. */
	        return;
		}

	    /* Retrieve our personal config setting */

	    $active = get_pconfig(local_channel(), 'randplace', 'enable');

    	if(! $active)
        	return;
	    /**
    	 *
	     * OK, we're allowed to do our stuff.
    	 * Here's what we are going to do:
	     * load the list of timezone names, and use that to generate a list of world cities.
    	 * Then we'll pick one of those at random and put it in the "location" field for the post.
	     *
    	 */

	    $cities = array();
    	$zones = timezone_identifiers_list();
	    foreach($zones as $zone) {
    	    if((strpos($zone,'/')) && (! stristr($zone,'US/')) && (! stristr($zone,'Etc/')))
        	    $cities[] = str_replace('_', ' ',substr($zone,strpos($zone,'/') + 1));
	    }

    	if(! count($cities))
        	return;
	    $city = array_rand($cities,1);
    	$item['location'] = $cities[$city];

	    return;
	}


Now let's add our functions to create and store preference settings.

	/**
	 *
	 * Callback from the settings post function.
	 * $post contains the global $_POST array.
	 * We will make sure we've got a valid user account 
	 * and that only our own submit button was clicked
	 * and if so set our configuration setting for this person.
	 *
	 */

	function randplace_settings_post($a,$post) {
	    if(! local_channel())
	        return;
	    if($_POST['randplace-submit'])
	        set_pconfig(local_channel(),'randplace','enable',intval($_POST['randplace']));
	}



	/**
	 *
	 * Called from the Feature Setting form.
	 * The second argument is a string in this case, the HTML content region of the page.
	 * Add our own settings info to the string.
	 *
	 * For uniformity of settings pages, we use the following convention
     *     <div class="settings-block">
	 *       <h3>title</h3>
	 *       .... settings html - many elements will be floated...
	 *       <div class="clear"></div> <!-- generic class which clears all floats -->
	 *       <input type="submit" name="pluginnname-submit" class="settings-submit" ..... />
	 *     </div>
	 */



	function randplace_settings(&$a,&$s) {

	    if(! local_channel())
	        return;

	    /* Add our stylesheet to the page so we can make our settings look nice */

	    head_add_css('/addon/randplace/randplace.css');

	    /* Get the current state of our config variable */

	    $enabled = get_pconfig(local_channel(),'randplace','enable');

	    $checked = (($enabled) ? ' checked="checked" ' : '');

	    /* Add some HTML to the existing form */

	    $s .= '<div class="settings-block">';
	    $s .= '<h3>' . t('Randplace Settings') . '</h3>';
	    $s .= '<div id="randplace-enable-wrapper">';
	    $s .= '<label id="randplace-enable-label" for="randplace-checkbox">' . t('Enable Randplace Plugin') . '</label>';
	    $s .= '<input id="randplace-checkbox" type="checkbox" name="randplace" value="1" ' . $checked . '/>';
	    $s .= '</div><div class="clear"></div>';

	    /* provide a submit button */

	    $s .= '<div class="settings-submit-wrapper" ><input type="submit" name="randplace-submit" class="settings-submit" value="' . t('Submit') . '" /></div></div>';

	}


   


***Advanced Plugins***

Sometimes your plugins want to provide a range of new functionality which isn't provided at all or is clumsy to provide using hooks. In this case your plugin can also act as a 'module'. A module in our case refers to a structured webpage handler which responds to a given URL. Then anything which accesses that URL will be handled completely by your plugin.

The key to this is to create a simple function named pluginname_module() which does nothing. 

	function randplace_module() { return; }

Once this function exists, the URL https://yoursite/randplace will access your plugin as a module. Then you can define functions which are called at various points to build a webpage just like the modules in the mod/ directory. The typical functions and the order which they are called is

	modulename_init($a)    // (e.g. randplace_init($a);) called first - if you wish to emit json or xml, 
	                       // you should do it here, followed by killme() which will avoid the default action of building a webpage
	modulename_aside($a)   // Often used to create sidebar content
	modulename_post($a)    // Called whenever the page is accessed via the "post" method
	modulename_content($a) // called to generate the central page content. This function should return a string 
	                       // consisting of the central page content.

Your module functions have access to the URL path as if they were standalone programs in the Unix operating system. For instance if you visit the page
	
	https://yoursite/randplace/something/somewhere/whatever

we will create an argc/argv list for use by your module functions

	$x = argc(); $x will be 4, the number of path arguments after the sitename

	for($x = 0; $x < argc(); $x ++)
		echo $x . ' ' . argv($x);


	0 randplace
	1 something
	2 somewhere
	3 whatever


***Porting Friendica Plugins***

$Projectname uses a similar plugin architecture to the Friendica project. The authentication, identity, and permissions systems are completely different. Many Friendica plugins can be ported reasonably easily by renaming a few functions - and then ensuring that the permissions model is adhered to. The functions which need to be renamed are:

* Friendica's pluginname_install() is pluginname_load()

* Friendica's pluginname_uninstall() is pluginname_unload()

$Projectname has _install and _uninstall functions but these are used differently.

* Friendica's "plugin_settings" hook is called "feature_settings"

* Friendica's "plugin_settings_post" hook is called "feature_settings_post"

Changing these will often allow your plugin to function, but please double check all your permission and identity code because the concepts behind it are completely different in $Projectname. Many structured data names (especially DB schema columns) are also quite different. 

#include doc/macros/main_footer.bb;
