<?php

/**
 * Name: Donar BlaBlanet
 * Description: Support BlaBlanet projects
 * Version: 1.5
 * Author: Original Author Macgirvin Fork by Jacob M.
 * 
 */

function load(){}
function unload(){}
function donar_module(){}

function donar_content(&$a) {

/* Format - array( display name, paypal id, description of services or skills you provide to the matrix) */

$contributors = array(
array('BlaBlanet ServicesProjects', 'market@royalking.co.uk', t('Project Servers and Resources')),
/* Developers and public hubs - add your donatable resource here */

);


$sponsors = array(
'Carlos',
'Amalia',
'Tony',
'Philips',
'Antonio',
'Nuria'
);



call_hooks('donar_contributors',$contributors);

call_hooks('donar_sponsors',$sponsors);

$sponsors[] = t('And the people and organisations who help be possible Blablanet Servers be running .');


$text .= '<p>' . t('BlaBlanet Social Network is free in all the countries we not charge any fees for be a user in our Network.') . '</p>';
$text .= '<p>' . t('There is no corporate funding and no ads, and we do not collect and sell your personal information. (We don\'t control your personal information - <strong>you do</strong>.)') . '</p>';
$text .= '<p>' . t('Help support our ground-breaking work in decentralisation, web identity, and privacy.') . '</p>';

$text .= '<p>' . t('Your donations keep servers and services running and also helps us to provide innovative new features and continued development.') . '</p>';

$o = replace_macros(get_markup_template('donar.tpl','addon/donar'),array(
	'$header' => t('Donate'),
	'$text' => $text,
	'$choice' => t('Choose a project, developer, or public hub to support with a one-time donation'),
	'$onetime' => t('Donate Now'),
	'$repeat' => t('<strong><em>Or</em></strong> become a project sponsor (BlaBlanet Project only)'),
	'$note' => t('Please indicate if you would like your first name or full name (or nothing) to appear in our sponsor listing'),
	'$subscribe' => t('Sponsor'),
	'$contributors' => $contributors,
	'$sponsors' => $sponsors,
	'$thanks' => t('Special thanks to: '),
));

call_hooks('donar_plugin',$o);

return $o;

}
