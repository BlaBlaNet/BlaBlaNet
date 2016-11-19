<?php

/**
 * Name: ticket Station
 * Description: Online Helpdesk for New Users
 * Version: 1.1
 * Author: Jacob M.
 */


function ticket_load() {
    register_hook('app_menu', 'addon/ticket/ticket.php', 'ticket_app_menu');
}

function ticket_unload() {
    unregister_hook('app_menu', 'addon/ticket/ticket.php', 'ticket_app_menu');

}

function ticket_app_menu($a,&$b) {
    $b['app_menu'][] = '<div class="app-title"><a href="ticket">ticket Stream</a></div>';
}


function ticket_module() {}


function ticket_content($a) {

$baseurl = z_root() . '/addon/ticket';
$o .= <<< EOT
<br><br>
</p>
<br><br>
</p>

<br><br>
<object width="975" height="900" data="https://support.blablanet.com/help/"></object>
<br><br>



</p>
<br><br>
</p>

</p>
EOT;

    return $o;
}
