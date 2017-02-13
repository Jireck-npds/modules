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
/* Changement de nom du module version Rev16 par jpb/phr 2017           */
/************************************************************************/

function encap_translate($phrase) {
   settype($englishname,'string');
   switch($phrase) {
      case "$englishname": $tmp="$englishname"; break;
      case "datestring": $tmp="%A %d %B %Y @ %H:%M:%S %Z"; break;
      case "linksdatestring": $tmp="%d-%b-%Y"; break;
      case "datestring2": $tmp="%A, %d %B"; break;
      case "dateforop": $tmp="d-m-y"; break;
      default: $tmp = $phrase; break;
   }
   return (htmlentities($tmp,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML401,cur_charset));
}
?>