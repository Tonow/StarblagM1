<?php

ob_start();

require ('../bibli_html_fonct.php');
require ('../bibli_php_fonct.php');
require ('../bibli_requets_sql.php');
require ('../setting.php');

$niveauDossier = 2;
$dossier = niveauDossier($niveauDossier);


$tmp = getURL();
$iMax = count($tmp);
if ($iMax < 2) {
	exit((IS_DEBUG) ? 'Erreur GET - '.__LINE__.' - '.basename(__FILE__): '');
}
$id = (int) $tmp[0];
$IDArticle = (int) $tmp[1];
$IDPage = ($iMax > 2) ? (int) $tmp[2] : 0;	// Paramètre facultatif
$aMJ = ($iMax > 3) ? (int) $tmp[3] : 0;	// Paramètre facultatif


//$id = $_GET["id"]; // TODO XXX probleme id si on l'utilise avec 3 blog les plus visité et 3 article les mieux noté
//$id = (int)$id;



firstHtml();

headPublique('Comment devenir Bill Gates en 12 jours', $dossier);

blocBandeau($dossier);


//-- Connexion base de donnée --------------------------------------
bdConnection();


/*
* Liste requete SQL
* Elle se trouve dans bibli_requets_sql.php
**/
$querySingleBlog = querySingleBlog($id);

$queryRecupAllArticleFromBlog = queryRecupAllArticleFromBlog($id);

//echo "l'id apres la query  est = $id <br>";
/*
* FIN --> Liste requete SQL
**/


/*
* Presentation blog
**/
if ($stmtPresenteBlog = mysqli_query($GLOBALS['bd'], $querySingleBlog)) {

	while ($enr = mysqli_fetch_assoc($stmtPresenteBlog)) {
		$dateFormat = dateBlogToDate(fp_protectHTML($enr['blDate'])); // formater la date



			echo '
			<div id="blcContenu">
				<!-- BLOC DESCRIPTION BLOG -->
				<div class="blcBlog">
					<h1>'.fp_protectHTML($enr['blTitre']).'</h1>
					<img src="../../upload/'.$id.'.'.$enr['blPhoto'].'" hspace="5" align="right">
					<ul>
						<li style="margin-bottom: 12px;">'.fp_protectHTML($enr['blResume']).'</li>
						<li> Auteur : '.fp_protectHTML($enr['blAuteur']).'</li>
						<li>Nombre de visites : '.fp_protectHTML($enr['Nbvisite']).' depuis le '.$dateFormat.'</li>
						<li>Nombre d articles : '.fp_protectHTML($enr['blNbArticlesPage']).' (derniére publication le 12/09/2010)</li>
					</ul>
					<div class="blcLiens">
					 	<a href="php/mail.php" class="blogLienMail">M envoyer un mail à chaque nouvel article</a>
					 	<a href="php/flux.php" class="blogLienFlux">M abonner au flux</a>
					</div>
				</div>
				</div>';

	}
	mysqli_free_result($stmtPresenteBlog);
}
else {
	bdErreurRequet($querySingleBlog);
}
/*
* FIN --> Presentation blog
*
**/



/*
<!--
 * Affichage du texte d'un article et des images li�es.
 * Si il n'y a pas d'images li�es, le texte est simplement
 * affich� � la suite de l'ent�te.
 * Si il y a des images li�es :
 * - on utilise un bloc pour les images du haut
 * - on utilise un bloc pour les images du bas
 * - pour les images de gauche, de droite et pour le texte
 * on utilise un tableau. C'est le plus simple pour �viter
 * des "bidouilles" pour l'alignement vertical des images.
 *
 *	 ____________________________________________________
 *  | bloc ent�te                                        |
 *  |____________________________________________________|
 *  | bloc image haut (si n�cessaire)                    |
 *  |____________________________________________________|
 *   ____________________________________________________
 *  | cellule |  texte                         | cellule |
 *  | images  |                                | images  |
 *  | gauche  |                                | droite  |
 *  | ________|________________________________|_________|
 *   ____________________________________________________
 *  | bloc image bas (si n�cessaire)                     |
 *  |____________________________________________________|
 *   ____________________________________________________
 *  | bloc liens commentaire, note, etc.                 |
 *  |____________________________________________________|
 *
 *
 -->
*/

if ($AllArticleFromBlog = mysqli_query($GLOBALS['bd'], $queryRecupAllArticleFromBlog)) {
	echo "<div id='blcContenu'>";

	while ($enr = mysqli_fetch_assoc($AllArticleFromBlog)) {
		$dateFormat = dateBlogToDate(fp_protectHTML($enr['arDate'])); // formater la date

		echo '
		<!-- BLOC ARTICLE -->

 		<div class="blcArticle">
 			<h2>
 				<span class="articleDate">'.$dateFormat.' - '.$enr['arHeure'].'</span>
				'.fp_protectHTML($enr['arTitre']).'
 			</h2>';

			if ($enr['phPlace'] == 0 ) {

				echo '
				<!--  BLOC PHOTO HAUT -->
				<div class="articlePhotoH">
					<div class="articlePhoto">
						<img src="../../upload/'.$enr['phIDArticle'].'_'.$enr['phNumero'].'.'.$enr['phExt'].'">
						<br>'.fp_protectHTML($enr['phLegende']).'
					</div>
				</div>';
			}

 			echo "
			<!-- TABLE PHOTO GAUCHE / TEXTE / PHOTO DROITE -->
			<table>
				<tr>";

					if ($enr['phPlace'] == 1 ) {

						echo '
						<td>
							<div class="articlePhoto">
								<img src="../../upload/'.$enr['phIDArticle'].'_'.$enr['phNumero'].'.'.$enr['phExt'].'">
								<br>'.fp_protectHTML($enr['phLegende']).'
							</div>
						</td>';
					}

					echo '
					<td valign="top">
						'.$enr['arTexte'].'
					</td>';


					if ($enr['phPlace'] == 3 ) {

						echo '
						<td>
							<div class="articlePhoto">
								<img src="../../upload/'.$enr['phIDArticle'].'_'.$enr['phNumero'].'.'.$enr['phExt'].'">
								<br>'.fp_protectHTML($enr['phLegende']).'
							</div>
						</td>';
					}

				echo "
				</tr>
			</table>";


			if ($enr['phPlace'] == 2 ) {

				echo '
				<!-- BLOC PHOTO BAS -->
				<div class="articlePhotoH">
					<div class="articlePhoto">
						<img src="../../upload/'.$enr['phIDArticle'].'_'.$enr['phNumero'].'.'.$enr['phExt'].'">
						<br>'.fp_protectHTML($enr['phLegende']).'
					</div>
				</div>';
			}

			echo '
			<!-- BLOC LIENS -->
			<div class="blcLiens">
				<a href="comment_voir.php" class="articleLienCom">'.$enr['arComment'].' commentaires</a>
				<a href="comment_ajout.php" class="articleLienComAjout">ajouter un commentaire</a>
				<a class="articleNote">10</a>
				<a href="article_noter.php" class="articleLienNoteAjout">noter</a>
			</div>
 		</div>
		<!-- FIN BLOC ARTICLE -->';
	}
}




echo '

		<div id="blcPagination">
			Articles 1 à 2 sur 6<br>
			Page <span id="pageEnCours">1</span><a href="articles_voir.php">2</a>
			<a href="articles_voir.php">3</a>
		</div>	<!-- FIN BLOC PAGINATION -->

	</div>  <!-- FIN DU BLOC PAGE -->';


/* Fermeture de la connexion */
mysqli_close($bd);

footerGlobal();

endHtml();



?>
