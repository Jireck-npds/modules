<?php
/************************************************************************/
/* Module de gestion de galeries d'images pour NPDS                     */
/************************************************************************/
/*                                                                      */
/* Evolution Td-galerie 2.5                                             */
/* npds_galerie version 3 pour revolution 16 version bootstrappée 4     */
/* développé par jpb/phr mars 2016                                      */
/************************************************************************/

/**************************************************************************************************/
/* Fonctions du module                                                                            */
/**************************************************************************************************/

// les menus

/*******************************************************/
//revu phr le 29/01/16
/*******************************************************/
function FabMenu() {
   global $NPDS_Prefix, $ThisFile, $aff_comm, $aff_vote, $ModPath, $user;
   $query = sql_query("SELECT id,nom,acces FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0' ORDER BY nom");
   if (sql_num_rows($query) != 0) {
      $n = 0; $ibid="";
      while($row = sql_fetch_row($query)) {
         if (autorisation($row[2])) {
            $ibid.="<div class=\"col-lg-3\"><i class=\"fa fa-folder-o\"></i><a href=\"".$ThisFile."&amp;op=cat&amp;catid=".$row[0]."\"> ".stripslashes($row[1])."</a></div>\n";
            $n++;
            if ($n == 4){  $ibid.= "</div><div class=\"row lead\">"; $n = 0;}
         }
      }
      if ($ibid) {
         echo '<p class="breadcrumb lead">'.gal_trans("Catégories").'';
         if ($aff_comm) {
            echo ' <a class="btn btn-outline-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&ModStart=gal&op=topcomment">'.gal_trans("Top-Commentaires").'</a>';
         }
         if ($aff_vote) {
            echo ' <a class="btn btn-outline-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&ModStart=gal&op=topvote">'.gal_trans("Top-Votes").'</a>';
         }
         if (isset($user)) {
            echo ' <a class="btn btn-outline-secondary btn-sm" href="modules.php?ModPath='.$ModPath.'&ModStart=gal&op=formimgs">'.gal_trans("Proposer des images").'</a>';
         }         
         echo '</p>';
         echo '<div class="row lead">';
         echo $ibid;
         echo "</div>";
      }
   } else { echo "<p class=\"text-danger text-center\">".gal_trans("Aucune catégorie trouvée")."</p>"; }
}

/*******************************************************/
//revu phr le 31/01/16 ok
/*******************************************************/
function FabMenuCat($catid) {
   global $NPDS_Prefix, $ThisFile;
   settype($catid,"integer");
   $cat = sql_fetch_row(sql_query("SELECT nom,acces FROM ".$NPDS_Prefix."tdgal_cat WHERE id='".$catid."'"));
   if (autorisation($cat[1])) {
      $query = sql_query("SELECT id,nom,acces FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='".$catid."' ORDER BY nom");
      echo "";
      echo '<nav class="breadcrumb lead"><a class="breadcrumb-item" href="'.$ThisFile.'">'.gal_trans("Accueil").'</a><span class="breadcrumb-item active">'.stripslashes($cat[0]).'</span></nav>';
      echo '<div class="row lead">';
      $n = 0;
      while ($row = sql_fetch_row($query)) {
         if (autorisation($row[2])) {
            echo '<div class="col-lg-3"><i class="fa fa-folder-o"></i><a href="'.$ThisFile.'&amp;op=sscat&amp;catid='.$catid.'&amp;sscid='.$row[0]."\"> ".stripslashes($row[1]).'</a></div>';
            $n++;
            if ($n == 4) {  echo "</div><div class=\"row lead\">"; $n = 0;}
         }
      }
      echo '</div>';
   } else { echo '<p class="text-danger text-center">'.gal_trans("Aucune catégorie trouvée").'</p>'; }
}

/*******************************************************/
//revu phr le 31/01/16 ok
/*******************************************************/
function FabMenuSsCat($catid, $sscid) {
   global $NPDS_Prefix, $ThisFile;
   settype($catid,"integer");
   settype($sscid,"integer");
   $cat = sql_fetch_row(sql_query("SELECT nom,acces FROM ".$NPDS_Prefix."tdgal_cat WHERE id='".$catid."'"));
   if (autorisation($cat[1])) {
      $sscat = sql_fetch_row(sql_query("SELECT nom,acces FROM ".$NPDS_Prefix."tdgal_cat WHERE id='".$sscid."'"));
      if (autorisation($sscat[1])) {
         echo '<nav class="breadcrumb lead">';
         echo '<a class="breadcrumb-item" href="'.$ThisFile.'">'.gal_trans("Accueil").'</a>';
         echo '<a class="breadcrumb-item" href="'.$ThisFile.'&op=cat&amp;catid='.$catid.'">';
         echo ''.stripslashes($cat[0]).'</a>';
         echo '<span class="breadcrumb-item active">'.stripslashes($sscat[0]).'</span>';
         echo '</nav>';
      } else { echo "<p class=\"text-danger text-center\">".gal_trans("Aucune catégorie trouvée")."</p>"; }
   } else { echo "<p class=\"text-danger text-center\">".gal_trans("Aucune catégorie trouvée")."</p>"; }
}

/*******************************************************/
//revu phr le 31/01/16 ok
/*******************************************************/
function FabMenuGal($galid) {
   global $NPDS_Prefix, $ThisFile;
   settype($galid,"integer");
   $gal = sql_fetch_row(sql_query("SELECT nom,acces FROM ".$NPDS_Prefix."tdgal_gal WHERE id='".$galid."'"));
   if (autorisation($gal[1])) {
      echo '<nav class="breadcrumb lead">';
      echo '<a class="breadcrumb-item" href="'.$ThisFile.'">'.gal_trans("Accueil").'</a>';
      echo GetGalArbo($galid);
      echo '<span class="breadcrumb-item active">'.stripslashes($gal[0]).'</span>';
      echo '</nav>';
   } else { echo "<p class=\"text-danger text-center\">".gal_trans("Aucune galerie trouvée")."</p>"; }
}

/*******************************************************/
//revu phr le 31/01/16 ok
/*******************************************************/
function FabMenuImg($galid, $pos) {
   global $NPDS_Prefix, $ThisFile;
   settype($galid,"integer");
   settype($pos,"integer");
   $gal = sql_fetch_row(sql_query("SELECT nom,acces FROM ".$NPDS_Prefix."tdgal_gal WHERE id='".$galid."'"));
   if (autorisation($gal[1])) {
      echo '<h4><ul class="breadcrumb">';
      echo "<li><a href=\"".$ThisFile."\">".gal_trans("Accueil")."</a></li>";
      echo "".GetGalArbo($galid)."";
      echo "<li><a href=\"".$ThisFile."&amp;op=gal&amp;galid=".$galid."\">".stripslashes($gal[0])."</a></li>";
      $img = sql_fetch_row(sql_query("SELECT comment FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$galid."' and noaff='0' ORDER BY ordre,id LIMIT $pos,1"));
      if ($img[0]!="")
         echo '<li>'.stripslashes($img[0]).'</li>';
      echo '</ul></h4>';

   } else { echo "<p class=\"text-danger text-center\">".gal_trans("Aucune galerie trouvée")."</p>"; }
}
// les menus

/*******************************************************/
//revu phr le 29/01/16
/*******************************************************/

function ListGalCat($catid) {
   global $NPDS_Prefix, $ThisFile;
   settype($catid,"integer");
   $gal = sql_query("SELECT id,nom,date,acces FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='".$catid."' ORDER BY nom");
   if (sql_num_rows($gal) != 0) {
      $n = 0; $ibid="";
      while ($row = sql_fetch_row($gal)) {
         if (autorisation($row[3])) {
            $nimg = sql_fetch_row(sql_query("SELECT COUNT(id) FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$row[0]."' and noaff='0'"));
            $ibid.= "<div class=\"col-lg-6\"><i class=\"fa fa-folder-o\"></i><a href=\"".$ThisFile."&amp;op=gal&amp;galid=".$row[0]."\"> ".stripslashes($row[1])."</a> (".$nimg[0].")\n";
            $ibid.= "<br />".gal_trans("Créée le")." ".date(translate("dateinternal"),$row[2])."</div>";
            $n++;
            if ($n == 2){  $ibid.= '</div><div class="row lead">'; $n = 0;}
         }
      }
      if ($ibid) {
         echo '<h4 class="breadcrumb">'.gal_trans("Galeries").'</h4>';
         echo '<div class="row lead">';
         echo $ibid;
         echo '</div>';
      }
   }
}

/*******************************************************/
//revu phr le 29/01/16
/*******************************************************/

function ViewGal($galid, $page){
   global $NPDS_Prefix, $ModPath, $ThisFile, $imglign, $imgpage, $MaxSizeThumb, $aff_comm, $aff_vote;
   $reglage = 'col-lg-3';
   $nbcol=4;
   settype($galid,"integer");
   settype($page,"integer");
   $num=0;
   $gal = sql_fetch_row(sql_query("SELECT acces FROM ".$NPDS_Prefix."tdgal_gal WHERE id='".$galid."'"));
   if (autorisation($gal[0])) {
      $num = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$galid."' and noaff='0'"));
   }
   if ($num == 0) {
      echo "<p class=\"text-danger text-center\">".gal_trans("Aucune image trouvée")."</p>";
   } else {
      $start = ($page - 1) * $imgpage;
      $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$galid."' and noaff='0' ORDER BY ordre,id LIMIT ".$start.",".$imgpage."");
      $pos = $start;

      echo '<div class="row">';
      while ($row = sql_fetch_row($query)) {
        $nbcom = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='".$row[0]."'"));
        $nbvote = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_vot WHERE pic_id='".$row[0]."'"));
        if (@file_exists("modules/$ModPath/imgs/".$row[2])) {
           list($width, $height, $type, $attr) = @getimagesize("modules/$ModPath/imgs/$row[2]");          
           $ibid = "<img class=\"img-fluid card-img-top\" src=\"modules/$ModPath/imgs/$row[2]\" alt=\"".stripslashes($row[3])."\" border=\"0\" $attr />";
        } else {
           $ibid = ReducePic($row[2],stripslashes($row[3]),$MaxSizeThumb);
        }
        echo "<div class=\"$reglage\"><div class=\"card\"><a href=\"".$ThisFile."&amp;op=img&amp;galid=$galid&amp;pos=$pos\">$ibid</a>";
        echo "<div class=\"card-block\">".$row[4]." ".gal_trans("affichage(s)");
        if ($aff_comm)
           echo "<br />$nbcom ".gal_trans("commentaire(s)");
        if ($aff_vote)
           echo "<br />$nbvote ".gal_trans("vote(s)");
        echo '</div></div>';
        echo '</div>';
        $pos++;
        if (is_int($pos/$imglign)) { echo "</div><div class=\"row\">"; }
      }
      echo "</div>";
     

// Gestion des pages ok
      $nb_pages = ceil($num / $imgpage);
   echo '<ul class="pagination pagination-sm">';
      if ($nb_pages > 1) {
         $nec = 1;
         if ($page < $nb_pages) {
            echo "
            <li class=\"page-item active\">
            <a class=\"page-link\" href=\"".$ThisFile."&amp;op=gal&amp;galid=$galid&amp;page=".($page+1)."\">".translate("Next Page")."</a></li>";
         }
         while ($nec <= $nb_pages) {
           if ($nec == $page) {
              echo "<span class=\"page-link text-danger\">$nec</span> ";
           } else {
              echo "<li class=\"page-item\"><a class=\"page-link\" href=\"".$ThisFile."&amp;op=gal&amp;galid=$galid&amp;page=$nec\">$nec</a></li>";
           }
           $nec++;
         }
      }
   echo '</ul>';
   }
}


/*******************************************************/
//revu phr le 31/01/16
/*******************************************************/

function ViewImg($galid, $pos, $interface) {
   global $NPDS_Prefix, $ModPath, $ThisFile, $user, $vote_anon, $comm_anon, $post_anon, $aff_vote, $aff_comm, $admin;
   settype($galid,"integer");
   settype($pos,"integer");
   if ($admin) $no_aff=""; else $no_aff="and noaff='0'";
   $gal = sql_fetch_row(sql_query("SELECT acces FROM ".$NPDS_Prefix."tdgal_gal WHERE id='".$galid."'"));
   if (autorisation($gal[0])) {
      $num = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$galid."' $no_aff"));
      if ($interface!="no")
         $row = sql_fetch_row(sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='".$galid."' $no_aff ORDER BY ordre,id LIMIT $pos,1"));
      else
         $row = sql_fetch_row(sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE id='".$pos."' and gal_id='".$galid."' $no_aff"));
      list($width, $height, $type, $attr) = @getimagesize("modules/$ModPath/imgs/$row[2]");
      
      echo '<div class="col-md-12"><img class="center-block img-fluid" src="modules/'.$ModPath.'/imgs/'.$row[2].'" alt="'.stripslashes($row[3]).'" border="0" '.$attr.' /><br />'.stripslashes($row[3]).'</div>';
      if ($interface!="no") {
         echo '<a class="btn" href="'.$ThisFile.'&amp;op=diapo&galid='.$galid.'&pos='.$pos.'&pid='.$row[0].'">';
         echo '<i class="fa fa-sliders fa-lg"></i></a>';
         if (isset($user) || $post_anon) {
            $link_card = '<a class="btn" href="'.$ThisFile.'&amp;op=ecard&galid='.$galid.'&pos='.$pos.'&pid='.$row[0].'">';
            $link_card.= '<i class="fa fa-envelope-o fa-lg"></i></a>';
         } else {
            $link_card.= '<i class="fa fa-envelope-o fa-lg"></i>';
         }
         echo $link_card;
         if ($pos > 0) {
            $link_prec = "<a class=\"btn\" href=\"".$ThisFile."&amp;op=img&galid=$galid&pos=".($pos-1)."\">";
            $link_prec.= '<i class="fa fa-chevron-left fa-lg"></i></a>';
         }
         echo $link_prec;
         if ($pos < ($num-1)) {
            $link_suiv = "<a class=\"btn\" href=\"".$ThisFile."&amp;op=img&galid=$galid&pos=".($pos+1)."\">";
            $link_suiv.= '<i class="fa fa-chevron-right fa-lg"></i></a>';
         }
         echo $link_suiv;
      }

      $update = sql_query("UPDATE ".$NPDS_Prefix."tdgal_img SET view = view + 1 WHERE id='".$row[0]."'");

      echo '<hr />';
      if ($interface!="no") {
         if ($aff_vote) {
            // Notation de l'image
            if (isset($user) || $vote_anon) {
               echo '<h4>'.gal_trans("Noter cette image").'</h4>';
               echo '<div class="row">';
               $i=0;$star='';
               while ($i<=5) {
               $star .='<i class="fa fa-star-o fa-lg"></i>';
                  echo '<div class="col-md-2"><a href="'.$ThisFile.'&amp;op=vote&amp;value='.$i.'&amp;pic_id='.$row[0].'&amp;gal_id='.$galid.'&amp;pos='.$pos.'">';
//                  echo '<img src="modules/'.$ModPath.'/data/'.$i.'.gif" alt="'.$i.'" />';
                  echo $star.'
                  </a></div>';
                  $i++;
               }
               echo '</div>';
            }
         }
      }
      // Infos sur l'image
   echo '<hr />';
      $tailleo = @filesize("modules/$ModPath/imgs/$row[2]");
      $taille = $tailleo/1000;
   echo '
   <h4>'.gal_trans("Informations sur l'image").'</h4>
   <ul class="list-group">
      <li class="list-group-item">'.gal_trans("Taille du fichier").'<span class="label label-default pull-xs-right">'.$taille.' Ko</span></li>
      <li class="list-group-item">'.gal_trans("Dimensions").'<span class="label label-default pull-xs-right">'.$width.' x '.$height.' Pixels</span></li>';
      if ($aff_vote) {
         $rowV = sql_fetch_row(sql_query("SELECT COUNT(id), AVG(rating) FROM ".$NPDS_Prefix."tdgal_vot WHERE pic_id='".$row[0]."'"));
         $note = round($rowV[1]);$star='';
         $i=0;
         while($i<=$note) {$star.='<i class="fa fa-star fa-lg"></i> ';$i++;}
         
   echo '<li class="list-group-item">'.gal_trans("Note ").$rowV[0].' '.gal_trans("vote(s)").'<span class="label label-default pull-xs-right">'.$star.'</span></li>';
      }
   echo '<li class="list-group-item">'.gal_trans("Affichées").'<span class="label label-default pull-xs-right">'.($row[4] + 1).' '.gal_trans("fois").'</span></li>';
   echo '</ul>';
      echo "<br />";
      if ($interface!="no") {
         if ($aff_comm) {
            // Commentaires sur l'image
            $qcomment = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='".$row[0]."' ORDER BY comtimestamp DESC LIMIT 0,10");
            $num_comm = sql_num_rows($qcomment);
            if (($num_comm > 0) || (isset($user) || $comm_anon)) {
               echo '<table class="table" border ="0">';
               while ($rowC = sql_fetch_row($qcomment)) {
                  echo "<thead><tr class=\"table-active\"><th>".$rowC[2]."</th><th class=\"text-xs-right\">".date(translate("dateinternal"),$rowC[5])."</th></tr></thead>";
                  echo "<tbody><tr><td colspan=\"2\">".stripslashes($rowC[3])."</td></tr>";
                  echo "<tr><td colspan=\"2\"> </td></tr>";
               }
               echo "</tbody></table>";
               // Formulaire de post de commentaire
               if (isset($user) || $comm_anon) {
                  echo '<div class="col-md-12">';
                  echo "<form action=\"".$ThisFile."\" method=\"post\" name=\"PostComment\">";
                  echo "";
                  echo "<input type=\"hidden\" name=\"op\" value=\"postcomment\">";
                  echo "<input type=\"hidden\" name=\"gal_id\" value=\"$galid\">";
                  echo "<input type=\"hidden\" name=\"pos\" value=\"$pos\">";
                  echo "<input type=\"hidden\" name=\"pic_id\" value=\"".$row[0]."\">";
                  echo '<fieldset class="form-group">
                        <label><strong>'.gal_trans("Ajoutez votre commentaire").'</strong></label>
                        <textarea class="form-control tin" id="com" name="comm" rows="5"></textarea>
                        </fieldset>';
                  echo aff_editeur("comm", "false");
                  //anti_spambot - begin
                  echo Q_spambot()."  ";
                  //anti_spambot - end
                  echo "<input class=\"btn btn-primary\" type=\"submit\" value=\"OK\">";
                  echo "</form></div>";
               }
            }
         }
      }
   }
}

/*******************************************************/
//à voir
/*******************************************************/

function ViewDiapo($galid, $pos, $pid) {
   global $NPDS_Prefix, $ThisRedo, $ModPath;
   settype($galid,"integer");
   $gal = sql_fetch_row(sql_query("SELECT acces FROM ".$NPDS_Prefix."tdgal_gal WHERE id='".$galid."'"));
   if (autorisation($gal[0])) {
      // Code Javascript du diaporama
      echo "<script  type=\"text/javascript\">\n";
      echo "//<![CDATA[\n";
      echo "var slideShowSpeed = 5000\n";
      echo "var xOp7=false,xOp5or6=false,xIE4Up=false,xNN4=false,xUA=navigator.userAgent.toLowerCase();\n\n";
      echo "if(window.opera){\n";
      echo "  xOp7=(xUA.indexOf('opera 7')!=-1 || xUA.indexOf('opera/7')!=-1);\n";
      echo "  if (!xOp7) xOp5or6=(xUA.indexOf('opera 5')!=-1 || xUA.indexOf('opera/5')!=-1 || xUA.indexOf('opera 6')!=-1 || xUA.indexOf('opera/6')!=-1);\n";
      echo "}\n";
      echo "else if(document.layers) xNN4=true;\n";
      echo "else {xIE4Up=document.all && xUA.indexOf('msie')!=-1 && parseInt(navigator.appVersion)>=4;}\n\n";
      echo "var crossFadeDuration = 3\n";
      echo "var Pic = new Array()\n";
      $i = 0;
      $j = 0;
      $start_img = "";
      settype($pos,"integer");
      $pic_query = sql_query("SELECT id, name FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='$galid' and noaff='0'");
      while($picture = sql_fetch_assoc($pic_query)) {
         echo "Pic[$i] = 'modules/$ModPath/imgs/".$picture['name']."'\n";
         if ($picture['id'] == $pid) {
            $j = $i;
            $start_img = "modules/$ModPath/imgs/".$picture['name'];
         }
         $i++;
      }
      echo "var t\n";
      echo "var j = $j\n";
      echo "var p = Pic.length\n";
      echo "var pos = j\n\n";
      echo "var preLoad = new Array()\n\n";
      echo "function preLoadPic(index) {\n";
      echo "  if (Pic[index] != ''){\n";
      echo "    window.status='Loading : '+Pic[index]\n";
      echo "    preLoad[index] = new Image()\n";
      echo "    preLoad[index].src = Pic[index]\n";
      echo "    Pic[index] = ''\n";
      echo "    window.status=''\n";
      echo "  }\n";
      echo "}\n\n";
      echo "function runSlideShow(){\n";
      echo "  if (xIE4Up){\n";
      echo "    document.images.SlideShow.style.filter=\"blendTrans(duration=2)\"\n";
      echo "    document.images.SlideShow.style.filter=\"blendTrans(duration=crossFadeDuration)\"\n";
      echo "    document.images.SlideShow.filters.blendTrans.Apply()\n";
      echo "  }\n";
      echo "  document.images.SlideShow.src = preLoad[j].src\n";
      echo "  if (xIE4Up){\n";
      echo "    document.images.SlideShow.filters.blendTrans.Play()\n";
      echo "  }\n";
      echo "  pos = j\n";
      echo "  j = j + 1\n";
      echo "  if (j > (p-1)) j=0\n";
      echo "  t = setTimeout('runSlideShow()', slideShowSpeed)\n";
      echo "  preLoadPic(j)\n";
      echo "}\n\n";
      echo "function endSlideShow(){\n";
      echo "  self.document.location = '".$ThisRedo."&op=img&galid=".$galid."&pos=".$pos."';\n";
      echo "}\n\n";
      echo "preLoadPic(j)\n";
      echo "//]]>\n";
      echo "</script>\n";
      // Affichage du diaporama
      echo '<div class="card"><div class="card-block">';
      echo '<p class="card-text"><img class="img-fluid" src="'.$start_img.'" name="SlideShow" alt="" /></p>';
      echo '<p class="card-text"><a class="btn btn-secondary btn-sm" href="javascript:endSlideShow()">'.gal_trans("Suspendre le Diaporama").'</a></p>';
      echo '</div></div>';
      echo "<script type=\"text/javascript\">\n//<![CDATA[\nrunSlideShow();\n//]]>\n</script>";
   }
}

/*******************************************************/
//en cours
/*******************************************************/

function PrintFormEcard($galid, $pos, $pid) {
   global $NPDS_Prefix, $ThisRedo, $ThisFile, $ModPath, $MaxSizeThumb, $user, $anonymous;
   settype($galid,"integer");
   $gal = sql_fetch_row(sql_query("SELECT acces FROM ".$NPDS_Prefix."tdgal_gal WHERE id='".$galid."'"));
   if (autorisation($gal[0])) {
      settype($pos,"integer");
      settype($pid,"integer");
      $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE id='".$pid."' and noaff='0'");
      $row = sql_fetch_row($query);
      if (@file_exists("modules/$ModPath/mini/".$row[2])) {
         list($width, $height, $type, $attr) = @getimagesize("modules/$ModPath/mini/$row[2]");
         $ibid = "<img class=\"img-fluid\" src=\"modules/$ModPath/mini/$row[2]\" alt=\"".stripslashes($row[3])."\" border=\"0\" $attr />";
      } else {
         $ibid = ReducePic($row[2],stripslashes($row[3]),$MaxSizeThumb);
      }
      $cookie = cookiedecode($user);
      $username = $cookie[1];
      if ($username == "") { $username = $anonymous; }
      echo '<h4 class="breadcrumb"><a href="'.$ThisFile.'">'.gal_trans("Accueil").'</a></h4>';
      echo "$ibid";
      echo '<br />';
      echo '<p class="lead">'.gal_trans("Envoyer une E-carte de la part de").'</p>';
      echo '<form action="'.$ThisFile.'" method="post" name="FormCard">';
      echo "<input type=\"hidden\" name=\"op\" value=\"sendcard\">";
      echo "<input type=\"hidden\" name=\"galid\" value=\"$galid\">";
      echo "<input type=\"hidden\" name=\"pos\" value=\"$pos\">";
      echo "<input type=\"hidden\" name=\"pid\" value=\"$pid\">";      
      echo '
  <fieldset class="form-group">
    <label for="">'.gal_trans("Votre nom").'</label>
    <input type="text" class="form-control" id=""  name="from_name" placeholder="'.$username.'">
  </fieldset>';
      echo '
  <fieldset class="form-group">
    <label for="">'.gal_trans("Votre adresse e-mail").'</label>
    <input type="email" class="form-control" name="from_mail" id="" placeholder="'.gal_trans("Votre adresse e-mail").'">
  </fieldset>';
      echo '
  <fieldset class="form-group">
    <label for="">'.gal_trans("Nom du destinataire").'</label>
    <input type="text" class="form-control" id=""  name="to_name" placeholder="'.gal_trans("Nom du destinataire").'">
  </fieldset>';
      echo '
  <fieldset class="form-group">
    <label for="">'.gal_trans("Adresse e-mail du destinataire").'</label>
    <input type="email" class="form-control" name="to_mail" id="" placeholder="'.gal_trans("Adresse e-mail du destinataire").'">
  </fieldset>';      
      echo '
  <fieldset class="form-group">
    <label for="">'.gal_trans("Sujet").'</label>
    <input type="text" class="form-control" id=""  name="card_sujet" placeholder="'.gal_trans("Sujet").'">
  </fieldset>';      
      echo '
  <fieldset class="form-group">
    <label for="exampleTextarea">'.gal_trans("Message").'</label>
    <textarea class="tin form-control form-control" name="card_msg" rows="5"></textarea>
  </fieldset>';
      aff_editeur("card_msg","true");


      echo "<input class=\"btn btn-primary\" type=\"submit\" value=".gal_trans("Envoyer comme e-carte").">";
      echo "</form>";
   }
}

/*******************************************************/
//en cours
/*******************************************************/

function PostEcard($galid, $pos, $pid, $from_name, $from_mail, $to_name, $to_mail, $card_sujet, $card_msg) {
   global $NPDS_Prefix, $ThisRedo, $nuke_url, $sitename, $adminmail, $mail_fonction, $ModPath;
   $from_name = removehack(stripslashes(FixQuotes($from_name)));
   $from_mail = removehack(stripslashes(FixQuotes($from_mail)));
   if (!validate_email($to_mail)) {
      $error = "01";
   } else {
      $to_name = removehack(stripslashes(FixQuotes($to_name)));
      if (empty($to_name)) {
         $error = "02";
      } else {
         $to_mail = removehack(stripslashes(FixQuotes($to_mail)));
         if (!validate_email($to_mail)) {
            $error = "03";
         } else {
            $card_sujet = removehack(stripslashes(FixQuotes($card_sujet)));
            if (empty($card_sujet)) {
               $error = "04";
            } else {
               $card_msg = removehack(stripslashes(FixQuotes($card_msg)));
               if (empty($card_msg)) { $error = "05"; }
            }
         }
      }
   }
   if (empty($error)) {
      $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE id='".$pid."' and noaff='0'");
      $row = sql_fetch_row($query);
      $fichier_img = "modules/$ModPath/imgs/$row[2]";
      $data = array(
        'rn' => $to_name,
        'sn' => $from_name,
        'se' => $from_mail,
        'pf' => $fichier_img,
        'su' => $card_sujet,
        'ms' => $card_msg,
      );
      $coded_data = urlencode(base64_encode(serialize($data)));
      $message = "<!DOCTYPE html>";
      $message.= "<head>";
      $message.= "<title>".gal_trans("Une e-carte pour vous")."</title>";
      $message.= '<meta http-equiv="content-type" content="text/html" />';
      $message.= '<meta charset="utf-8" />';
      $message.= '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />';
      $message.= '<meta http-equiv="x-ua-compatible" content="ie=edge" />';
      $message.= '<meta http-equiv="content-script-type" content="text/javascript" />';
      $message.= '<meta http-equiv="content-style-type" content="text/css" />';
      $message.= '<meta http-equiv="expires" content="0" />';
      $message.= '<meta http-equiv="pragma" content="no-cache" />';
      $message.= '<meta http-equiv="cache-control" content="no-cache" />';
      $message.= '<meta http-equiv="identifier-url" content="" />';
      $message.= "</head>";
      $message.= "<body>";
      $message.= "<br />";
      $message.= "<p align=\"center\"><a href=\"$nuke_url/modules.php?ModPath=$ModPath&amp;ModStart=gal_viewcard&amp;data=$coded_data\">";
      $message.= "<b>".gal_trans("Si votre e-carte ne s'affiche pas correctement, cliquez ici")."</b></a></p>";
      $message.= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">";
      $message.= "<tr><td bgcolor=\"#000000\">";
      $message.= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" bgcolor=\"#ffffff\">";
      $message.= "<tr><td valign=\"top\">";
      list($width, $height, $type, $attr) = @getimagesize($fichier_img);
      $message.= "<img src=\"$nuke_url/$fichier_img\" border=\"1\" alt=\"$row[3]\" $attr /><br />";
      $message.= "</td><td valign=\"top\" width=\"200\" height=\"250\">";
      $message.= "<br />";
      $message.= "<b><font face=\"arial\" color=\"#000000\" size=\"4\">$card_sujet</font></b>";
      $message.= "<br /><br /><font face=\"arial\" color=\"#000000\" size=\"2\">$card_msg</font>";
      $message.= "<br /><br /><font face=\"arial\" color=\"#000000\" size=\"2\">$from_name</font>";
      $message.= "(<a href=\"mailto:$from_mail\"><font face=\"arial\" color=\"#000000\" size=\"2\">$from_mail</font></a>)";
      $message.= "</td></tr></table></td></tr></table>";
      $message.= "</body></html>";
      $message = preg_replace("/(?<!\r)\n/si", "\r\n", $message);
      $extra_headers = "Sender: $sitename <$adminmail>\n" . "From: $from_name <$from_mail>\n";
      $extra_headers.= "Reply-To: $from_name <$from_mail>\n" . "MIME-Version: 1.0\n";
      $extra_headers.= "Content-type: text/html; charset=utf-8\n" . "Content-transfer-encoding: 8bit\n";
      $extra_headers.= "Date: " . gmdate('D, d M Y H:i:s', time()) . " UT\n" ."X-Priority: 3 (Normal)\n";
      $extra_headers.= "X-MSMail-Priority: Normal\n" . "X-Mailer: TD-Galerie\n" ."Importance: Normal";
      if (($mail_fonction==1) or ($mail_fonction=="")) {
         $result = mail($to_mail, $card_sujet, $message, $extra_headers);
      } else {
         $pos = strpos($adminmail, "@");
         $tomail=substr($adminmail,0,$pos);
         $result=email($tomail, $to_mail, $card_sujet, $message, $tomail, $extra_headers);
      }
   }
   echo "<p align=\"center\">";
   echo "<table width=\"100%\" cellspacing=\"0\" cellpading=\"2\" border=\"0\"><tr>";
   if (!empty($error) || !$result ) {
      echo "<td><span class=\"text-danger\">".gal_trans("Erreur")."</span></td>";
   } else {
      echo "<td>".gal_trans("Résultat")."</td>";
   }
   echo "</tr><tr>";
   if (!empty($error)) {
      if ($error == "01") { echo "<td align=\"center\">".gal_trans("Votre adresse mail est incorrecte.")."</td>"; }
      if ($error == "02") { echo "<td align=\"center\">".gal_trans("Le nom du destinataire ne peut être vide.")."</td>"; }
      if ($error == "03") { echo "<td align=\"center\">".gal_trans("L'adresse mail du destinataire est incorrecte.")."</td>"; }
      if ($error == "04") { echo "<td align=\"center\">".gal_trans("Le sujet ne peut être vide.")."</td>"; }
      if ($error == "05") { echo "<td align=\"center\">".gal_trans("Le message ne peut être vide.")."</td>"; }
      echo "</tr><tr>";
   }
   if (!$result) { echo "<td align=\"center\">".gal_trans("Votre E-carte n'a pas été envoyée")."</td>"; }
   if ($result) { echo "<td align=\"center\">".gal_trans("Votre E-Carte a été envoyée")."</td>"; }
   echo "</tr></table></p>";
   echo "<script  type=\"text/javascript\">\n";
   echo "//<![CDATA[\n";
   echo "function redirect() {";
   echo "  window.location=\"".$ThisRedo."&op=img&galid=$galid&pos=$pos\"";
   echo "}";
   echo "setTimeout(\"redirect()\",4000);";
   echo "//]]>\n";
   echo "</script>";
}

/*******************************************************/
//à faire
/*******************************************************/

function PostComment($gal_id, $pos, $pic_id, $comm) {
   global $NPDS_Prefix, $ThisRedo, $gmt, $user, $anonymous,$nuke_url;
   //anti_spambot - begin
   global $asb_question, $asb_reponse;
   if (!R_spambot($asb_question, $asb_reponse)) {
      Ecr_Log("security", "Module Anti-Spam : module=td-galerie / url=".$url, "");
      redirect_url($nuke_url."/modules.php?ModPath=td-galerie&ModStart=gal");
      die();
   }
   //anti_spambot - end
   $host = getip();
   settype($gal_id,"integer");
   settype($pos,"integer");
   settype($pic_id,"integer");
   $cookie = cookiedecode($user);
   $name = $cookie[1];
   if ($name == "") { $name = $anonymous; }
   $comment = removeHack($comm);
   $qverif = sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='$pic_id' AND user='$name' AND comhostname='$host'");
   if (sql_num_rows($qverif) == 0) {
      $stamp = time()+($gmt*3600);
      sql_query("INSERT INTO ".$NPDS_Prefix."tdgal_com VALUES('',$pic_id,'$name','$comment','$host','$stamp')");
      redirect_url($ThisRedo."&op=img&galid=$gal_id&pos=$pos");
   } else {

      echo '<p class="lead text-danger">'.gal_trans("Erreur");
      echo '<br />';
      echo ''.gal_trans("Vous avez déjà commenté cette photo").'</p>';

      echo "<script  type=\"text/javascript\">\n";
      echo "//<![CDATA[\n";
      echo "function redirect() {";
      echo "  window.location=\"".$ThisRedo."&op=img&galid=$gal_id&pos=$pos\"";
      echo "}";
      echo "setTimeout(\"redirect()\",4000);";
      echo "//]]>\n";
      echo "</script>";
   }
}

/*******************************************************/
//revu phr 31/01/12
/*******************************************************/

function PostVote($gal_id, $pos, $pic_id, $value) {
   global $NPDS_Prefix, $ThisRedo, $gmt, $user, $anonymous;
   $cookie = cookiedecode($user);
   $name = $cookie[1];
   if ($name == "") { $name = $anonymous; }
   $host = getip();
   settype($gal_id,"integer");
   settype($pos,"integer");
   settype($pic_id,"integer");
   settype($value,"integer");
   $qverif = sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_vot WHERE pic_id='$pic_id' AND user='$name' AND ratinghostname='$host'");
   if (sql_num_rows($qverif) == 0) {
      $stamp = time()+($gmt*3600);
      sql_query("INSERT INTO ".$NPDS_Prefix."tdgal_vot VALUES('','$pic_id','$name','$value','$host','$stamp')");
      redirect_url($ThisRedo."&op=img&galid=$gal_id&pos=$pos");
   } else {      
      echo '<p class="lead text-danger">'.gal_trans("Erreur").'<br />';
      echo ''.gal_trans("Vous avez déjà noté cette photo").'</p>';
      echo "<script  type=\"text/javascript\">\n";
      echo "//<![CDATA[\n";
      echo "function redirect() {";
      echo "  window.location=\"".$ThisRedo."&op=img&galid=$gal_id&pos=$pos\"";
      echo "}";
      echo "setTimeout(\"redirect()\",4000);";
      echo "//]]>\n";
      echo "</script>";
  }
}

/*******************************************************/
//revu phr le 30/01/16
/*******************************************************/

function ViewAlea() {
   global $NPDS_Prefix, $ModPath, $ThisFile, $imglign, $imgpage, $MaxSizeThumb, $aff_comm;
   $reglage = 'col-lg-3';
   $nbcol=4;
   $tab_groupe=autorisation_local();
   // Fabrication de la requête 1
   $where1="";
   $count = count($tab_groupe); $i = 0;
   while (list($X, $val) = each($tab_groupe)) {
      $where1.= "(acces='$val')";
      $i++;
      if ($i < $count) {$where1.= " OR ";}
   }
   $query = sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_gal WHERE $where1");

   // Fabrication de la requête 2
   $where2="";
   $count = sql_num_rows($query); $i = 0;
   while ($row = sql_fetch_row($query)) {
      $where2.= "gal_id='$row[0]'";
      $i++;
      if ($i < $count) {$where2.= " OR ";}
   }
   $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE noaff='0' AND ($where2) ORDER BY RAND() LIMIT 0,$imgpage");

   // Affichage
   $pos = 0;
   echo '<h4 class="breadcrumb">'.gal_trans("Photos aléatoires").'</h4>';   
   echo '<div class="row">';
   while ($row = sql_fetch_row($query)) {
      $nbcom = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='".$row[0]."'"));
      if (file_exists("modules/$ModPath/imgs/".$row[2])) {
         list($width, $height, $type, $attr) = @getimagesize("modules/$ModPath/imgs/$row[2]");
         $ibid = "<img class=\"img-fluid card-img-top\" src=\"modules/$ModPath/imgs/$row[2]\" alt=\"".stripslashes($row[3])."\" border=\"0\" $attr />";
      } else {
         $ibid = ReducePic($row[2],stripslashes($row[3]),$MaxSizeThumb);
      }
      echo "<div class=\"$reglage\"><div class=\"card\"><a href=\"".$ThisFile."&amp;op=img&amp;galid=$row[1]&amp;pos=-$row[0]\">$ibid</a>";
      echo "<div class=\"card-block\">".$row[4]." ".gal_trans("affichage(s)");
      if ($aff_comm)
         echo "<br />$nbcom ".gal_trans("commentaire(s)");
      echo '</div></div>';
      echo '</div>';
      $pos++;
     if (is_int($pos/$imglign)) { echo '</div><div class="row">'; }
   }
   echo "</div>";
}

/*******************************************************/
//revu phr le 30/01/16
/*******************************************************/

function ViewLastAdd() {
   global $NPDS_Prefix, $ModPath, $ThisFile, $imglign, $imgpage, $MaxSizeThumb, $aff_comm;
   $reglage = 'col-lg-3';
   $nbcol=4;
   // Fabrication de la requête 1
   $where1="";
   $tab_groupe=autorisation_local();
   $count = count($tab_groupe); $i = 0;
   while (list($X, $val) = each($tab_groupe)) {
      $where1.= "(acces='$val')";
      $i++;
      if ($i < $count) {$where1.= " OR ";}
   }
   $query = sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_gal WHERE $where1");

   // Fabrication de la requête 2
   $where2="";
   $count = sql_num_rows($query); $i = 0;
   while ($row = sql_fetch_row($query)) {
      $where2.= "gal_id='$row[0]'";
      $i++;
      if ($i < $count) {$where2.= " OR ";}
   }
   $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE noaff='0' AND ($where2) ORDER BY ordre,id DESC LIMIT 0,$imgpage");

   // Affichage
   $pos = 0;
   echo '<h4 class="breadcrumb">'.gal_trans("Derniers ajouts").'</h4>';
//   echo '<br />';
   echo '<div class="row">';
   while ($row = sql_fetch_row($query)) {
      $nbcom = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_com WHERE pic_id='".$row[0]."'"));
      if (file_exists("modules/$ModPath/imgs/".$row[2])) {
         list($width, $height, $type, $attr) = @getimagesize("modules/$ModPath/imgs/$row[2]");
         $ibid = "<img class=\"img-fluid card-img-top\" src=\"modules/$ModPath/imgs/$row[2]\" alt=\"".stripslashes($row[3])."\" border=\"0\" $attr />";
      } else {
         $ibid = ReducePic($row[2],stripslashes($row[3]),$MaxSizeThumb);
      }
      echo "<div class=\"$reglage\"><div class=\"card\"><a href=\"".$ThisFile."&amp;op=img&amp;galid=$row[1]&amp;pos=-$row[0]\">$ibid</a>";
      echo "<div class=\"card-block\">".$row[4]." ".gal_trans("affichage(s)");
      if ($aff_comm)
         echo "<br />$nbcom ".gal_trans("commentaire(s)");
      echo '</div></div>';
      echo '</div>';
      $pos++;
      if (is_int($pos/$imglign)) { echo "</div><div class=\"row\">"; }
   }
   echo "</div>";
}

/*******************************************************/
//ok
/*******************************************************/

function autorisation_local() {
   global $user, $admin;
   if ($user) {
      $groupe = valid_group($user);
      $groupe[] = 1;
   }
   if ($admin) {
      $groupe[] = -127;
   }
   $groupe[] = 0;
   return ($groupe);
}

/*******************************************************/
//ok
/*******************************************************/

function GetPos($galid, $pos) {
   global $NPDS_Prefix;
   settype($galid,"integer");
   settype($pos,"integer");
   // Trouve l'ID
   $id = -$pos;
   $query = sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_img WHERE gal_id='$galid' and noaff='0' ORDER BY ordre,id");
   $i = 0;
   // Boucle déterminant la position de l'image dans son album
   while($row = sql_fetch_row($query)) {
      if ($row[0] == $id) { return $i; } else { $i++; }
   }
}

/*******************************************************/
//revu phr le 31/01/16
/*******************************************************/
// SOUS-FONCTIONS
function GetGalArbo($galid) {
   global $NPDS_Prefix, $ThisFile;

   settype($galid,"integer");
   $temp = sql_fetch_row(sql_query("SELECT cid FROM ".$NPDS_Prefix."tdgal_gal WHERE id='".$galid."'"));
   $query = sql_query("SELECT cid,nom FROM ".$NPDS_Prefix."tdgal_cat WHERE id='".$temp[0]."'");
   $row = sql_fetch_row($query);

   if ($row[0] == 0) {
      $retour = "<a class=\"breadcrumb-item\" href=\"".$ThisFile."&op=cat&catid=".$temp[0]."\">".stripslashes($row[1])."</a>";
   } else {
      $queryX = sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_cat WHERE id='".$row[0]."'");
      $rowX = sql_fetch_row($queryX);
      $retour = "<a class=\"breadcrumb-item\" href=\"".$ThisFile."&op=cat&catid=".$row[0]."\">".stripslashes($rowX[0])."</a>";
      $retour .= "<a class=\"breadcrumb-item\" href=\"".$ThisFile."&op=sscat&catid=".$row[0]."&sscid=".$temp[0]."\">".stripslashes($row[1])."</a>";
   }
   return $retour;
}

/*******************************************************/
//à voir
/*******************************************************/

//Fonction de reduction de la taille d'une image
function ReducePic($image, $comment, $Max) {
   global $ModPath;

   $image = "modules/$ModPath/imgs/".$image;
   $taille = @getimagesize("$image");
   $h_i = $taille[1];
   $w_i = $taille[0];

   if (($h_i > $Max) || ($w_i > $Max)) {
      if ($h_i > $w_i) {
         $convert = $Max/$h_i;
         $h_i = $Max;
         $w_i = ceil($w_i*$convert);
      } else {
         $convert = $Max/$w_i;
         $w_i = $Max;
         $h_i = ceil($h_i*$convert);
      }
   }
   return "<img src=\"$image\" height=\"$h_i\" width=\"$w_i\" alt=\"$comment\" border=\"0\" />";
}

/*******************************************************/
//ok
/*******************************************************/

function validate_email($email) {
   if (!preg_match('#^[_\.0-9a-z-]+@[0-9a-z-]+\.+[a-z]{2,4}$#i',$email)) {
      return false;
   }
   return true;
}

/*******************************************************/
//en cours
/*******************************************************/

function TopCV($typeOP, $nbtop) {
   global $ThisFile, $ModPath, $NPDS_Prefix;

   settype($nbtop,"integer");
   echo '<h4 class="breadcrumb"><a href="'.$ThisFile.'">'.gal_trans("Accueil").'</a></h4>';

   echo '<table class="table">';
   echo "<tr><td> ".gal_trans("IMAGES")."</td>";
   if ($typeOP=="comment")
      echo "<td> ".gal_trans("Top")." $nbtop ".gal_trans("des images les plus commentées")."</td>";
   else
      echo "<td>".gal_trans("Top")." $nbtop ".gal_trans("des images les plus notées")."</td>";
   echo "</tr>";
   echo "<tr>";
   $TableRep=sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_img WHERE noaff='0'");
   $NombreEntrees=sql_num_rows($TableRep);
   $TableRep1=sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_com");
   $NombreComs=sql_num_rows($TableRep1);
   $TableRep2=sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_vot");
   $NombreComs1=sql_num_rows($TableRep2);
   echo "<td><ul><li>".gal_trans("Nombre d'images")." : $NombreEntrees</li><li>".gal_trans("Nombre de commentaires")." : $NombreComs</li><li>".gal_trans("Nombre de notes")." : $NombreComs1</li></ul></td>";
   echo "<td>";
   echo "<table class=\"table\">";
   if ($typeOP=="comment")
      $result1 = sql_query("SELECT pic_id, count(user) AS pic_nbcom FROM ".$NPDS_Prefix."tdgal_com GROUP BY pic_id ORDER BY pic_nbcom DESC limit 0,$nbtop");
   else
      $result1 = sql_query("SELECT pic_id, count(user) AS pic_nbvote FROM ".$NPDS_Prefix."tdgal_vot GROUP BY pic_id ORDER BY pic_nbvote DESC limit 0,$nbtop");
   while (list($pic_id, $nb) = sql_fetch_row($result1)) {
      $result2=sql_fetch_assoc(sql_query("SELECT gal_id, name, comment FROM ".$NPDS_Prefix."tdgal_img WHERE id='$pic_id' AND noaff='0'"));

      echo "<tr><td>";
      if ($result2) {
         echo "<a href=modules.php?ModPath=$ModPath&ModStart=gal&op=img&galid=" .($result2['gal_id'])."&pos=-".$pic_id.">";
      }
      $vignette="modules/$ModPath/mini/".$result2['name'];
      list($width, $height, $type, $attr) = @getimagesize($vignette);
      $comm_vignette=StripSlashes($result2['comment']);
      echo "<img src=\"modules/$ModPath/mini/".$result2['name']."\" width=\"$width\" height=\"$height\" alt=\"$comm_vignette\" border=\"0\"></a></td>";
      if ($typeOP=="comment")
         echo "<td><ul><li>".gal_trans("Nombre de commentaires")." : $nb</li>";
      else
         echo "<td><ul><li>".gal_trans("Nombre de vote(s)")." : $nb</li>";
      $tailleo = @filesize("modules/$ModPath/imgs/".$result2['name']);
      $taille = $tailleo/1000;
      echo "<li>".gal_trans("Taille du fichier")." ".$taille." Ko</li>";
      echo "<li>".gal_trans("Dimensions")." ".$width." x ".$height." Pixels</li>";
      echo "</ul></td></tr>";
   }
   echo "</tr></table>";
   echo "</tr></table>";

   sql_free_result($result1);

}

/*******************************************************/
//ok
/*******************************************************/

function GetGalCat($galcid) {
   global $NPDS_Prefix;

   $query = sql_query("SELECT nom,cid FROM ".$NPDS_Prefix."tdgal_cat WHERE id='".$galcid."'");
   $row = sql_fetch_row($query);

   if ($row[1] == 0) {
      return stripslashes($row[0]);
   } else {
      $queryX = sql_query("SELECT nom FROM ".$NPDS_Prefix."tdgal_cat WHERE id='".$row[1]."'");
      $rowX = sql_fetch_row($queryX);
      return stripslashes($rowX[0])." - ".stripslashes($row[0]);
   }
}

/*******************************************************/
//à faire
/*******************************************************/

function select_arbo($sel) {
   global $NPDS_Prefix;

   $ibid="<option value=\"-1\">".gal_trans("Galerie temporaire")."</option>\n";
   $sql_cat = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='0' ORDER BY nom ASC");
   $num_cat = sql_num_rows($sql_cat);
   if ($num_cat != 0) {
      $sql_sscat = "SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid!=0";
      $sql_gal = "SELECT * FROM ".$NPDS_Prefix."tdgal_gal";
      // CATEGORIE
      while ($row_cat = sql_fetch_row($sql_cat)) {
         $ibid.="<optgroup label=\"".stripslashes($row_cat[2])."\">\n";
         $queryX = sql_query("SELECT id, nom  FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='".$row_cat[0]."' ORDER BY nom ASC");
         while ($rowX_gal = sql_fetch_row($queryX)) {
            if ($rowX_gal[0] == $sel) { $IsSelected = " selected"; } else { $IsSelected = ""; }
            $ibid.="<option value=\"".$rowX_gal[0]."\"$IsSelected>".stripslashes($rowX_gal[1])." </option>\n";
         } // Fin Galerie Catégorie

         // SOUS-CATEGORIE
         $query = sql_query("SELECT * FROM ".$NPDS_Prefix."tdgal_cat WHERE cid='".$row_cat[0]."' ORDER BY nom ASC");
         while ($row_sscat = sql_fetch_row($query)) {
            $ibid.="<optgroup label=\"  ".stripslashes($row_sscat[2])."\">\n";
            $querx = sql_query("SELECT id, nom FROM ".$NPDS_Prefix."tdgal_gal WHERE cid='".$row_sscat[0]."' ORDER BY nom ASC");
            while ($row_gal = sql_fetch_row($querx)) {
               if ($row_gal[0] == $sel) { $IsSelected = " selected"; } else { $IsSelected = ""; }
               $ibid.="<option value=\"".$row_gal[0]."\"$IsSelected>".stripslashes($row_gal[1])." </option>\n";
            } // Fin Galerie Sous Catégorie
            $ibid.="</optgroup>\n";
         } // Fin Sous Catégorie
         $ibid.="</optgroup>\n";
      } // Fin Catégorie
   }
   return ($ibid);
}

/*******************************************************/
//revu phr le 31/01/16
/*******************************************************/

// Propositions de photos par les membres
function PrintFormImgs() {
   global $ModPath, $ModStart, $NPDS_Prefix, $ThisFile, $ThisRedo, $user;

   // Récupération de l'utilisateur connecté pour initialisation du champ user_connecte et transmission à AddImgs
   $userinfo=getusrinfo($user);
   $user_connecte=$userinfo["uname"];

   $qnum = sql_num_rows(sql_query("SELECT id FROM ".$NPDS_Prefix."tdgal_cat"));
   if ($qnum == 0) {
      redirect_url($ThisRedo);
   }

   echo "<h4 class=\"breadcrumb\"><a href=\"".$ThisFile."\">".gal_trans("Accueil")."</a></h4>";
   echo "<p>".gal_trans("Proposer des images")."</p>";
   echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"".$ThisFile."\" name=\"FormImgs\">";
   echo "<input type=\"hidden\" name=\"op\" value=\"addimgs\">";
   echo "<input type=\"hidden\" name=\"user_connecte\" value=\"".$user_connecte."\">";
   echo '
      <fieldset class="form-group">
      <label for="exampleSelect1">'.gal_trans("Galerie").'</label>
      <select name="imggal" class="form-control">';
   echo select_arbo("");
   echo '</select>';
   echo '</fieldset>';
   echo '
      <fieldset class="form-group">
      <label for="">'.gal_trans("Image 1").'</label>
      <input type="file" class="form-control-file" name="newcard1" id="">
      <small class="text-muted">'.gal_trans("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc1" placeholder="'.gal_trans("Description").'">
      </fieldset>';
   echo '
   <fieldset class="form-group">
      <label for="">'.gal_trans("Image 2").'</label>
      <input type="file" class="form-control-file" name="newcard2" id="">
      <small class="text-muted">'.gal_trans("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc2" placeholder="'.gal_trans("Description").'">
   </fieldset>';
   echo '
   <fieldset class="form-group">
      <label for="">'.gal_trans("Image 3").'</label>
      <input type="file" class="form-control-file" name="newcard3" id="">
      <small class="text-muted">'.gal_trans("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc3" placeholder="'.gal_trans("Description").'">
   </fieldset>';
   echo '
   <fieldset class="form-group">
      <label for="">'.gal_trans("Image 4").'</label>
      <input type="file" class="form-control-file" name="newcard4" id="">
      <small class="text-muted">'.gal_trans("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc4" placeholder="'.gal_trans("Description").'">
   </fieldset>'; 
   echo '
   <fieldset class="form-group">
      <label for="">'.gal_trans("Image 5").'</label>
      <input type="file" class="form-control-file" name="newcard5" id="">
      <small class="text-muted">'.gal_trans("Sélectionner votre image").'</small>
      <input type="text" class="form-control" id=""  name="newdesc5" placeholder="'.gal_trans("Description").'">
   </fieldset>';
   echo "<input class=\"btn btn-primary\" type=\"submit\" value=".gal_trans("Envoyer").">";
   echo '</form>';
}

/*******************************************************/
//revu phr le 31/01/16
/*******************************************************/

// Ajout de photos par les membres
function AddImgs($imgscat,$newcard1,$newdesc1,$newcard2,$newdesc2,$newcard3,$newdesc3,$newcard4,$newdesc4,$newcard5,$newdesc5,$user_connecte) {
   global $language, $MaxSizeImg, $MaxSizeThumb, $ModPath, $ModStart, $NPDS_Prefix, $ThisFile, $adminmail, $nuke_url, $notif_admin;
   include_once("modules/upload/lang/upload.lang-$language.php");
   include_once("modules/upload/clsUpload.php");

   $newdesc1=$newdesc1.gal_trans(" proposé par ").$user_connecte;
   $newdesc2=$newdesc2.gal_trans(" proposé par ").$user_connecte;
   $newdesc3=$newdesc3.gal_trans(" proposé par ").$user_connecte;   
   $newdesc4=$newdesc4.gal_trans(" proposé par ").$user_connecte;
   $newdesc5=$newdesc5.gal_trans(" proposé par ").$user_connecte;

   $year = date("Y"); $month = date("m"); $day = date("d");
   $hour = date("H"); $min = date("i"); $sec = date("s");

   echo '<h4 class="breadcrumb"><a href="'.$ThisFile.'">'.gal_trans("Accueil").'</a></h4>';
   echo '<p>'.gal_trans("Proposer des images").'</p>';
   echo "<ul>";
   $soumission=false;
   $i=1;
   while($i <= 5) {
      $img = "newcard$i";
      $tit = "newdesc$i";
      if (!empty($$img)) {
         $newimg = stripslashes(removeHack($$img));
         if (!empty($$tit)) {
            $newtit = addslashes(removeHack($$tit));
         } else {
            $newtit = "";
         }
         $upload = new Upload();
         $upload->maxupload_size=200000*100;
         $origin_filename = trim($upload->getFileName("newcard".$i));
         $filename_ext = strtolower(substr(strrchr($origin_filename, "."),1));
      
         if ( ($filename_ext=="jpg") or ($filename_ext=="gif") ) {
            $newfilename = $year.$month.$day.$hour.$min.$sec."-".$i.".".$filename_ext;
            if ($upload->saveAs($newfilename,"modules/$ModPath/imgs/", "newcard".$i,true)) {
               if ((function_exists('gd_info')) or extension_loaded('gd')) {
                  @CreateThumb($newfilename, "modules/$ModPath/imgs/", "modules/$ModPath/imgs/", $MaxSizeImg, $filename_ext);
                  @CreateThumb($newfilename, "modules/$ModPath/imgs/", "modules/$ModPath/mini/", $MaxSizeThumb, $filename_ext);
               }
               if (sql_query("INSERT INTO ".$NPDS_Prefix."tdgal_img VALUES ('','$imgscat','$newfilename','$newtit','','0','1')")) {
                  echo "<li>".gal_trans("Photo envoyée avec succès, elle sera traitée par le webmaster")." : $origin_filename</li>";
                  $soumission=true;
               } else {
                  echo "<li><span class=\"text-danger\">".gal_trans("Impossible d'ajouter l'image en BDD")." : $origin_filename</span></li>";
                  @unlink ("modules/$ModPath/imgs/$newfilename");
                  @unlink ("modules/$ModPath/mini/$newfilename");
               }
            } else {
               echo "<li><span class=\"text-danger\">".$upload->errors."</span></li>";
            }
         } else {
            if ($filename_ext!="")
               echo "<li><span class=\"text-danger\">".gal_trans("Ce fichier n'est pas un fichier jpg ou gif")." : $origin_filename</span></li>";
         }
      }
      $i++;
   }
   echo "</ul>";
   if ($notif_admin and $soumission) {
      $subject=gal_trans("Nouvelle soumission de Photos");
      $message=gal_trans("Des photos viennent d'être proposées dans la galerie photo du site ").$nuke_url.gal_trans(" par ").$user_connecte;
      send_email($adminmail, $subject, $message, "", true, "html");
   }
}

/*******************************************************/
//à faire
/*******************************************************/

// CreateThumb($newfilename, "modules/$ModPath/imgs/", "modules/$ModPath/mini/", $MaxSizeThumb, $filename_ext);
function CreateThumb($Image, $Source, $Destination, $Max, $ext) {
   if ($ext=="gif") {
      if (function_exists("imagecreatefromgif"))
         $src=@imagecreatefromgif($Source.$Image);
   } else {
      $src=@imagecreatefromjpeg($Source.$Image);
   }
   if ($src) {
      $size = getimagesize($Source.$Image);
      $h_i = $size[1]; //hauteur
      $w_i = $size[0]; //largeur

      if (($h_i > $Max) || ($w_i > $Max)) {
         if ($h_i > $w_i) {
            $convert = $Max/$h_i;
            $h_i = $Max;
            $w_i = ceil($w_i*$convert);
         } else {
            $convert = $Max/$w_i;
            $w_i = $Max;
            $h_i = ceil($h_i*$convert);
         }
      }

      if (function_exists("imagecreatetruecolor")) {
         $im = @imagecreatetruecolor($w_i, $h_i);
      } else {
         $im = @imagecreate($w_i, $h_i);
      }

      @imagecopyresized($im, $src, 0, 0, 0, 0, $w_i, $h_i, $size[0], $size[1]);
      @imageinterlace ($im,1);
      if ($ext=="gif") {
         @imagegif($im, $Destination.$Image);
      } else {
         @imagejpeg($im, $Destination.$Image, 100);
      }
      @chmod($Dest.$Image,0766);
   }
}
?>