<?php

/**
 * Name: Latest News 
 * Description: Latest News 
 * Version: 1.1
 * Author: Jacob M.
 */


function news_load() {
    register_hook('app_menu', 'addon/news/news.php', 'news_app_menu');
}

function news_unload() {
    unregister_hook('app_menu', 'addon/news/news.php', 'news_app_menu');

}

function news_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="news">Latest News</a></div>';
}


function news_module() {}


function news_content($a) {

$baseurl = z_root() . '/addon/news';
$o .= <<< EOT
<br><br>
<p align="left">
<object width="975" height="900" data="https://cronworld.com/i/"></object>
<br><br>
<b>Latest Latest News around the World Offer 24 Hours a Days -- by BlaBlaNet News</b><br>
</p>

</p>
EOT;

    return $o;
}
