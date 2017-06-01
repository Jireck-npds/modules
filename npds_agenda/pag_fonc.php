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
/* Module npds_agenda 2.0                                               */
/*                                                                      */
/* Auteur Oim                                                           */
/* Changement de nom du module version Rev16 par jpb/phr janv 2017      */
/************************************************************************/

/*$adjacentes = nombre de pages a afficher de chaque cote de la page courante apres 7
$css = vide style.css sinon ajout pour css module (_mod pour le module et _admin pour la partie admin*/
function ag_pag($total,$courante,$adjacentes,$ThisFile,$css)
{

/* Variables */
   $prec = $courante - 1; // numero de la page precedente
   $suiv = $courante + 1; // numero de la page suivante
   $avder = $total - 1; // avant derniere page
   $pagination = "";
   if($total > 1)
   {
   $pagination .= '<nav aria-label="">
                     <ul class="pagination pagination-sm">';
      if ($courante == 2)
         $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'">◄</a></li>';
      elseif ($courante > 2)
         $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page='.$prec.'">◄</a></li>';
      else
         $pagination.= '<li class="page-item disabled"><a class="page-link" href="#">◄</a></li>';
      if ($total < 7 + ($adjacentes * 2))
      {
         $pagination.= ($courante == 1) ? '<li class="page-item active"><span class="page-link">1</span></li>' : '<li class="page-item"><a class="page-link" href="'.$ThisFile.'">1</a></li>';
         for ($compteur = 2; $compteur <= $total; $compteur++)
         {
            if ($compteur == $courante)
               $pagination.= '<li class="page-item active"><span class="page-link">'.$compteur.'</span></li>';
            else
               $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page='.$compteur.'">'.$compteur.'</a></li>';
         }
      }
      elseif($total > 5 + ($adjacentes * 2))
      {
         if($courante < 1 + ($adjacentes * 2))
         {
            $pagination.= ($courante == 1) ? '<li class="page-item active"><span class="page-link">1</span></li>' : '<li class="page-item"><a class="page-link" href="'.$ThisFile.'">1</a></li>';
            for ($compteur = 2; $compteur < 4 + ($adjacentes * 2); $compteur++)
            {
               if ($compteur == $courante)
                  $pagination.= '<li class="page-item active"><span class="page-link">'.$compteur.'</span></li>';
               else
                  $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page='.$compteur.'">'.$compteur.'</a></li>';
            }
            $pagination.= '<li class="page-item"><a class="page-link" href=""> ... </a></li>';
            $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page='.$avder.'">'.$avder.'</a></li>';
            $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page='.$total.'">'.$total.'</a></li>';
         }
         elseif($total - ($adjacentes * 2) > $courante && $courante > ($adjacentes * 2))
         {
            $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'">1</a></li>';
            $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page=2">2</a></li>';
            $pagination.= '<li class="page-item"><a class="page-link" href=""> ... </a></li>';
            for ($compteur = $courante - $adjacentes; $compteur <= $courante + $adjacentes; $compteur++)
            {
               if ($compteur == $courante)
                  $pagination.= '<li class="page-item active"><span class="page-link">'.$compteur.'</span></li>';
               else
                  $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&page='.$compteur.'">'.$compteur.'</a></li>';
            }
            $pagination.= '<li class="page-item"><a class="page-link" href=""> ... </a></li>';
            $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page='.$avder.'">'.$avder.'</a></li>';
            $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page='.$total.'">'.$total.'</a></li>';
         }
         else
         {
            $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'">1</a></li>';
            $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page=2">2</a></li>';
            $pagination.= '<li class="page-item"><a class="page-link" href=""> ... </a></li>';
            for ($compteur = $total - (2 + ($adjacentes * 2)); $compteur <= $total; $compteur++)
            {
               if ($compteur == $courante)
                  $pagination.= '<li class="page-item active"><span class="page-link">'.$compteur.'</span></li>';
               else
                  $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page='.$compteur.'">'.$compteur.'</a></li>';
            }
         }
      }
      if ($courante < $compteur - 1)
         $pagination.= '<li class="page-item"><a class="page-link" href="'.$ThisFile.'&amp;page='.$suiv.'">►</a></li>';
      else
         $pagination.= '<li class="page-item disabled"><a class="page-link" href="#">►</a></li>';
         $pagination.= '</ul></nav>';
   }
   return ($pagination);
}
?>