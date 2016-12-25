<?php
/************************************************************************/
/* NPDS V : Net Portal Dynamic System                                   */
/* ===========================                                          */
/*                                                                      */
/* This version name NPDS Copyright (c) 2001-2011 by Philippe Brunier   */
/*                                                                      */
/* Encapsuleur  V 5.0                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/* 05.01.2001 - martvin@box43.pl                                        */
/* 12.09.2002 - Achel_Jay, Benjee, Capcaverne                           */
/* 02.11.2002 - Snipe                                                   */
/* 25.11.2008 - Lopez - MAJ pouir Evolution                             */
/* 2010 et 2011 - Adaptation REvolution                                 */
/* Changement de nom du module version Rev16 par jpb/phr mars 2016      */
/************************************************************************/

# déclaration du repertoire local dans lequel on va stocker les pages internes à encapsuler
$static_url = "./static/";

# table MySQL utilisée par l'encapsuleur
$encap_table = "encapsulation";

# Paramètres de bordures de la frame de la page encapsulée
$encap_bordext = 0;
$encap_bordint = 0;

# Hauteur par défaut du cadre d'encapsulation de la page
$encap_height = 800;

?>