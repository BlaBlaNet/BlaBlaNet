<?php

/**
 * Name: BB  Ants Network
 * Description: BB Ants Network
 * Version: 1.1
 * Author: Jacob M.
 */


function ants_load() {
    register_hook('app_menu', 'addon/ants/ants.php', 'ants_app_menu');
}

function ants_unload() {
    unregister_hook('app_menu', 'addon/ants/ants.php', 'ants_app_menu');

}

function ants_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="ants">BlaBlaNet ants Partner</a></div>';
}


function ants_module() {}


function ants_content($a) {

$baseurl = z_root() . '/addon/ants';
$o .= <<< EOT
<br><br>
<p align="left"> 
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
jQuery(document).ready(function () {
newTab();
});

function newTab() {
 var form = document.createElement("form");
 form.method = "GET";
 form.action = "https://blablanet.com/pubsites/";
 form.target = "_blank";
 document.body.appendChild(form);
 form.submit();
}
</script>



</p>
<br><br>
</p>

</p>
EOT;

    return $o;
}
