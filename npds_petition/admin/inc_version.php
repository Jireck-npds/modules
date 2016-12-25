<?php
/***************************************************************************\
 *  phpPetitions, serveur de pétition pour php/Mysql                       *
 *                                                                         *
 *  Copyleft (c) 2003-2005                                                 *
 *  Francois Sauterey, Asdrad Torres, Joel Pothier                         *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt                       *
\***************************************************************************/

/*	admin/inc_version.php			la version du programme et de la base		*/

$version		= '2.2';
$sous_version	= 'g';
$base_version	= '2.3'; // traduction + tables unique de signatures + index diverses + nom-prenom en minuscules

error_reporting(E_ALL ^ E_NOTICE);

// Lycos (ex-Multimachin)
if ($HTTP_X_HOST == 'membres.lycos.fr') 
    $hebergeur	= 'lycos';
// Altern
elseif (preg_match("/altern\.com$/", $SERVER_NAME)) 
    $hebergeur	= 'altern';
// NexenServices
elseif ($_SERVER['SERVER_ADMIN'] == 'www@nexenservices.com') {
    if (!function_exists('email'))
        include ('mail.inc');
    $hebergeur	= 'nexenservices';
}
// Online
elseif (function_exists('email')) 
    $hebergeur	= 'online';

if ($monhebergeur)
	$hebergeur	= $monhebergeur;

# vim: ts=4 ai
?>
