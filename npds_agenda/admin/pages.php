<?php

	//agenda
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=calendrier*']['title']="[french]Agenda[/french][english]Diary[/english]+|$title+";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=calendrier*']['run']="yes";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=calendrier*']['blocs']="0";


	//annee
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annee*']['title']="[french]Année[/french][english]Year[/english]+|$title+";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annee*']['run']="yes";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=annee*']['blocs']="0";


	//lieu
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=lieu*']['title']="[french]Ville[/french][english]City[/english]+|$title+";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=lieu*']['run']="yes";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=lieu*']['blocs']="0";


	//ajout
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['title']="[french]Ajouter un évènement[/french][english]Add an event[/english]+|$title+";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['run']="yes";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['blocs']="0";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['TinyMce']=1;
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=agenda_add*']['TinyMce-theme']="short";

	//administration
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['title']="[french]Administrer votre évènement[/french][english]Manage your event[/english]+|$title+";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['run']="yes";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['blocs']="0";
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['TinyMce']=1;
	$PAGES['modules.php?ModPath='.$ModPath.'&ModStart=administration*']['TinyMce-theme']="short";


?>