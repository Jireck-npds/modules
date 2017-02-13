<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/*                                                                      */
/* NPDS Copyright (c) 2002-2017 by Philippe Brunier                     */
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
/* Changement de nom du module version Rev16 par jpb/phr janv 2017      */
/************************************************************************/

function aff_annonces($select) {
   global $ModPath, $aff_prix, $prix_cur;
   while ($i=sql_fetch_array($select)) {
      $id_user=$i['id_user'];
      $tel=stripslashes($i['tel']);
      $tel_2=stripslashes($i['tel_2']);
      $code=$i['code'];
      $ville=stripslashes($i['ville']);
      $date=$i['date'];
      $date=date("d-m-Y",$date);
      $text=removehack(stripslashes($i['text']));
      $prix=$i['prix'];

//recup des données utilisateur utiles pour l'affichage
      settype ($id_user,"integer");
      $result = sql_query("select uname, email FROM users WHERE uid='$id_user'");
      list($nom, $mail)= sql_fetch_row($result);

      $ibid='<div class="card my-3"><div class="card-block">';
      $ibid.='<h4 class="card-title">'.ann_translate("Annonce de").' '.$nom.', le '.$date.'</h4>';
      $ibid.='<div class="card-text row"><div class="col-md-1"><a class="btn btn-secondary btn-sm" href="mailto:'.anti_spam($mail).'"><i class="fa fa-envelope" aria-hidden="true"></i></a></div>';
      if ($tel!="")
         $ibid.='<div class="col-md-3"><i class="fa fa-phone" aria-hidden="true"></i> <a data-rel="external" href="tel:+33'.$tel.'" target="_blank">+33'.$tel.'</a></div>';
      if ($tel_2!="")
         $ibid.='<div class="col-md-3"><i class="fa fa-mobile" aria-hidden="true"></i> <a data-rel="external" href="tel:+33'.$tel_2.'" target="_blank">+33'.$tel_2.'</a></div>';
      $ibid.='</div>';
      $ibid.='<div class="card-text row">';	  
      if ($ville)
         $ibid.='<div class="col-md-3">'.ann_translate("Ville").' : '.$ville.'</div>';
      if ($code)
         $ibid.='<div class="col-md-3">'.ann_translate("Code postal").' : '.$code.'</div>';
      $ibid.='</div>';
      $ibid.='<div class="card-text mt-3">';
      $ibid.=$text;
      $ibid.='</div>';
      if ($aff_prix) {
         $ibid.='<h4>'.ann_translate("Prix").' : '.$prix.' '.aff_langue($prix_cur).'</h4>';
      }
      $ibid.="<p>##imp##</p>";
      $ibid.='</div></div>';

      $ibid2='<form method="post" action="modules.php">
            <input type="hidden" name="ModPath" value="'.$ModPath.'" />
            <input type="hidden" name="ModStart" value="print" />
            <input type="hidden" name="text" value="'.rawurlencode(str_replace("##imp##","",$ibid)).'" />
            <button class="btn btn-secondary btn-sm" type="image" name="image"><i class="fa fa-print" aria-hidden="true"></i></button>
            </form>';

      echo str_replace("##imp##",$ibid2,$ibid)."";
   }
}
?>