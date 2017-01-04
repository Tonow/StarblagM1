<?php

ob_start(); // bufferisation


require ('bibli_html_fonct.php');
require ('bibli_php_fonct.php');
require ('bibli_requets_sql.php');
require ('setting.php');

$niveauDossier = 1;
$dossier = niveauDossier($niveauDossier);



firstHtml();

headPublique('Accueil', $dossier);

blocBandeau($dossier);



//-- Connexion base de donnée --------------------------------------
bdConnection();


/****************************************
* Liste requete SQL
* Elle se trouve dans bibli_requets_sql.php
***************************************
**/

$queryNbVisite = queryNbVisite();

$queryNoteArticle = queryNoteArticle();

$queryListBlog = queryListBlog();
/****************************************
* FIN --> Liste requete SQL
***************************************
**/



/****************************************
* Hit Parade Debut
***************************************
**/
echo "<!-- BLOC HIT PARADE -->
<div id='blcContenu'>

	<div id='blcHitParade'>
		<div id='blcTag'>
			<h3>Tags [+]</h3>
			<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		</div>";


/****************************************
* Les Trois blog les plus visiter
***************************************
**/

echo "
<table>
	<tr>
		<td style='padding: 0' colspan='2'>
		<h3>Les 3 blogs les plus visités</h3>
		</td>
	</tr>";


if ($resulta = mysqli_query($GLOBALS['bd'], $queryNbVisite)) {

	/* Récupère un tableau associatif */
	while ($enr = mysqli_fetch_assoc($resulta)) {
		htmlProteger($enr);

		$url = makeURL('article/articles_voir.php', $enr['blID'],0);

		echo '
		<tr>
			<td>
				<a href="',$url,'">',$enr['blTitre'],'</a>
			</td>
			<td>',$enr['Nbvisite'],'</td>
		</tr>';

	}
	/* Libération des résultats */
	mysqli_free_result($resulta);
}
else {
	bdErreurRequet($queryNbVisite);
}
echo "</table>";


/****************************************
* FIN --> Les Trois blog les plus visiter
****************************************
**/



/****************************************
* Les Trois Article les mieux Noté
***************************************
**/
if ($stmtNoteArticle = mysqli_query($GLOBALS['bd'], $queryNoteArticle)) {

	echo "
	<table>
		<tr>
			<td style='padding: 0' colspan='2'>
				<h3>Les 3 articles les mieux not�s</h3>
			</td>
		</tr>
		";

	// Lecture des valeurs
	while ($enr = mysqli_fetch_assoc($stmtNoteArticle)) {

		htmlProteger($enr);


		$url = makeURL('article/articles_voir.php', $enr['anIDArticle'],1);

		echo '
		<tr>
			<td>
				<a href="'.$url.'">'.$enr['arTitre'].'</a>
			</td>
			<td>
				<div class="classement">'.$enr['somNoteArticle'].'</div>
			</td>
		</tr>
		';
	}

	echo "</table>";

	/* Libération des résultats */
	mysqli_free_result($stmtNoteArticle);
}
else {
	bdErreurRequet($queryNoteArticle);
}


/****************************************
* FIN --> Les Trois Article les mieux Noté
****************************************
**/

echo "</div>
</div>
<!-- FIN BLOCS BLOG -->";
/****************************************
* FIN --> Hit Parade
***************************************
**/



/****************************************
* Liste des blog*
***************************************
**/

if ($stmtListBlog = mysqli_query($GLOBALS['bd'],$queryListBlog)){
	while ($enr = mysqli_fetch_assoc($stmtListBlog)) {
		$dateFormat = dateBlogToDate($enr['blDate']); // formater la date
		$url = makeURL('article/articles_voir.php', $enr['blID'],0);

		echo '
		<div id="blcContenu">

			<!-- BLOCS BLOG -->
			<div class="blcBlog">
				<h3>
					<span class="blogAuteur">'.$enr['blAuteur'].' - '.$dateFormat.'</span>
					'.$enr['blTitre'].'
				</h3>
				<p>'.$enr['blResume'].'</p>
				<p class="petit">
					<a class="blogLienArticle" href="'.$url.' '.$enr['blTitre'].'">
					'.$enr['blNbArticlesPage'].' articles
					</a>
					- ',$dateFormat,'   <!-- XXX TODO A Modifier avec la date du dernier article -->
				</p>
			</div>
			<!-- FIN BLOCS BLOG -->

		</div>';
	}
	mysqli_free_result($stmtListBlog);
}
else {
	bdErreurRequet($queryListBlog);
}
/*
* FIN --> Liste des blog
*
**/



/* Fermeture de la connexion */
mysqli_close($bd);

footerGlobal();

endHtml();



?>
