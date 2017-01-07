<?php
ob_start();

require ('../bibli_html_fonct.php');
require ('../bibli_php_fonct.php');
require ('../bibli_requets_sql.php');
require ('../setting.php');

$niveauDossier = 2;
$dossier = niveauDossier($niveauDossier);

$IDArticle = (int) getURL();	// R�cup�ration des param�tres URL

//-- Connexion base de donnée --------------------------------------
bdConnection();

//Requet SQL
$queryNomArticle = queryNomArticle($IDArticle);
$queryCommentaireArticle = queryCommentaireArticle($IDArticle);
//Fin Requet SQL

// Sous Titre de la fenetre pop-up
$bdTitreAr = mysqli_query($GLOBALS['bd'], $queryNomArticle ) or bdErreurRequet($queryNomArticle);

$arN = mysqli_fetch_assoc($bdTitreAr);



mysqli_free_result($bdTitreAr);
//Fin Sous Titre de la fenetre pop-up




$coAuteur = $coTexte = '';
$erreurs = array();		// Tableau des messages d'erreur des zones invalides


//_____________________________________________________________________________
//
// Traitement soumission du formulaire de saisie
//
// Bien que ce ce traitement soit la seconde chose � faire, le code
// doit �tre avant celui qui traite la saisie pour qu'en cas d'erreur
// les �l�ments saisis puissent �tre r�affich�s.
//_____________________________________________________________________________



if (isset($_POST['btnValider'])) {
	// On v�rifie si les zones saisies sont valides. Si oui on fait la mise
	// � jour de la base de donn�es puis on ferme la fen�tre avec JavaScript.
	$erreurs = fpl_verifZones();
	if (count($erreurs) == 0) {
		$fpl_majBase = fpl_majBase($IDArticle , stripslashes($_POST['coAuteur']) , stripslashes($_POST['coTexte']));

		$R = mysqli_query($GLOBALS['bd'], $fpl_majBase) or bdErreurRequet($fpl_majBase);	// Mise � jour BD
		// Fermeture fen�tre.
		// La fermeture est un peu sp�ciale : on force la page appelante
		// � se recharger avec opener.location.reload()
		// L'�v�nement onunload de la page appelante est d�clecnch�
		// et les fen�tres popup encore ouvertes sont automatiquement
		// ferm�es (donc cette fen�tre). En proc�dant ainsi on recharge
		// la page des articles avec le nombre de commentaires mis � jour.
		// Si on ne veut pas de ce rechargement de la page appelante, il
		// suffit de remplacer opener.location.reload() par self.close();
		// Un autre solution consisterait � faire la mise � jour du nombre
		// de commentaires avec JavaScript. Plus complexe � g�rer. Si vous
		// �tes interress� par la technique demandez moi.
		echo '<html>',
				'<head>',
					'<title>x</title>',
				'</head>',
				'<body>',
					'<script type="text/javascript">',
					'opener.location.reload();',
					'self.close();',
					'</script>',
				'</body>',
			'</html>';
		exit();	// Fin du script
	}

	// Si on passe ici c'est que des zones de saisie ne sont pas valides.
	// On va r�afficher toutes les zones du formulaire et les messages d'erreur.
	// On commence par enlever �ventuellement les protections automatiques
	// de caract�res faite par PHP, puis on extrait les variables de $_POST
	foreach($_POST as $cle => $zone) {
		$_POST[$cle] = stripslashes($zone);
	}
	$coAuteur = $_POST['coAuteur'];
	$coTexte = $_POST['coTexte'];
}


firstPop($dossier , 'Ajouter un commentaire' ,  fp_protectHTML($arN['arTitre']));


// Affichage des erreurs de saisie pr�c�dentes
if (count($erreurs) > 0) {
	fp_htmlErreurs($erreurs);
}


//	Affichage du formulaire de saisie :
//  Nom de l'auteur
//  Texte du commentaire

// Les param�tres du lien sont crypt�s (IDArticle)
$url = makeURL('commentaire_ajout.php', $IDArticle);

echo '<form method="post" action="', $url, '">',
		'<table>';

fp_htmlSaisie('T', 'coAuteur', $coAuteur, 'Pseudo', 60, 60);
fp_htmlSaisie('A', 'coTexte', $coTexte, 'Commentaire', 60, 6);

fp_htmlBoutons(2, 'B|btnFermer|Fermer|self.close();opener.focus()', 'S|btnValider|Valider');

//	Fin de page
echo 	'</table>',
	'</form>',
	'</div>',
	'</body></html>';

ob_end_flush();  // Fermeture du buffer => envoi du contenu au navigateur


?>
