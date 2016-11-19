<?php

/**
 * Name: Nouvelles du monde
 * Description: Nouvelles du monde
 * Version: 1.0
 * Author: Jacob M.
 */


function nouvelles_load() {
    register_hook('app_menu', 'addon/nouvelles/nouvelles.php', 'nouvelles_app_menu');
}

function nouvelles_unload() {
    unregister_hook('app_menu', 'addon/nouvelles/nouvelles.php', 'nouvelles_app_menu');

}

function nouvelles_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="nouvelles">Ultimas nouvelles</a></div>';
}


function nouvelles_module() {}


function nouvelles_content($a) {
$baseurl = z_root() . '/addon/news';
$o .= <<< EOT
<br><br>
<p align="left">
<object width="975" height="900" data="https://blablanet.com/bnews/i/?get=c_5"></object>
<br><br>
<b>Suivez l'actualité internationale sur le web: nouvelles, analyses, reportages et photos de nos correspondants, blogues et dossiers, audio et vidéo.</b><br>
</p>

</p>
EOT;

    return $o;
}

