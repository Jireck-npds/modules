<?php
# Fichier langue en anglais

#A
$L['Admin1']				= "<p>Create the first administrator<br />\nHe/she will be able to create other administators later</p>";
$L['Admin']					= 'Administrator';
$L['Admins']				= 'Administrators';
$L['Administration']		= 'Administrating the petitions';
$L['Adresse_Admin']			= "Administrator's email";
$L['Adresse_Invalide']		= 'incorrect email (forbidden character, inexistant domain, ...)';
$L['aideNomPetition']		= "The petition's name is internal to the sql tables.<br>It does'nt contain space.";
$L['AideRecuperation']		= '<p>In case the database crashes you can attempt to repair it. It <b>may</b> allow you, with no warranty, not to loose any data (restoring the base will <b>inevitably</b> destroy the signatures collected since the last backup.';
$L['AideRestauration']		= '<p>In case the database crashes you can restore a backup. You must put a backup file (as recent as possible) in the <b>tmp/sauvegarde</b> directory.</p><p>Indicate below the name of your backup file</p>';
$L['AideSauvegarde']		= '<br />It is recommended to backup the database on a regular basis. In case it crashes, you will then be able to restore it (do not forget to make a local copy!).<br />The backup of the database will be stored in the file <b>tmp/sauvegarde/sauvegarde.sql</b> (or <b>tmp/sauvegarde/sauvegarde.sql.zip</b> if you choose to compress it to minimize transfer duration).';
$L['AjoutAdministrateur']	= '>> New administrator >>';
$L['Ajout_Signatures']		= 'Add petitioners';
$L['Annonce_Texte_Petition']		= "Petition text";
$L['AucuneSignatureAvecCeNumero']	= "No pending signature was found with this confirmation number.<br /> Either you have already confirmed your signature or there was a transmission error.";
$L['Aujourdhui']			= 'Today';

#B
$L['Bad_Name']				= "creation: incorrect petition'name (";
$L['Bad_Right']				= 'creation: directory creation failed';
$L['Bouton_Admin']			= '>> Administrator creation >>';
$L['Bouton_Admin2']			= '>> Save >>';
$L['Bouton_Ajouter']		= '>> Add <<';
$L['Bouton_Connecter']		= '>> Connect <<';
$L['Bouton_CreationTables']	= '>> Create Tables >>';
$L['Bouton_Envoyer']		= '<< Send >>';
$L['Bouton_Recuperer']		= '>> Repair the database <<';
$L['Bouton_Restaurer']		= '>> Restore the database <<';
$L['Bouton_Recharger_Page']	= '>> Reload the page >>';
$L['Bouton_Sauve']			= '>> Save <<';
$L['Bouton_Sauvegarder']	= '>> Save the database <<';
$L['Bouton_Suite']			= '>> Next >>';
$L['Bouton_Supprimer']		= '>> Delete <<';
$L['Bouton_Terminer']		= '>> Finish >>';

#C
$L['champ_manquant']		= "Some mandatory fields are missing";
$L['ChoixLangue']			= 'Choice of a language';
$L['ChoisirLangue']		= 'Choose the site language';
$L['Compression']			= 'Activate compression';
$L['Connection']				= 'Petitions - Entering in the administration area';
$L['Connexion_Ok']			= 'Connection successful...';
$L['Courriel']				= 'Email:';
$L['Courrier_Au_Nom_De'] = "in the name of";
$L['Courrier_Avons_Recu_Demande_Signature'] = "We have just received a signature request for petition";
$L['Courrier_Cordialement'] = "Sincerely yours,";
$L['Courrier_Eviter_Plaisanterie_Confirmer_Signature'] = "In order to avoid any joke, we request that you confirm your signature.";
$L['Courrier_Pour_Confirmer_Cliquer'] = "To confirm your signature, you just need to click on the hyperlink below:";
$L['Courrier_Signature_Validee_Apres_Cette_Operation'] = "Your signature will not be validated until this operation is completed.";
$L['Courrier_Sinon_Pas_Repondre'] = "If you do not wish to confirm this signature, please ignore this message: your data will be erased from the database.";
$L['Creation_Ok']			= 'Petition tables sucessfully created';

#D
$L['Deconnexion']			= 'Logout';
$L['DejaSigne']				= 'You have already signed...';
$L['Demande_Confirmation']	= 'Confirmation request';
$L['Droits_Ok']				= "Succeded...";

#E
$L['en']					= 'in';
$L['EditAdmin']				= 'Edit an administrator';
$L['EditionAdmin']			= 'Editing an administrator';
$L['Erreur_Base']			= 'Unknow base... ';
$L['Erreur_Connexion']		= 'Connection failed... ';
$L['Erreur_Droits']			= "Write test failed...<br/>Change permissions for directories below:<br />\n ";
$L['Erreur_Droits2']		= "<p>Use your ftp client to change permissions on these directories (they must have permissions 777), then reload this page";
$L['Erreur_ReInstallation']	= 'Tentative de re-installation interdite !';
$L['Erreur_Remplissage']	= 'Error when populating the table';
$L['Erreur_Table']			= 'Error when creating table ';
$L['Erreur_voici_fichier_manquant']	= 'Error. The following file is missing:';
$L['Etape12']				= 'During the next step, the required tables will be created.';
$L['Exporter']				= '>> Export >>';

#F
$L['Form_Adresses_Campagne']		= "The email addresses collected during this campaign will not be used for other purposes.";
$L['Form_Erreur']			= "There is an error in the form:";
$L['Form_Infos']			= 'Complementary information (profession, city...): ';
$L['Form_Mel']				= 'Email address: ';
$L['Form_Mel2']				= 'Email address verification: ';
$L['Form_Nom']				= 'Name: ';
$L['Form_Oui']			= 'yes';
$L['Form_Pour_Eviter_Plaisanterie_Courriel_Confirmation'] = "In order to avoid any joke, a confirmation request will be sent to your email address. To confirm your signature, you will simply need to click on the hyperlink in the message.";
$L['Form_Prenom']			= 'First Name: ';
$L['Form_Recevoir_Infos_Campagne']	= 'I would like to receive occasional information about this campaign:';
$L['Form_Revenir_au_formulaire']	= 'Go back to the form';
$L['Form_Signer']			= 'Sign';
$L['Form_Titre']			= "Title: ";
$L['Form_Votre_Adresse_Est']		= 'Your IP address is:';
$L['Form_Vous_Avez_Demande_A_Signer'] = "You requested to sign the petition";

#G
$L['GerePetoches']			= 'Administer the following petitions:';
$L['Gerer']					= 'Signature administration';
$L['Gestion']				= "<p>In the window below, enter the signatures you want to add or to remove (one per line) and click on the appropriate button.<br />\nEach line must have the following format:</p>\n<p align='center'><b>lastname:firstname:infos:level:email</b></p>\n<p>The name and firstname are mandatory, the other fields are optional<br />\nlevel=0 corresponds to a basic signature,<br />\nlevel=1 corresponds to an initiator of the petition</p>";

#I
$L['I_Connexion']			= "Please provide now the information that you have received:<br>\n<blockquote>\n<li>Sql server: the database server</li>\n<li>Sql base: your database. Your administrator must have given you its name</li>\n<li>Sql login: the database access login - not <b>your</b> login</li>\n<li>Sql password: The database access password - not <b>your</b> password</li>";
$L['IlYA']					= "there are"; #remarque : aucune utilisation de cette entree dans le code ?
$L['Info_Signature']		= 'Receive notification when new signatures are registered';
$L['Interro1']				= '';
$L['Interro2']				= '?';

#J
$L['JS_Confirm_Suppression_Admin']		= "Do you REALLY want to delete the administrator";
$L['JS_Confirm_Suppression_Petition']	= "Do you REALLY want to drop the petition";
$L['JS_Confirm_Suppression_Traduction']	= "Do you REALLY want to drop the translation into ";

#L
$L['L_Administration']		= 'Administration';
$L['Label_Adresse_Robot']	= "contact email: <br />\n<font size='-1'>it will be something like contact@my_ong.org</font>";
$L['Label_Archive']			= 'Archive';
$L['Label_BaseSql']			= 'Sql database: ';
$L['Label_Brouillon']		= 'Draft';
$L['Label_Colonne_Action']	= 'Action';
$L['Label_Colonne_Nom']		= 'Name';
$L['Label_Colonne_Statut']	= 'Status';
$L['Label_Date_Init']		= 'Start date';
$L['Label_Enligne']			= 'Active';
$L['Label_LoginSql']		= 'Sql login: ';
$L['Label_Nom']				= 'Name:';
$L['Label_PasswordSql']		= 'Sql password: ';
$L['Label_ServeurSql']		= 'SQL server: ';
$L['Label_TextePetition']	= "Petition text<br><font size='-1'>\nUse SPIP-like typographic shortcuts</font>";
$L['Langage']				= 'language';
$L['LangageDuSite']			= 'Web site language';
$L['ListePetitions']		= 'List of the petitions on this server';
$L['ListePetitions_EC']		= 'Active petitions';
$L['ListePetitions_AR']		= 'Archived petitions';
$L['Login']					= 'Login: ';

#M
$L['Maintenance']			= 'Maintenance';
$L['MerciSignature']	= "Thank you for your signature. It is now included in the database of the signatures for this petition.";
$L['Msg_AjoutChamps']		= "Add <span class='grasitalic'>%s</span> field in <span class='grasitalic'>%s</span> table";
$L['Msg_CreationTable']		= "Table <span class='grasitalic'>%s</span> creation";
$L['Msg_CreationIndexTable']= "Index <span class='grasitalic'>%s</span> creation in <span class='grasitalic'>%s</span> table";
$L['Msg_MajTable']			= "Update <span class='grasitalic'>%s</span> table";
$L['Msg_ModifChamps']		= "Change <span class='grasitalic'>%s</span> field in <span class='grasitalic'>%s</span> table";
$L['Msg_RemplirTable']		= "Populate table <span class='grasitalic'>%s</span>";
$L['Mettre1Jour']			= '<<Upgrade>>';   #remarque : aucune utilisation de cette entree dans le code ?
$L['MiseAJour']				= 'Software upgrade';
$L['MiseAJour_exp1']		= 'Because the software was upgraded, the sql tables must now be modified... It is recomended to backup the database (using such a tool as PhpMyAdmin) to be able to step back.'; 
$L['MiseAJourEnCours']      = 'Upgrade in progress...';
$L['MiseAJourTable']        = 'Upgrading the tables';
$L['MiseAJourTermine']      = 'Upgrade completed';

#N
$L['Nom']					= 'Name: ';
$L['NomPetition']			= 'Petition name: ';
$L['Nouvelle_Petition']		= 'Create a petition';

#O
$L['OrdreAlpha']			= 'in alphabetic order';
$L['Outils']				= 'Maintenance';

#P
$L['Page_Avant']			= 'Back to the form';
$L['Page_Reload']			= 'Reload the page';
$L['Pas_Modele']			= 'No template found';
$L['PasConfigure']			= 'Site not configured yet...';
$L['PasSauvegarde']			= 'Dues to the configuration, the backup engine is\'nt avaible. Fixe the htaccess problem to re-enable it.';
$L['Password']				= 'Password: ';
$L['Personnaliser_Petition']	= "How to customize a petition";
$L['Perso_A_Recopier_Puis_Modifier_Dans'] = "to be copied and modified in directory";
$L['Perso_Balises_Correspondantes_demo']  ="Some of the tags that correspond to new fields are used in file";
$L['Perso_Ce_Sont_Fichiers_fr_FR_etc']	= "These are files <code>fr_FR.php</code>, <code>en_EN.php</code>, etc, in directory";
$L['Perso_Exemples_Champs_demo']	= "Examples of new fields are to be found in file";
$L['Perso_Liste_Balises']	= "List of available tags";
$L['Perso_Nom_Petition']	= "PetitionName";
$L['Perso_Possible_Nouveaux_Champs_Formulaire']	= "It is possible to add new fields in the signature form of your petition.";
$L['Perso_Pour_Info_css']	= "To know more about <code>css</code>, see for instance <a href=\"http://en.wikipedia.org/wiki/Cascading_Style_Sheets\">wikipedia</a>.";
$L['Perso_Pour_Modifier_Apparence_css_Et_class']	= "To change the page appearance, alter the <code>*.css</code> file in this directory and change the corresponding <code>class</code> attributes in the HTML tags of <code>*.html</code> files. You can of course create new ones if needed.";
$L['Perso_Pour_Modifier_Champs_Affiches_Utiliser_Balises']	= "To change the fields displayed in your petition pages, use tags.";
$L['Perso_Pour_Modifier_Phrases_Utiliser_Fichiers_Langues']	= "To change the sentences displayed in your petition pages, use the language files.";
$L['Perso_Recopiez_Tous_Fichiers_du_Repertoire']	= "Copy all files you wish to customize from directory";
$L['Perso_Vers_le_Repertoire']	= "into directory";
$L['Petition']				= 'Petition';
$L['phpPetitions']			= '<div id=phpPetitions>This petition is propulsed by the free software <a href="http://phpPetitions.net">phpPetitions</a></div>';
$L['PourSignerRemplissez']		= "In order to sign the petition, please fill in this form (fields marked with a <span class=\"champ_obligatoire\">*</span> are mandatory, in particular your email address). You will receive a confirmation request via email.";
$L['Prefixe']				= 'Prefix to be used for the table names';
$L['Propriete']				= 'Properties';

#R
$L['Rappel']				= 'Reminder';
$L['Recharger']				= ' Reload the page';
$L['Recuperation']          = 'Database repair';
$L['Relance']				= "Type the reminder message text. Variables understood by the program are:<ul>\n<li> #NOM: submitter's name</li>\n<li> #PRENOM: submitter's first name</li>\n<li> #INFO : complementary informations</li>\n<li> #LIEN: URL for confirming the signature</li></ul>";
$L['Restauration']          = 'Database restoration';
$L['RestaurationEnCours']   = 'Database restoration in progress';
$L['RestaurationTermine']   = 'Database restoration completed...';
$L['RetourSommaire']		= 'Back to index';

#S
$L['Sauvegarde']            = 'Database backup';
$L['SauvegardeEnCour']      = 'Database backup in progress';
$L['SauvegardeTermine']     = 'Database backup completed';
$L['Signataires']			= 'Petitioners:';
$L['Signatures_Ajoutees']	= 'Signatures to be added (<b><i>Name:First Name:Informations</i></b>)';
$L['Signatures']			= 'Signatures:';
$L['signaturesAjoutees']	= 'Added signatures: ';
$L['signaturesRejetees']	= 'Rejected signatures: ';
$L['signaturesRetires']		= 'Dropped signatures: ';
$L['Signer']				= 'Sign the petition';
$L['sousTitre']				= 'Subtitle: ';
$L['Statut']				= 'Status: ';
$L['Supprimer']				= 'Drop the petition';
$L['SupprimerAdmin']		= 'Drop an administrator';
$L['Supprimer_Signatures']	= 'Drop some signatures';

#T
$L['T_Admin']				= 'Creating the Administrator';
$L['T_Administrateurs']		= 'Administrators';
$L['T_Administration']		= 'Administration';
$L['T_Connexion']			= 'Test of the database connection';
$L['T_Gestion']				= 'Gestion';   # remarque : cette entree n'est pas utilisee dans le code
$L['T_LSignatures']			= 'List';
$L['T_Petition']			= 'Petitions';
$L['T_Signatures']			= 'Signatures';
$L['T_Table']				= 'Table creation';
$L['Test_Connexion']		= 'Testing of the connection...';
$L['Test_Droits']			= 'Testing the permissions...';
$L['title_Ajouter']			= 'Add';
$L['title_AjouterAdmin']	= 'Add an administrator';
$L['title_Editer']			= 'Edit';
$L['title_EditerAdmin']		= "Edit administrator";
$L['title_Effacer']			= 'Erase';
$L['title_EffacerAdmin']	= "Drop administrator";
$L['title_voir']			= 'See the petition online';
$L['Titre_VoirSignature']	= 'List of signatures of &laquo;';
$L['Titre']					= 'phpPetition';
$L['Titre_Administrateurs']	= 'Administration of the administrators';
$L['Titre_Ajout']			= 'Add signatures to ';
$L['Titre_Creation']		= "Creation of a new petition";
$L['Titre_Edition']			= 'Editing the petition ';
$L['Titre_Gestion']			= 'Administrating the petitions on your site ';
$L['Titre_Initiateurs']	= 		'First signatures';
$L['Titre_Installation']	= 'phpPetition installation';
$L['Titre_ParametresSql']	= 'Sql connection parameters';
$L['Titre_Relance']			= 'Launch the confirmation reminders for ';
$L['Titre_Retrait']			= 'Remove some signatures from ';
$L['Titre_Signatures']		= 'Administrating the signatures of ';
$L['Titre_Sous_Titre']		= 'Petition sub-title - #SOUS_TITRE tag';
$L['Titre_Titre']			= 'Petition title - #TITRE tag';
$L['Titre_Verification']	= 'Audit rights';
$L['TraductionsDisponibles']= 'Available translations';
$L['TypeAdmin']				= "Administrator type";

#V
$L['VerificationDroits']	= "<p>In order to avoid an error or an illegal operation, this procedure requires that you authentify yourself by creating a file - or a directory - in directory <b><i>tmp</i></b></p>In that directory, please create a file (or a directory) named: ";
$L['VerificationDroits2']	= '<p>Then reload this page (by pressing key F5) or click on the button</p>';
$L['Voir_Signatures']		= 'See petitioners';

# les mois en francais
$lesmois = array(
 'January', "February", 'March', 'April', 'May', 'June',
 'July', "August", 'September', 'October', 'November', "December"
);

$LesLangues	= array (
	'de_DE'	=> 'German',
	'en_EN'	=> 'English',
	'es_ES'	=> 'Spanish',
	'fr_FR'	=> 'French',
	'it_IT'	=> 'Italian',
	'pt_PT'	=> 'Portuguese'
);

# vim: ts=4 ai
?>
