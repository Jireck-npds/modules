<?php
 /***************************************************************************\
  *  phpPetitions, serveur de pétition pour php/Mysql                       *
  *                                                                         *
  *  Copyleft (c) 2003-2005                                                 *
  *  Francois Sauterey, Asdrad Torres, Joel Pothier                         *
  *  le Centre Ressource du Réseau Associatif et Syndical                   *
  *                                                                         *
  *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
  *  Pour plus de details voir le fichier COPYING.txt                       *
 \***************************************************************************/

// Fichier langue en espagnol - Lengua : español
// Contribucion de Fernando

#A
$L['A1ami']					= 'Enviar a un amigo';
$L['Action']				= 'Acción';
$L['Admin']					= 'Administradores';
$L['Adresse_Robot']			= "Dirección de contacto : <br />\n    <font size='-1'>Indique la dirección de contacto de la iniciativa. Ejemplo : contacto@mon_asso.org</font>";
$L['aideNomPetition']		= 'El nombre de la petición es interno a las tablas.<br>No debe llevar espacios ni carácteres especiales.';
$L['AideRestauration']		= '<p>In case the database crashes you can restore a backup. You must put a backup file (as recent as possible) in the <b>tmp/sauvegarde</b> directory.</p><p>Indicate below the name of your backup file</p>';
$L['AideSauvegarde']		= '<br />It is recommended to backup the database on a regular basis. In case it crashes, you will then be able to restore it (do not forget to make a local copy!).<br />The backup of the database will be stored in the file <b>tmp/sauvegarde/sauvegarde.sql</b> (or <b>tmp/sauvegarde/sauvegarde.sql.zip</b> if you choose to compress it to minimize transfer duration).';
$L['Ajout_Signatures']		= 'Agregar firmas';
$L['AucuneSignatureAvecCeNumero']	= "Aucune signature en attente de validation avec ce numéro de confirmation n'a été trouvée.<br /> Soit vous avez déjà confirmé, soit une erreur de transmission est intervenue.";
$L['Aujourdhui']			= 'Hoy';

#B
$L['Bouton_Ajouter']		= '>> Agregar <<';
$L['Bouton_Connecter']		= '>> Conectar <<';
$L['Bouton_Envoyer']		= '<< Enviar >>';
$L['Bouton_Sauve']			= '>> Registrar <<';
$L['Bouton_Recharger_Page']	= '>> Recargar la página >>';
$L['Bouton_Suite']			= '>> Next >>';
$L['Bouton_Supprimer']		= '>> Suprimir <<';
$L['Bouton_CreationTables']	= '>> Creación de tablas>>';

#C
$L['ChoixLangue']			= 'elección del idioma';
$L['ChoisirLangue']			= 'elección del idioma del sitio';
$L['Connection']			= 'Peticiones - Entrada en la administración';

#D
$L['Deconnexion']			= 'Desconectar';
$L['DejaSigne']				= 'Usted ya ha firmado ...';
$L['Demande_Confirmation']	= 'Solicitud de confirmación';

#E
$L['en']					= 'en';
$L['Editer']				= 'Gestión de las firmas';
$L['Erreur_Droits']			= "Write test failed... Change permissions for directories below:<br />\n ";
$L['Erreur_Droits2']		= "<p>Use your ftp client to change the permissions on these directories (they must have permissions 777), then reload this page";
$L['Erreur_ReInstallation']	= 'Tentative de re-installation interdite !';
$L['Erreur_voici_fichier_manquant']	= 'Erreur. Falta le fichier suivant :';
$L['Etat']					= 'Estado';

#F
$L['Form_Titre']			= 'Título : ';
$L['Form_Nom']				= 'Nombre : ';
$L['Form_Prenom']			= 'Prénom : ';
$L['Form_Infos']			= 'Informations complémentaires (profession, localité...) : ';
$L['Form_Mel']				= 'Adresse électronique : ';
$L['Form_Mel2']				= "Vérification de l'adresse électronique : ";
$L['Form_Recevoir_Infos_Campagne']	= 'Je veux recevoir occasionnellement des informations sur la campagne :';
$L['Form_Oui']			= 'si';
$L['Form_Signer']			= 'Firmar';
$L['Form_Votre_Adresse_Est']= 'Votre adresse IP est :';
$L['Form_Adresses_Campagne']= "Les adresses électroniques recueillies dans le cadre de cette campagne ne seront pas utilisées à d'autres fins.";

#G
$L['Gestion']				= '<p>Ingrese las firmas por agregar o retirar  (una por línea)\n en la ventana aquí abajo y pulse el botón correspondiente.<br />\n El formato de cada línea debe ser:</p>\n <p align="center"><b>apellido:nombre:informaciones:nivel:dirección</b></p>\n<p>apellido y nombre son obligatorios, los otros facultativos<br />\nun nivel=0 corresponde a una firma de base,<br />\nun nivel=1 corresponde a un iniciador</p>';

#I
$L['IlYA']					= 'hay';
$L['Info_Signature']		= 'Prevenirme de las nuevas firmas';
$L['Interro1']				= '¿';
$L['Interro2']				= '?';

#J
$L['JS_Confirm_Suppression_Traduction'] = 'JS_Confirm_Suppression_Traduction';

#L
$L['Label_BaseSql']			= 'Base de datos Sql : ';
$L['Label_Date_Init']		= 'Fecha de inicio';
$L['Label_LoginSql']		= 'Sql login : ';
$L['Label_PasswordSql']		= 'Sql password : ';
$L['Label_ServeurSql']		= 'SQL server : ';
$L['LanguageDuSite']		= 'Langua del sitio';
$L['ListePetitions']		= 'Peticiones en el servidor';
$L['ListePetitions_EC']		= 'Peticiones en espera de firmas';
$L['ListePetitions_AR']		= 'Peticiones archivadas en el servidor';

#M
$L['MerciSignature']	= "Nous vous remercions pour votre signature. Elle a été ajoutée à la base des signatures de la pétition.";
$L['Msg_AjoutChamps']		= "Add <span class='grasitalic'>%s</span> field in <span class='grasitalic'>%s</span> table";
$L['Msg_CreationTable']		= "Creación de la table <span class='grasitalic'>%s</span>";
$L['Msg_CreationIndexTable']= "Index <span class='grasitalic'>%s</span> creación en la table <span class='grasitalic'>%s</span>";
$L['Msg_MajTable']			= "Update <span class='grasitalic'>%s</span> table";
$L['Msg_ModifChamps']		= "Change <span class='grasitalic'>%s</span> field in <span class='grasitalic'>%s</span> table";
$L['Msg_RemplirTable']		= "tabla <span class='grasitalic'>%s</span> completa";

#N
$L['Nom']					= 'Nombre : ';
$L['NomPetition']			= 'Nombre de la petición : ';
$L['Nouvelle_Petition']		= 'Crear una petición';

#O
$L['OrdreAlpha']			= 'alfabéticamente';

#P
$L['Page_Avant']			= 'Volver al formulario';
$L['Page_Reload']			= 'Recargar la página';
$L['Pas_Modele']			= 'No hay un modelo que mostrar';
$L['PasConfigure']			= 'Sitio no configurado...';
$L['PasSauvegarde']			= 'Dues to the configuration, the backup engine is\'nt avaible. Fixe the htaccess problem to re-enable it.';
$L['Password']				= 'Contraseña : ';
$L['Petition']				= 'Petición';
$L['phpPetitions']			= '<div id=phpPetitions>pétition réalisée avec le logiciel libre <a href="http://phpPetitions.net">phpPetitions</a></div>';
$L['Propriete']				= 'Propriedad';
$L['PourSignerRemplissez']		= "In order to sign the petition, please fill in this form (fields marked with a <span class=\"champ_obligatoire\">*</span> are mandatory, in particular your email address). You will receive a confirmation request via email.";
$L['Prefixe']				= 'Prefix to be used for the table names';

 #R
$L['radio_archive']			= 'Archivo';
$L['radio_brouillon']		= 'Borrador';
$L['radio_enligne']			= 'A Firmar';
$L['Rappel']				= 'Reactivar';
$L['Recharger']				= ' Reload the page';
$L['Relance']				= "Ingrese el texto del mensaje de reactivacioán. Las variables comprendidas por el programa son:<ul>\n<li> #NOM : el apellido del firmante</li>\n<li> #PRENOM : su nombre</li>\n<li> #INFO : las informaciones complementarias</li>\n<li> #LIEN : el enlace activo</li></ul>";
$L['RetourSommaire']		= 'Retour au sommaire';

#S
$L['Signataires']			= 'Signatarios';
$L['Signatures_Ajoutees']	= 'Firmas a agregar (<b><i>Apellido:Nombre;Nombre:Informaciones</i></b>)';
$L['Signatures']			= 'Firmas :';
$L['signaturesAjoutees']	= 'Firmas agregadas : ';
$L['signaturesRejetees']	= 'Firmas rechazadas : ';
$L['signaturesRetires']		= 'Firmas retiradas : ';
$L['Signer']				= 'Firmar la petición';
$L['sousTitre']				= 'Subtítulo : ';
$L['Statut']				= 'Estatuto : ';
$L['Supprimer_Signatures']	= 'Suprimir  Firmas';

#T
$L['T_Administrateurs']		= 'Administradores';
$L['T_Administration']		= 'Administración';
$L['T_Gestion']				= 'Gestión';
$L['T_Petition']			= 'Peticiones';
$L['T_Signatures']			= 'Firmas';
$L['TextePetition']			= 'Texto de la Petición<br><font size="-1">\nUtilizar las etiquetas de Spip</font>';
$L['title_Ajouter']			= 'Agregar';
$L['title_AjouterAdmin']	= 'Agregar un administrador';
$L['title_Editer']			= 'Editar';
$L['title_EditerAdmin']		= "Edición de Administrador";
$L['title_Effacer']			= 'Borrar';
$L['title_EffacerAdmin']	= "Quitar Administrador";
$L['Titre']					= 'phpPetitions';
$L['Titre_Installation']	= 'Installación de phpPetitions';
$L['Titre_Administrateurs']	= 'Gestión de los administradores';
$L['Titre_Ajout']			= 'Agregar firmas a ';
$L['Titre_Edition']			= 'Edición de la Petición ';
$L['Titre_Gestion']			= 'Gestión de las peticiones de su sitio ';
$L['Titre_Initiateurs']		= 'Premiers signataires';
$L['Titre_ParametresSql']	= 'Configuración de la conexión';
$L['Titre_Retrait']			= 'Retirar firmas a ';
$L['Titre_Relance']			= 'Reactivación de confirmaciones de firmas de ';
$L['Titre_Signatures']		= 'Gestión de Firmas de ';
$L['Titre_Sous_Titre']		= 'Subtítulo de la Petición - elemento #SOUS_TITRE';
$L['Titre_Titre']			= 'Título de la Petición - elemento #TITRE';
$L['Titre_Verification']	= 'Auditoría de los derechos';
$L['TraductionsDisponibles']= 'Traductions disponibles';

#V
$L['VerificationDroits']	= "<p>In order to avoid an error or an illegal operation, this procedure requires that you authentify yourself by creating a file - or a directory - in directory <b><i>tmp</i></b></p>In that directory, please create a file (or a directory) named: ";
$L['VerificationDroits2']	= '<p>Then reload this page (by pressing key F5) or click on the button</p>';
$L['Voir_Signatures']			= 'Ver los firmantes';


// Los meses en español
$lesmois = array(
	'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
	'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
);


$LesLangues	= array (
	'de_DE'	=> 'Alemán',
	'en_EN'	=> 'Ingles',
	'es_ES'	=> 'Castillan',
	'fr_FR'	=> 'Frances',
	'it_IT'	=> 'Italiano',
	'pt_PT'	=> 'Portugués'
);

# vim: ts=4 ai
?>
