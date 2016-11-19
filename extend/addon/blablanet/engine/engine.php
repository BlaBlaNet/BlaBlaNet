<?php

/**
 * Name: Latest engine 
 * Description: Latest engine 
 * Version: 1.1
 * Author: Jacob M.
 */


function engine_load() {
    register_hook('app_menu', 'addon/engine/engine.php', 'engine_app_menu');
}

function engine_unload() {
    unregister_hook('app_menu', 'addon/engine/engine.php', 'engine_app_menu');

}

function engine_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="engine">Latest engine</a></div>';
}


function engine_module() {}


function engine_content($a) {
$baseurl = z_root() . '/addon/engine';
$o .= <<< EOT
<br><br>
<object width="975" height="900" data="https://blablanet.eu"></object>
<br><br>


EOT;
return $o;
}
