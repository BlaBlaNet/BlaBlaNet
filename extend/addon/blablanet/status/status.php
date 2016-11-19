<?php

/**
 * Name: BB  Status Network
 * Description: BB Status  Network
 * Version: 1.1
 * Author: Jacob M.
 */


function status_load() {
    register_hook('app_menu', 'addon/status/status.php', 'status_app_menu');
}

function status_unload() {
    unregister_hook('app_menu', 'addon/status/status.php', 'status_app_menu');

}

function status_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="status">BlaBlaNet Server Status and Help</a></div>';
}


function status_module() {}


function status_content($a) {

$baseurl = z_root() . '/addon/status';
$o .= <<< EOT
<br><br>
<p align="left"> 
<object width="975" height="900" data="https://support.blablanet.com/"></object>
</p>
<br><br>
<b>@Blablanet.com </b><br>
</p>

</p>
EOT;

    return $o;
}

