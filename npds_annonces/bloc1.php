<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/*                                                                      */
/* NPDS Copyright (c) 2002-2015 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* Module npds_annonces 3.0                                             */
/*                                                                      */
/*                                                                      */
/* Basé sur gadjo_annonces v 1.2 - Adaptation 2008 par Jireck et lopez  */
/* MAJ conformité XHTML pour REvolution 10.02 par jpb/phr en mars 2010  */
/* MAJ Dev - 2011                                                       */
/* Changement de nom du module version Rev16 par jpb/phr mars 2016      */
/************************************************************************/

include ("modules/npds_annonces/annonce.conf.php");

if ($title=="")
   $title="Petites Annonces";

$result = sql_query("SELECT id_cat, count(en_ligne) FROM $table_annonces WHERE en_ligne='1' GROUP BY id_cat");
while (list($cat, $count) = sql_fetch_row($result)) {
   $num_ann[$cat]=$count;
   $num_ann_total+=$count;
}
if ( $num_ann_total > 1 ){ $pluriel = "s"; }
$content = '<p class="text-xs-center "><span class="label label-default">Il y a '.$num_ann_total.' annonce'.$pluriel.' publi&eacute;e'.$pluriel.'</span></p>';
$content .='
<div class="row">
<div class="col-xs-12">
<a class="btn btn-primary-outline btn-sm btn-block" href="modules.php?ModPath=npds_annonces&amp;ModStart=index">Consulter</a>
<a class="btn btn-primary-outline btn-sm btn-block" href="modules.php?ModPath=npds_annonces&amp;ModStart=annonce_form"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter</a>
</div>
</div>
';

//$content .='<ul class="list-group"><li class="list-group-item text-xs-center"><a class="btn btn-primary-outline btn-sm" href="modules.php?ModPath=npds_annonces&amp;ModStart=index">Consulter</a>&nbsp;&nbsp;<a class="btn btn-primary-outline btn-sm" href="modules.php?ModPath=npds_annonces&amp;ModStart=annonce_form"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter</a></li></ul>';
?>