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
	</head>
HEAD2;
}


/**
 * Permet de generer le html pour le debut de tout les pages
 *
 * @return void --> le debut html de tout les pages
 */
function firstHtml(){
	echo <<<FIRST1
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
FIRST1;
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


?>
