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

//agenda
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=calendrier*']['title']="[french]Agenda[/french][english]Diary[/english][spanish]Agenda[/spanish][german]Tagebuch[/german][chinese]日记[/chinese]+";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=calendrier*']['run']="yes";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=calendrier*']['blocs']="0";

//annee
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annee*']['title']="[french]Année[/french][english]Year[/english][spanish]Año[/spanish][german]Jahr[/german][chinese]年[/chinese]+";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annee*']['run']="yes";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annee*']['blocs']="0";

//lieu
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=lieu*']['title']="[french]Ville[/french][english]City[/english][spanish]Ciudad[/spanish][german]Stadt[/german][chinese]城市[/chinese]+";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=lieu*']['run']="yes";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=lieu*']['blocs']="0";

//ajout
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['title']="[french]Ajouter un événement[/french][english]Add an event[/english][spanish]Añadir un evento[/spanish][german]Event eintragen[/german][chinese]添加事件[/chinese]+";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['run']="yes";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['blocs']="0";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['TinyMce']=1;
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['TinyMce-theme']="short";

//administration
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['title']="[french]Administrer votre événement[/french][english]Manage your event[/english][spanish]Dar a su evento[/spanish][german]Geben Sie Ihre Veranstaltung[/german][chinese]给你的事件[/chinese]+";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['run']="yes";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['blocs']="0";
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['TinyMce']=1;
   $PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['TinyMce-theme']="short";

?>