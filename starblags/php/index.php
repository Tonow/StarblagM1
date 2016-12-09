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


/*
* Liste requete SQL
* Elle se trouve dans bibli_requets_sql.php
**/
$queryListBlog = queryListBlog();

$queryNbVisite = queryNbVisite();

$queryNoteArticle = queryNoteArticle();
/*
* FIN --> Liste requete SQL
**/



/*
* Hit Parade Debut
**/
echo "<!-- BLOC HIT PARADE -->
<div id='blcContenu'>

<div id='blcHitParade'>
	<div id='blcTag'>
		<h3>Tags [+]</h3>
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	</div>";


/*
* Les Trois blog les plus visiter
**/
if ($stmtNbVisite = mysqli_prepare($bd, $queryNbVisite)) {

    //Exécution de la requête
    mysqli_stmt_execute($stmtNbVisite);

    //Association des variables de résultat
    mysqli_stmt_bind_result($stmtNbVisite, $bvIDBlog, $nbVisite, $blID, $blTitre);

		echo "
		<table>
			<tr>
				<td style='padding: 0' colspan='2'>
					<h3>Les 3 blogs les plus visit�s</h3>
				</td>
			</tr>";


		$contPlusVisit = 0;
    // Lecture des valeurs
    while (mysqli_stmt_fetch($stmtNbVisite) && $contPlusVisit<3) {

				echo "
				<tr>
					<td>
						<a href='article/articles_voir.php'>$blTitre</a>
					</td>
					<td>$nbVisite</td>
				</tr>";
				$contPlusVisit++;
			}

			echo "</table>";

			//Fermeture de la commande
			mysqli_stmt_close($stmtNbVisite);
		}
/*
* FIN --> Les Trois blog les plus visiter
*
**/



/*
* Les Trois Article les mieux Noté
**/
if ($stmtNoteArticle = mysqli_prepare($bd, $queryNoteArticle)) {

    //Exécution de la requête
    mysqli_stmt_execute($stmtNoteArticle);

    //Association des variables de résultat
    mysqli_stmt_bind_result($stmtNoteArticle, $anIDArticle, $somNoteArticle, $arTitre);

		echo "
		<table>
			<tr>
		<td style='padding: 0' colspan='2'>
			<h3>Les 3 articles les mieux not�s</h3>
		</td>
	</tr>
		";



		$contMieuxNote = 0;
    // Lecture des valeurs
    while (mysqli_stmt_fetch($stmtNoteArticle) && $contMieuxNote<3) {

				echo "
				<tr>
					<td>
						<a href='article/articles_voir.php'>$arTitre</a>
					</td>
					<td>
						<div class='classement'>$somNoteArticle</div>
					</td>
				</tr>
				";
				$contMieuxNote++;
			}

			echo "</table>";

			//Fermeture de la commande
			mysqli_stmt_close($stmtNoteArticle);
		}
/*
* FIN --> Les Trois Article les mieux Noté
*
**/

echo "</div>
</div>
		<!-- FIN BLOCS BLOG -->";
/*
* FIN --> Hit Parade
**/



/*
* Liste des blog
**/
if ($stmtListBlog = mysqli_prepare($bd, $queryListBlog)) {

    /* Exécution de la requête */
    mysqli_stmt_execute($stmtListBlog);

    /* Association des variables de résultat */
    mysqli_stmt_bind_result($stmtListBlog, $idBlog , $titre, $auteur, $date , $resume , $nb_articles_page);


    /* Lecture des valeurs */
    while (mysqli_stmt_fetch($stmtListBlog)) {

				$dateFormat = dateBlogToDate($date); // formate la date

				echo "
				<div id='blcContenu'>

				<!-- BLOCS BLOG -->
				<div class='blcBlog'>
					<h3>
						<span class='blogAuteur'>$auteur - $dateFormat</span>
						$titre
					</h3>
					<p>$resume</p>
					<p class='petit'>
						<a class='blogLienArticle' href='article/articles_voir.php?id=$idBlog' title='$titre'>
			        	$nb_articles_page articles
			        	</a>
			        	- $dateFormat   <!-- XXX TODO A Modifier avec la date du dernier article -->
			        </p>
				</div>
				<!-- FIN BLOCS BLOG -->

				</div>
				";
    }



    /* Fermeture de la commande */
    mysqli_stmt_close($stmtListBlog);
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
