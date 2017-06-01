<?php
/**************************************************************************************************/
/* Module de gestion de galeries pour NPDS                                                        */
/* ===================================================                                            */
/* (c) 2004-2005 Tribal-Dolphin - http://www.tribal-dolphin.net                                   */
/* (c) 2007 Xgonin, Lopez - http://modules.npds.org                                               */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010                            */
/* MAJ Dev - 2011                                                                                 */
/*                                                                                                */
/* This program is free software. You can redistribute it and/or modify it under the terms of     */
/* the GNU General Public License as published by the Free Software Foundation; either version 2  */
/* of the License.                                                                                */
/**************************************************************************************************/

$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=gal*']['title']="[french]Galerie d'images[/french][english]Pictures galery[/english][spanish]galeria de imagenes[/spanish]+";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=gal*']['js']=array($nuke_url.'/modules/npds_galerie/js/jquery.watermark.min.js');
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=gal*']['run']="yes";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=gal*']['blocs']="2";
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=gal*']['TinyMce']=1;
$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=gal*']['TinyMce-theme']="short";

?>