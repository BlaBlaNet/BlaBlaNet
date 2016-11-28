<?php

// Set the following for your MySQL installation
// Utilisez ces informations pour configurer votre instance de BD (MySQL)
// Copy or rename this file to .htconfig.php
// Copier ou renomer ce fichier .htconfig.php et placer le � la racine de l'installation de la Matrice Rouge.

$db_host = '{{$dbhost}}';
$db_port = '{{$dbport}}';
$db_user = '{{$dbuser}}';
$db_pass = '{{$dbpass}}';
$db_data = '{{$dbdata}}';
$db_type = '{{$dbtype}}'; // an integer. 0 or unset for mysql, 1 for postgres

/*
 * Note: Plusieurs de ces r�glages seront disponibles via le panneau d'administration
 * apr�s l'installation. Lorsque des modifications sont apport�s � travers le panneau d'administration
 * elle sont automatiquement enregistr�es dans la base de donn�es.
 * Les configurations inscrites dans la BD pr�valent sur celles de ce fichier de configuration.
 *
 * En cas de difficult�s d'acc�s au panneau d'administration, nous mettons � votre disposition,
 * un outil en ligne de commande est disponible [util/config] pour rechercher et apporter des modifications
 * sur les entr�es dans la BD.
 *
 */ 

// Choisissez votre emplacement g�ographique. Si vous n'�tes pas certain, utilisez "America/Los_Angeles".
// Vous pourrez le changer plus tard et ce r�glage n'affecte que les visiteurs anonymes.

App::$config['system']['timezone'] = '{{$timezone}}';

// Quel sera le nom de votre site?

App::$config['system']['baseurl'] = '{{$siteurl}}';
App::$config['system']['sitename'] = "BlaBlaNet";
App::$config['system']['location_hash'] = '{{$site_id}}';

// Choices are 'basic', 'standard', and 'pro'.
// basic sets up the sevrer for basic social networking and removes "complicated" features
// standard provides most desired features except e-commerce
// pro gives you access to everything

App::$config['system']['server_role'] = '{{$server_role}}';



// These lines set additional security headers to be sent with all responses
// You may wish to set transport_security_header to 0 if your server already sends
// this header. content_security_policy may need to be disabled if you wish to
// run the piwik analytics plugin or include other offsite resources on a page

App::$config['system']['transport_security_header'] = 1;
App::$config['system']['content_security_policy'] = 1;

// Vos choix sont REGISTER_OPEN, REGISTER_APPROVE, ou REGISTER_CLOSED.
// Soyez certains de cr�er votre compte personnel avant de d�clarer
// votre site REGISTER_CLOSED. 'register_text' (si vous d�cider de l'utiliser) 
// renvois son contenu syst�matiquement sur la page d'enregistrement des nouveaux membres.
// REGISTER_APPROVE requiert la configuration de 'admin_email' avec l'adresse de courriel
// d'un membre d�j� inscrit qui pourra autoriser et/ou approuver/supprimer la demande.

App::$config['system']['register_policy'] = REGISTER_OPEN;
App::$config['system']['register_text'] = '';
App::$config['system']['admin_email'] = '{{$adminmail}}';

// taille maximale pour l'importation d'un message, 0 est illimit�

App::$config['system']['max_import_size'] = 200000;

// taille maximale pour le t�l�versement de photos

App::$config['system']['maximagesize'] = 8000000;

// Lien absolu vers le compilateur PHP

App::$config['system']['php_path'] = '{{$phpath}}';

// configurez la fa�on dont votre site communique avec les autres serveurs. [R�pertoire des membres inscrits � la Matrice]
// DIRECTORY_MODE_NORMAL     = client du r�pertoire de membres, nous vous trouverons un r�pertoire accessible autre serveur.
// DIRECTORY_MODE_SECONDARY  = copie mirroir du r�pertoire des membres.
// DIRECTORY_MODE_PRIMARY    = r�pertoire des membres principal.
// DIRECTORY_MODE_STANDALONE = "autonome/d�connect�" ou r�pertoire de membres priv�s

App::$config['system']['directory_mode']  = DIRECTORY_MODE_NORMAL;

// Th�me par d�faut

App::$config['system']['theme'] = 'MrBlue';


///////////////META TAGS CONFIGURATION HOME BASE////////////////////////////////
//$a->config['metatag']['hreflang'] = '<link rel="alternate" href="https://blablanet.com/" hreflang="en" />';
$a->config['metatag']['description'] = '<meta name="description" content="BlaBlanet Ants Node the social network service. Connect with friends, family . Share photos and videos, send messages and chat with people you know." />
';
$a->config['metatag']['robots'] = '<meta name="robots" content="index" />';
$a->config['metatag']['keywords'] = '<meta name="keywords" content="social, network, networking, service, friends, family, vpn, blogs, photos, videos, files, directory, encryption" />';
//////Registration Description
$a->config['metatag']['descriptionR'] = '<meta name="description" content="Register in BlaBlanet the decentralized social network service here you own your privacy and your data." />';
//////Login Description
$a->config['metatag']['descriptionL'] = '<meta name="description" content="Login in BlaBlanet enjoy with Friend share your ideas and feelings." />';
/////Directory Description
$a->config['metatag']['descriptionD'] = '<meta name="description" content="Here you will find the latest friends Join BlablaNet Social Network." />';
////Directory PUBLIC
$a->config['metatag']['descriptionP'] = '<meta name=" The latest Public Sites by BlaBlaNet." />';
///Directory APPS
$a->config['metatag']['descriptionA'] = '<meta name="description" content="BlaBlanet Social Network Lastes Applications, Apps, utils and extras for enjoy." />';
////Latest News
$a->config['metatag']['descriptionN'] = '<meta name=" The latest News Around the World update 24 hours in BlaBlaNet Social Network." />';


