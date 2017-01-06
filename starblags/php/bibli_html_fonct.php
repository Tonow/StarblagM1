<?php


/**
 * Permet de generer le html pour le footer de tout les page
 *
 * @return void --> le footer html
 */
function footerGlobal(){
  echo <<<FOOTER
  <div id="blcPied">
		StarBlagS est une marque déposée appartenant à la société PTICON(PiaT International Corporation Original Network)
		<br>&nbsp;
		<br>
		<a href="#" onclick="alert('Faux lien !'); return false;">Contactez-nous</a> -
		<a href="#" onclick="alert('Faux lien !'); return false;">Informations l égales</a> -
		<a href="#" onclick="alert('Faux lien !'); return false;">Conditions d utilisation</a>
	</div>
	<!-- FIN DU BLOC PIED -->
FOOTER;
}


/**
 * Permet de generer le html pour le bandeau de tout les page
 *
 * @param string $dossier niveau dans le quelle se trouve le dossier
 *
 * @return void --> le beadeau html
 */
function blocBandeau($dossier){
	echo <<<BANDEAU
	<div id="blcBandeau">
		<form method="post" action="php/login.php">
			<label for="txtPseudo">Pseudo</label>
			<input type="text" name="txtPseudo" id="txtPseudo" value="">
			<label for="txtPasse">Passe</label>
			<input type="password" name="txtPasse" id="txtPasse" value="">
			<input type="submit" name="btnLogin" value="Mon blog" class="bouton">
			<input type="submit" name="btnNouveau" value="Créer un blog" class="bouton">
		</form>
		<a href="$dossier/php/">
			<img src="$dossier/images/logo.gif" title="Accueil StarBlagS" width="104" height="67">
		</a>
	</div> <!-- FIN DU BLOC BANDEAU -->
BANDEAU;
}

/**
 * Permet de generer le html pour le head de tout les page en personalisant le titre
 *
 * @param string $titre titre de la page
 * @param string $dossier niveau dans le quelle se trouve le dossier
 *
 * @return void --> le head html
 */
function headPublique($titre , $dossier){
	echo <<<HEAD1
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
HEAD1;

  echo "<title>StarBlags - $titre</title>";

		echo <<<HEAD2
		<link rel="stylesheet" href="$dossier/css/modele_1.css" type="text/css">
		<script type="text/javascript" src="$dossier/js/bibli.js"></script>
	</head>
HEAD2;
}


/**
 * Permet de generer le html pour le debut de tout les pages
 *
 * @return void --> le debut html de tout les pages
 */
function firstHtml(){
	echo '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>';
}


/**
 * Permet de generer le html pour la fin de tout les pages
 *
 * @return void --> la fin html de tout les pages
 */
function endHtml(){
	echo "
	</body>
	</html>
	";
}




/**
 * Permet de generer le html pour tout les debut des pop-up tout les page en personalisant le titre
 * et le sousTitre de chaqu'un d'entre eu
 *
 * @param string $dossier niveau dans le quelle se trouve le dossier
 * @param string $titre titre de la page
 * @param string $sousTitre sous-titre de la page
 *
 * @return void --> le debut html des pop-up
 */
function firstPop($dossier, $titre= 'titreAchanger' , $sousTitre = 'sousTitreAchanger' ){

	echo '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>@_TITLE_@</title>
		<script type="text/javascript">
		if (window.opener == null) {
			document.location.replace("index.php");
		}
		</script>
		<link rel="icon" type="image/gif" href="'.$dossier.'/images/favicon.gif">
		<link rel="stylesheet" href="'.$dossier.'/css/modele_1.css" type="text/css">
		<script type="text/javascript" src="'.$dossier.'/js/bibli.js"></script>
	</head>
	<body>
		<div id="blcPopPage">
			<div id="blcPopBandeau">
				<div id="blcPopTitre">'.$titre.'</div>
				</div>
			<h2>'.$sousTitre.'</h2>';
}






//_____________________________________________________________________________
/**
 * Affiche le code html d'une ligne de boutons de formulaire.
 *
 * Cette fonction accepte un nombre variable de param�tres.
 * Seul le premier est d�fini dans la d�finition de la fonction.
 * Les param�tres suivants d�finissent les boutons.
 * La d�finition d'un bouton se fait dans une zone alpha de la forme :
 *  Type|Nom|Valeur|JavaScript
 * 	Type	type du bouton
 * 		S : submit
 * 		R : reset
 * 		B : button
 * 	Nom		nom du bouton  (attribut name)
 * 	Valeur	valeur du bouton (attribut value)
 * 	JavaScript	fonction JavaScript pour �v�n�ment onclick
 *
 * Exemple : fp_htmlBoutons(2, 'B|btnRetour|Liste des sujets|history.back()', 'S|btnValider|Valider'
 *
 * @param	integer	$colspan	Nombre de colonnes de tableau � joindre. Si -1 pas dans un tableau
 * @param	string	Ind�fini	D�finition d'un bouton. Il peut y avoir
 * 								autant de d�finitions que d�sir�.
 */
function fp_htmlBoutons($colspan) {
	if ($colspan == -1) {
		echo '<p align="right">';
	} else {
		echo '<tr>',
				'<td colspan="', $colspan, '">&nbsp;</td>',
			'</tr>',
			'<tr>',
				'<td colspan="'.$colspan.'" align="right">';
	}

	$nbArg = func_num_args();

	for ($i = 1; $i < $nbArg; $i++) {
		$bouton = func_get_arg($i);
		$description = explode('|', $bouton);

		if ($description[0] == 'S') {
			$description[0] = 'submit';
		} elseif ($description[0] == 'R') {
			$description[0] = 'reset';
		} elseif ($description[0] == 'B') {
			$description[0] = 'button';
		} else {
			continue;
		}

		if (!isset($description[3])) {
			$description[3] = '';
		}

		echo '&nbsp;&nbsp;',
				'<input type="', $description[0], '" ',
				'name="', $description[1], '" ',
				'value="', $description[2], '" ',
				'class="bouton" ',
				( ($description[3] == '') ? '>' : 'onclick="'.$description[3].'">');
	}

	echo ($colspan == -1) ? '</p>' : '</td></tr>';
}


?>
