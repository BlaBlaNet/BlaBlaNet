<?php

/**
 * Name: Ultimas Noticias 
 * Description: Ultimas Noticias en Castellano 
 * Version: 1.0
 * Author: Jacob M.
 */


function noticias_load() {
    register_hook('app_menu', 'addon/noticias/noticias.php', 'noticias_app_menu');
}

function noticias_unload() {
    unregister_hook('app_menu', 'addon/noticias/noticias.php', 'noticias_app_menu');

}

function noticias_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="noticias">Ultimas Noticias</a></div>';
}


function noticias_module() {}
$baseurl = z_root() . '/addon/noticias';
$o .= <<< EOT
<br><br>
<p align="left">
<object width="975" height="900" data="https://blablanet.com/bnews/i/?get=c_2"></object>
<br><br>
<b>RSS FEED Noticias . Tu herramienta para estar al tanto de lasultimas noticias -- by BlaBlaNet News</b><br>
</p>

</p>
EOT;

    return $o;
}


