<?php
/************************************************************************/
/* NPDS : Net Portal Dynamic System                                     */
/* ==========================                                           */
/*                                                                      */
/* Module npds_agenda                                                   */
/* Version 1.0                                                          */
/* Auteur Oim                                                           */
/* Changement de nom du module version Rev16 par jpb/phr mars 2016      */
/************************************************************************/

function ag_trad($phrase) {
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