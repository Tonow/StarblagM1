<?php

function footerGlobal(){
  echo <<<FOOTER
  <div id="blcPied">
		StarBlagS est une marque d�pos�e appartenant � la soci�t� PTICON(PiaT International Corporation Original Network)
		<br>&nbsp;
		<br>
		<a href="#" onclick="alert('Faux lien !'); return false;">Contactez-nous</a> -
		<a href="#" onclick="alert('Faux lien !'); return false;">Informations l�gales</a> -
		<a href="#" onclick="alert('Faux lien !'); return false;">Conditions d utilisation</a>
	</div>
	<!-- FIN DU BLOC PIED -->
FOOTER;
}


function blocBandeau($dossier){
	echo <<<BANDEAU
	<div id="blcBandeau">
		<form method="post" action="php/login.php">
			<label for="txtPseudo">Pseudo</label>
			<input type="text" name="txtPseudo" id="txtPseudo" value="">
			<label for="txtPasse">Passe</label>
			<input type="password" name="txtPasse" id="txtPasse" value="">
			<input type="submit" name="btnLogin" value="Mon blog" class="bouton">
			<input type="submit" name="btnNouveau" value="Cr�er un blog" class="bouton">
		</form>
		<a href="$dossier/php/">
			<img src="$dossier/images/logo.gif" title="Accueil StarBlagS" width="104" height="67">
		</a>
	</div> <!-- FIN DU BLOC BANDEAU -->
BANDEAU;
}


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



function firstHtml(){
	echo <<<FIRST1
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
FIRST1;
}


function endHtml(){
	echo "
	</body>
	</html>
	";
}


?>
