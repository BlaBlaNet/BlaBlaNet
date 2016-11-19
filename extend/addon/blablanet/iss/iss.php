<?php

/**
 * Name: ISS Station
 * Description: Online Video Streaming front the ISS International Space Station
 * Version: 1.1
 * Author: Jacob M.
 */


function iss_load() {
    register_hook('app_menu', 'addon/iss/iss.php', 'iss_app_menu');
}

function iss_unload() {
    unregister_hook('app_menu', 'addon/iss/iss.php', 'iss_app_menu');

}

function iss_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="iss">ISS Stream</a></div>';
}


function iss_module() {}


function iss_content($a) {

$baseurl = z_root() . '/addon/iss';
$o .= <<< EOT
<br><br>
</p>
<br><br>
<b> Live video from the International Space Station includes internal views when the crew is on-duty and Earth views at other times. The video is accompanied by audio of conversations between the crew and Mission Control. This video is only available when the space station is in contact with the ground. During "loss of signal" periods, viewers will see a blue screen. Since the station orbits the Earth once every 90 minutes, it experiences a sunrise or a sunset about every 45 minutes. When the station is in darkness, external camera video may appear black, but can sometimes provide spectacular views of lightning or city lights below.  </b><br>

</p>

</p>

<br><br>
<object width="975" height="900" data="https://www.ustream.tv/embed/9408562?html5ui"></object>
<br><br>



</p>
<br><br>
<b> Live video from the International Space Station includes internal views when the crew is on-duty and Earth views at other times. The video is accompanied by audio of conversations between the crew and Mission Control. This video is only available when the space station is in contact with the ground. During "loss of signal" periods, viewers will see a blue screen. Since the station orbits the Earth once every 90 minutes, it experiences a sunrise or a sunset about every 45 minutes. When the station is in darkness, external camera video may appear black, but can sometimes provide spectacular views of lightning or city lights below. </b><br>
</p>

</p>
EOT;

    return $o;
}
