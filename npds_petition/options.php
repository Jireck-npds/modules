<?php
 /***************************************************************************\
  *  phpPetitions, serveur de p�tition pour php/Mysql                       *
  *                                                                         *
  *  Copyleft (c) 2003-2005                                                *
  *  Francois Sauterey, Asdrad Torres, Joel Pothier                         *
  *  le Centre Ressource du R�seau Associatif et Syndical                   *
  *                                                                         *
  *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
  *  Pour plus de details voir le fichier COPYING.txt                       *
 \***************************************************************************/


//la langue par defaut du site
$langue		= 'fr_FR';

// si petition est fix�, il n'y a plus de serveur et seul apparait LA p�tion N� X
//$petition	= "3";

// les signatures sont-elle tri�es alphab�tiquement ou par date ?
$alpha		= 'oui';

// extraire $dernieres signatures si plus de 500
$derniers	= $GLOBALS['derniers']	= 250;

// la fonction mail utilise le 5eme parametre
$monhebergeur	= '5params';

# vim: ts=4
?>
