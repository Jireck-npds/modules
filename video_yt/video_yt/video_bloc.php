<?php
/************************************************************************/
/* DUNE by NPDS                                                         */
/* ===========================                                          */
/*                                                                      */
/* NPDS Copyright (c) 2002-2008 by Philippe Brunier                     */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* Module video_yt                                                      */
/* video_bloc file 2007 by jpb                                          */
/*                                                                      */
/* version 2.0 12/12/09                                                 */
/************************************************************************/

$ModPath = 'video_yt';
include ('modules/'.$ModPath.'/video_yt_conf.php');
include ('config.php');
$stream = file_get_contents("http://gdata.youtube.com/feeds/api/videos?start-index=1&max-results=25&author=$account");
//mise en tableau
preg_match_all('#<(media:title)[^>]*>([^<]*)</\1>#s',$stream,$regs);
  $ar_title=$regs[2];//titre
preg_match_all('#<entry><id>((.*?)(videos/)(.*?))</id>#s',$stream,$regs);
  $ar_id=$regs[4];
preg_match_all('#<media:thumbnail url=\'(.*?)\'#s',$stream,$regs);
  $ar_thumbnail_url=$regs[1];
  $ar_thumbnail_media = array_chunk($ar_thumbnail_url,4);

srand ((double) microtime() * 10000000); // for old php  < 4.2.0...
$vid_ran = array_rand ($ar_id, 1);//the second parameter can be change 1 ou +
$content = '';
$nb = 0;
if (is_array($vid_ran)) {$nb = count($vid_ran);} else {$nb = 1;};
for($i = 0; $i<$nb; $i++)
{
if (is_array($vid_ran)) {$id_ran=$vid_ran[$i];} else {$id_ran=$vid_ran;};
$content.= '<div id ="player_bloc_'.$i.'" title="'.$ar_title[$id_ran].'" >';
//conform xhtml
//$content.= '<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$ar_id[$id_ran].'?f=videos&amp;app=youtube_gdata&amp;rel=1&amp;border=0&amp;fs=1&amp;autoplay=0" width="'.$bloc_width.'" height="'.$bloc_height.'" id="yt_player_bloc_'.$i.'" style="visibility: visible; "><param name="allowfullscreen" value="true"></object></div>';
}
//for all brownser but non conform

$content .= ' <!-- video_yt --><object width="'.$bloc_width.'" height="'.$bloc_height.'">
 <param name="movie" value="http://www.youtube.com/v/GwQMnpUsj8I&hl=en&fs=1" />
<param name="allowFullScreen" value="true" />
<param name="allowscriptaccess" value="always" />
<embed src=http://www.youtube.com/v/'.$ar_id[$id_ran].'&fs=1 
 type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$bloc_width.'" height="'.$bloc_height.'" />
</object><!-- video_yt -->';
/*
$content.='
  <script type="text/javascript">
  swfobject.registerObject("bloc_FlashContent", "9.0.0");
  </script>
   <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$bloc_width.'" height="'.$bloc_height.'" id="bloc_FlashContent">
    <param name="movie" value="http://www.youtube.com/v/'.$ar_id[$id_ran].'" />
    <param name="play" value="false" />
    <param name="allowfullscreen" value="true" />
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$ar_id[$id_ran].'" width="'.$bloc_width.'" height="'.$bloc_height.'">
     <param name="play" value="false" />
     <param name="allowfullscreen" value="true" />
    <!--<![endif]-->
     <a href="http://www.adobe.com/go/getflashplayer">
      <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
     </a>
    <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
   </object>';
*/
$content .= '</div>';
$content .= '<br /><a href="modules.php?ModPath=video_yt&amp;ModStart=video_yt">[french]Vid&#xE9;oth&#xE8;que[/french][english]Videos[/english][chinese]&#x5F55;&#x5F71;[/chinese]</a> | <a href="http://gdata.youtube.com/feeds/users/'.$account.'/uploads" target="blank"><img style="vertical-align:middle;" src ="modules/'.$ModPath.'/images/standard_rss.png" border="0" alt="RSS icon" />
</a>';
$content = aff_langue($content);
?>