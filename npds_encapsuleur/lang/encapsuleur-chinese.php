<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/* ===========================                                          */
/*                                                                      */
/* Encapsuleur  V 5.0                                                   */
/*                                                                      */
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
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
/* 2017 Changement de nom du module version Rev16 par jpb/phr           */
/************************************************************************/

function monmodule_translate($phrase) {
 switch ($phrase) {
   case "Français" : $tmp = "Liste der Sessions"; break;
   case "Anglais" : $tmp = "Name"; break;
   case "Allemand" : $tmp = "@IP"; break;
   case "Espagnol" : $tmp = "entschlossen @IP"; break;
   case "Chinois" : $tmp = "entschlossen @IP"; break;

   default: $tmp = "需要翻译稿 [** $phrase **]"; break;
 }
  return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>