[b]Plugins[/b]

So you want to make $Projectname do something it doesn't already do. There are lots of ways. But let's learn how to write a plugin or addon. 


In your $Projectname folder/directory, you will probably see a sub-directory called 'addon'. If you don't have one already, go ahead and create it. 
[code]
	mkdir addon
[/code]
Then figure out a name for your addon. You probably have at least a vague idea of what you want it to do. For our example I'm going to create a plugin called 'randplace' that provides a somewhat random location for each of your posts. The name of your plugin is used to find the functions we need to access and is part of the function names, so to be safe, use only simple text characters.

Once you've chosen a name, create a directory beneath 'addon' to hold your working file or files.
[code]
	mkdir addon/randplace
[/code]
Now create your plugin file. It needs to have the same name, and it's a PHP script, so using your favourite editor, create the file
[code]
	addon/randplace/randplace.php
[/code]
The very first line of this file needs to be
[code]
	&lt;?php
[/code]
Then we're going to create a comment block to describe the plugin. There's a special format for this. We use /* ... */ comment-style and some tagged lines consisting of
[code]
	/**
	 *
	 * Name: Random Place (here you can use better descriptions than you could in the filename)
	 * Description: Sample $Projectname plugin, Sets a random place when posting.
	 * Version: 1.0
	 * Author: Mike Macgirvin &lt;mike@zothub.com&gt;
	 *
	 */
[/code]
These tags will be seen by the site administrator when he/she installs or manages plugins from the admin panel. There can be more than one author. Just add another line starting with 'Author:'.

The typical plugin will have at least the following functions:
[code]
 pluginname_load()
 pluginname_unload()
[/code]
In our case, we'll call them randplace_load() and randplace_unload(), as that is the name of our plugin. These functions are called whenever we wish to either initialise the plugin or remove it from the current webpage. Also if your plugin requires things like altering the database schema before it can run for the very first time, you would likely place these instructions in the functions named
[code]
 pluginname_install()
 pluginname_uninstall()
[/code]

Next we'll talk about [b]hooks[/b]. Hooks are places in $Projectname code where we allow plugins to do stuff. There are a [url=[baseurl]/help/hooklist]lot of these[/url], and they each have a name. What we normally do is use the pluginname_load() function to register a &quot;handler function&quot; for any hooks you are interested in. Then when any of these hooks are triggered, your code will be called.

We register hook handlers with the 'Zotlabs\Extend\Hook::register()' function. It typically takes 3 arguments. The first is the hook we wish to catch, the second is the filename of the file to find our handler function (relative to the base of your $Projectname installation), and the third is the function name of your handler function. So let's create our randplace_load() function right now. 

[code]
	function randplace_load() {
	    Zotlabs\Extend\Hook::register('post_local', 'addon/randplace/randplace.php', 'randplace_post_hook');

        Zotlabs\Extend\Hook::register('feature_settings', 'addon/randplace/randplace.php', 'randplace_settings');
	    Zotlabs\Extend\Hook::register('feature_settings_post', 'addon/randplace/randplace.php', 'randplace_settings_post');

	}
[/code]

So we're going to catch three events, 'post_local' which is triggered when a post is made on the local system, 'feature_settings' to set some preferences for our plugin, and 'feature_settings_post' to store those settings. 

Next we'll create an unload function. This is easy, as it just unregisters our hooks. It takes exactly the same arguments. 
[code]
	function randplace_unload() {
	    Zotlabs\Extend\Hook::unregister('post_local', 'addon/randplace/randplace.php', 'randplace_post_hook');

        Zotlabs\Extend\Hook::unregister('feature_settings', 'addon/randplace/randplace.php', 'randplace_settings');
	    Zotlabs\Extend\Hook::unregister('feature_settings_post', 'addon/randplace/randplace.php', 'randplace_settings_post');
	}
[/code]

Hooks are always called with one argument which is specific to the hook you're calling. It contains information relevant to that particular place in the program, and often allows you to look at, and even change it. In order to change it, you need to add '&amp;' to the variable name so it is passed to your function by reference. Otherwise it will create a copy and any changes you make will be lost when the hook process returns. Usually (but not always) the passed data is a named array of data structures. Please see the &quot;hook reference&quot; (not yet written as of this date) for details on any specific hook. Occasionally you may need to view the program source to see precisely how a given hook is called and how the results are processed. 

Let's go ahead and add some code to implement our post_local hook handler. 
[code]
	function randplace_post_hook(&amp;$item) {

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
		    /* If the item has a parent, or is not "normal", this is a comment or something else, not a status post. */
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
    	 * Then we'll pick one of those at random and put it in the &quot;location&quot; field for the post.
	     *
    	 */

	    $cities = array();
    	$zones = timezone_identifiers_list();
	    foreach($zones as $zone) {
    	    if((strpos($zone,'/')) &amp;&amp; (! stristr($zone,'US/')) &amp;&amp; (! stristr($zone,'Etc/')))
        	    $cities[] = str_replace('_', ' ',substr($zone,strpos($zone,'/') + 1));
	    }

    	if(! count($cities))
        	return;
	    $city = array_rand($cities,1);
    	$item['location'] = $cities[$city];

	    return;
	}
[/code]

Now let's add our functions to create and store preference settings.
[code]
	/**
	 *
	 * Callback from the settings post function.
	 * $post contains the global $_POST array.
	 * We will make sure we've got a valid user account 
	 * and that only our own submit button was clicked
	 * and if so set our configuration setting for this person.
	 *
	 */

	function randplace_settings_post($post) {
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
     *     &lt;div class=&quot;settings-block&quot;&gt;
	 *       &lt;h3&gt;title&lt;/h3&gt;
	 *       .... settings html - many elements will be floated...
	 *       &lt;div class=&quot;clear&quot;&gt;&lt;/div&gt; &lt;!-- generic class which clears all floats --&gt;
	 *       &lt;input type=&quot;submit&quot; name=&quot;pluginnname-submit&quot; class=&quot;settings-submit&quot; ..... /&gt;
	 *     &lt;/div&gt;
	 */



	function randplace_settings(&amp;$s) {

	    if(! local_channel())
	        return;

	    /* Add our stylesheet to the page so we can make our settings look nice */

	    head_add_css(/addon/randplace/randplace.css');

	    /* Get the current state of our config variable */

	    $enabled = get_pconfig(local_channel(),'randplace','enable');

	    $checked = (($enabled) ? ' checked=&quot;checked&quot; ' : '');

	    /* Add some HTML to the existing form */

	    $s .= '&lt;div class=&quot;settings-block&quot;&gt;';
	    $s .= '&lt;h3&gt;' . t('Randplace Settings') . '&lt;/h3&gt;';
	    $s .= '&lt;div id=&quot;randplace-enable-wrapper&quot;&gt;';
	    $s .= '&lt;label id=&quot;randplace-enable-label&quot; for=&quot;randplace-checkbox&quot;&gt;' . t('Enable Randplace Plugin') . '&lt;/label&gt;';
	    $s .= '&lt;input id=&quot;randplace-checkbox&quot; type=&quot;checkbox&quot; name=&quot;randplace&quot; value=&quot;1&quot; ' . $checked . '/&gt;';
	    $s .= '&lt;/div&gt;&lt;div class=&quot;clear&quot;&gt;&lt;/div&gt;';

	    /* provide a submit button */

	    $s .= '&lt;div class=&quot;settings-submit-wrapper&quot; &gt;&lt;input type=&quot;submit&quot; name=&quot;randplace-submit&quot; class=&quot;settings-submit&quot; value=&quot;' . t('Submit') . '&quot; /&gt;&lt;/div&gt;&lt;/div&gt;';

	}

[/code]
   


[h2]Advanced Plugins[/h2]

Sometimes your plugins want to provide a range of new functionality which isn't provided at all or is clumsy to provide using hooks. In this case your plugin can also act as a 'module'. A module in our case refers to a structured webpage handler which responds to a given URL. Then anything which accesses that URL will be handled completely by your plugin.

There are two ways to accomplish this. To create a module object use the following model:
[code]
<?php     /* file: addon/randplace/Mod_Randplace.php */
namespace Zotlabs\Module;

	// Your module will consist of the name of your addon with an uppercase first character, within the Zotlabs\Module namespace
	// To avoid namespace conflicts with your plugin, the convention we're using is to name the module file Mod_Addonname.php
	// In this case 'Mod_Randplace.php' and then include it from within your main plugin file 'randplace.php' with the line:
	//
	// require_once('addon/randplace/Mod_Randplace.php');
	
	class Randplace extends \Zotlabs\Web\Controller {
		function init() { 
			// init method is always called first if it exists 
		}
		function post() { 
			// the post method is only called if there are $_POST variables present (e.g. the page request method is "post")
		}
		function get() {
			// The get method is used to display normal content on the page
			// whatever this function returns will be displayed in the page body
		}
	}
[/code]

The other option is to use a procedural interface. The $a argument to these function is obsolete, but must be present. 
The key to this is to create a simple function named pluginname_module() which does nothing. These lines and this interface
can be used inside your addon file without causing a namespace conflict, as the object method will. 

[code]
	function randplace_module() { return; }
[/code]
Once this function exists, the URL #^[url=https://yoursite/randplace]https://yoursite/randplace[/url] will access your plugin as a module. Then you can define functions which are called at various points to return or process a structured webpage just like system modules. The typical functions and the order which they are called is
[code]
	modulename_init($a)    // (e.g. randplace_init($a);) called first - if you wish to emit json or xml, 
	                       // you should do it here, followed by killme() which will avoid the default action of building a webpage
	modulename_post($a)    // Called whenever the page is accessed via the &quot;post&quot; method
	modulename_content($a) // called to generate the central page content. This function should return a string 
	                       // consisting of the central page content.
[/code]
Your module functions have access to the URL path as if they were standalone programs in the Unix operating system. For instance if you visit the page
[code]
	https://yoursite/randplace/something/somewhere/whatever
[/code]
we will create an argc/argv list for use by your module functions
[code]
	$x = argc(); // $x will be 4, the number of path arguments after the sitename

	for($x = 0; $x &lt; argc(); $x ++)
		echo $x . ' ' . argv($x);


	0 randplace
	1 something
	2 somewhere
	3 whatever
[/code]

[h3]Using class methods as hook handler functions[/h3]

To register a hook using a class method as a callback, a couple of things need to be considered. The first is that the functions need to be declared static public so that they are available from all contexts, and they need to have a namespace attached because they can be called from within multiple namespaces. You can then register them as strings or arrays (using the PHP internal calling method). 

[code]
<?php
/*
 * plugin info block goes here
 */

function myplugin_load() {
	Zotlabs\Extend\Hook::register('hook_name','addon/myplugin/myplugin.php','\\Myplugin::foo');
[b]or[/b]
	Zotlabs\Extend\Hook::register('hook_name','addon/myplugin/myplugin.php',array('\\Myplugin','foo'));
}
 
class Myplugin {

	public static function foo($params) {
		// handler for 'hook_name'
	}
}
[/code]

If you want to keep your plugin hidden from the siteinfo page, simply create a file called '.hidden' in your addon directory
[code]
	touch addon/<addon name>/.hidden
[/code]

***Porting Friendica Plugins***

$Projectname uses a similar plugin architecture to the Friendica project. The authentication, identity, and permissions systems are completely different. Many Friendica can be ported reasonably easily by renaming a few functions - and then ensuring that the permissions model is adhered to. The functions which need to be renamed are:

[li] Friendica's pluginname_install() is pluginname_load()[/li]

[li] Friendica's pluginname_uninstall() is pluginname_unload()[/li]

$Projectname has _install and _uninstall functions but these are used differently.

[li] Friendica's &quot;plugin_settings&quot; hook is called &quot;feature_settings&quot;[/li]

[li] Friendica's &quot;plugin_settings_post&quot; hook is called &quot;feature_settings_post&quot;[/li]

Changing these will often allow your plugin to function, but please double check all your permission and identity code because the concepts behind it are completely different in $Projectname. Many structured data names (especially DB schema columns) are also quite different.

#include doc/macros/main_footer.bb;
