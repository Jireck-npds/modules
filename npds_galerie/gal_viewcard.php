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

/**************************************************************************************************/
/* Page de visualisation d'une e-carte                                                            */
/**************************************************************************************************/

// For More security
if (!stristr($_SERVER['PHP_SELF'],"modules.php")) { die(); }
if (strstr($ModPath,"..") || strstr($ModStart,"..") || stristr($ModPath, "script") || stristr($ModPath, "cookie") || stristr($ModPath, "iframe") || stristr($ModPath, "applet") || stristr($ModPath, "object") || stristr($ModPath, "meta") || stristr($ModStart, "script") || stristr($ModStart, "cookie") || stristr($ModStart, "iframe") || stristr($ModStart, "applet") || stristr($ModStart, "object") || stristr($ModStart, "meta")) {
   die();
}
// For More security

   global $language;
   include_once("modules/$ModPath/gal_conf.php");
   include_once("modules/$ModPath/gal_func.php");
   include_once("modules/$ModPath/lang/galerie-$language.php");
   if (!isset($data)) { redirect_url("modules.php?ModPath=$ModPath&ModStart=gal"); }

   $card_data = array();
   $card_data = @unserialize(@base64_decode($data));
   list($width, $height, $type, $attr) = getimagesize($card_data['pf']);
   
/*   
echo '
   <!DOCTYPE html>
   <head>
   <title>'.gal_translate("Une E-carte pour vous").'</title>
   <meta charset="utf-8" />   
   <meta http-equiv="content-type" content="text/html" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />  
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta http-equiv="content-script-type" content="text/javascript" />   
   <meta http-equiv="content-style-type" content="text/css" />  
   <meta http-equiv="expires" content="0" />
   <meta http-equiv="cache-control" content="no-cache" />
   <meta http-equiv="identifier-url" content="" />
   <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
   <link rel="stylesheet" href="lib/bootstrap/dist/css/bootstrap.min.css" />
   </head>
   <body>';
   echo '<br />';
   echo '
       <div class="col-md-8">   
   <div class="card">
   <div class="card-header">E-card de <a href="mailto:'.$card_data['se'].'">'.$card_data['sn'].'</a></div>
   <img class="img-fluid" src="'.$card_data['pf'].'" '.$attr.' />
   <div class="card-body">
   <h4 class="card-title">'.$card_data['su'].'</h4>';
   echo $card_data['ms'];
   echo '</div> 
   </div>
   </div>   
   <br />   
   </body></html>';*/

   
   
   $message = '<!DOCTYPE html>';
   $message.= '<head>';
   $message.= '<title>'.gal_translate("Une E-carte pour vous").'</title>';
   $message.= '<meta charset="utf-8" />';
   $message.= '<meta http-equiv="content-type" content="text/html" />';
   $message.= '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />';  
   $message.= '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
   $message.= '<meta http-equiv="content-script-type" content="text/javascript" />';   
   $message.= '<meta http-equiv="content-style-type" content="text/css" />';  
   $message.= '<meta http-equiv="expires" content="0" />';
   $message.= '<meta http-equiv="cache-control" content="no-cache" />';
   $message.= '<meta http-equiv="identifier-url" content="" />';
   $message.= '<link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">';
   $message.= '<link rel="stylesheet" href="lib/bootstrap/dist/css/bootstrap.min.css" />';
   $message.= '</head>';
   $message.= '<body>';
   $message.= '<br />';
   $message.= '<div class="col-md-7">';
   $message.= '<div class="card">';
   $message.= '<div class="card-header">E-card de <a href="mailto:'.$card_data['se'].'">'.$card_data['sn'].'</a></div>';
   $message.= '<img class="card-img-top img-fluid" src="'.$card_data['pf'].'" '.$attr.' />';
   $message.= '<div class="card-body">';
   $message.= '<h4 class="card-title">'.$card_data['su'].'</h4>';
   
   $message.= $card_data['ms'];
//   preg_replace("''", "'", $card_data['ms']);   
   $message.= '</div>';
   $message.= '</div>';
   $message.= '</div>';
   $message.= '<br />';
   $message.= '</body></html>';
   echo $message;
   
   
   
   
   
?>