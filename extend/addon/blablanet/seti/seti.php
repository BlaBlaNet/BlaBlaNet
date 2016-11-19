<?php

/**
 * Name: Latest BlaBlaNet Seti Partners
 * Description: BlaBlaNet Seti Partners 
 * Version: 1.1
 * Author: Jacob M.
 */


function seti_load() {
    register_hook('app_menu', 'addon/seti/seti.php', 'seti_app_menu');
}

function seti_unload() {
    unregister_hook('app_menu', 'addon/seti/seti.php', 'seti_app_menu');

}

function seti_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="seti">BlaBlaNet Seti Partner</a></div>';
}


function seti_module() {}


function seti_content($a) {

$baseurl = z_root() . '/addon/seti';
$o .= <<< EOT
<br><br>
<p align="left"> 
<object width="975" height="900" data="https://blablanet.site/"></object>
</p>
<br><br>
<b>Visit the Wiki to Participate in the Project https://blablanet.com/wiki/blablanet/BlaBlaNet+BOINC+Partner+Seti+Project/Home </b><br>
</p>

</p>
EOT;

    return $o;
}
