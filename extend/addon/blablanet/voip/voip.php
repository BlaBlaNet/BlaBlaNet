<?php

/**
 * Name: Latest BlaBlaNet voip Partners
 * Description: BlaBlaNet  Voip Service provider 
 * Version: 1.1
 * Author: Jacob M.
 */


function voip_load() {
    register_hook('app_menu', 'addon/voip/voip.php', 'voip_app_menu');
}

function voip_unload() {
    unregister_hook('app_menu', 'addon/voip/voip.php', 'voip_app_menu');

}

function voip_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="voip">BlaBlaNet voip Partner</a></div>';
}


function voip_module() {}


function voip_content($a) {

$baseurl = z_root() . '/addon/voip';
$o .= <<< EOT
<br><br>
<p align="left"> 
<object width="975" height="900" data="https://blavoice.com/"></object>
</p>
<br><br>
<b>Visit https://blavoice.com </b><br>
</p>

</p>
EOT;

    return $o;
}
