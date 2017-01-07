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

firstPop($dossier , 'Ajouter un commentaire' ,  fp_protectHTML($arN['arTitre']));

mysqli_free_result($bdTitreAr);
//Fin Sous Titre de la fenetre pop-up

?>
