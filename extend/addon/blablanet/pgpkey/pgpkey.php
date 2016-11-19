<?php

/**
 * Name: PGP Key Server 
 * Description: PGP Key Server Blablanet.info.
 * Version: 1.1
 * Author: Jacob M.
 */


function pgpkey_load() {
    register_hook('app_menu', 'addon/pgpkey/pgpkey.php', 'pgpkey_app_menu');
}

function pgpkey_unload() {
    unregister_hook('app_menu', 'addon/pgpkey/pgpkey.php', 'pgpkey_app_menu');

}

function pgpkey_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="pgpkey">Ultimas pgpkey</a></div>';
}


function pgpkey_module() {}


function pgpkey_content($a) {

$baseurl = z_root() . '/addon/pgpkey';
$o .= <<< EOT
<br><br>
<p align="left">
<object width="975" height="900" data="https://blablanet.info"></object>
<br><br>
<b>Check or ADD your PGP KEYS -- by BlaBlaNet Security Group</b><br>
</p>

</p>
EOT;

    return $o;
}

