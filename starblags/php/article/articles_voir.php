<?php

ob_start();

require ('../bibli_html_fonct.php');
require ('../bibli_php_fonct.php');
require ('../bibli_requets_sql.php');
require ('../setting.php');

$niveauDossier = 2;
$dossier = niveauDossier($niveauDossier);
$MessageNoteNull = "Aucune Note";


$tmp = getURL();
$iMax = count($tmp);
if ($iMax < 2) {
	exit((IS_DEBUG) ? 'Erreur GET - '.__LINE__.' - '.basename(__FILE__): '');
}
$idBl = (int) $tmp[0];
$IDArticle = (int) $tmp[1];
$IDPage = ($iMax > 2) ? (int) $tmp[2] : 0;	// Paramètre facultatif
$aMJ = ($iMax > 3) ? (int) $tmp[3] : 0;	// Paramètre facultatif


$ip = fp_getIP();

firstHtml();

headPublique('Comment devenir Bill Gates en 12 jours', $dossier);

blocBandeau($dossier);


//-- Connexion base de donnée --------------------------------------
bdConnection();


/*
* Liste requete SQL
* Elle se trouve dans bibli_requets_sql.php
**/
$querySingleBlog = querySingleBlog($idBl);

$majBlogVisiteNow = majBlogVisiteNow($idBl , $ip);

$infoBlog = infoBlog($idBl);

/*
* FIN --> Liste requete SQL
**/

// Incrementation compteur blog
$Maj = mysqli_query($GLOBALS['bd'], $majBlogVisiteNow) or bdErreurRequet($majBlogVisiteNow);




// Recuperation information blog
$InfBlog = mysqli_query($GLOBALS['bd'], $infoBlog) or bdErreurRequet($infoBlog);  // Exécution requéte

$blogs = mysqli_fetch_assoc($InfBlog);	// Récupération de la sélection
if ($blogs === FALSE) {  // Le blog n'existe pas : redirection sur la page d'accueil
	header('Location: index.php');
	exit();
}
mysqli_free_result($InfBlog);


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
					<img src="../../upload/'.$idBl.'.'.$enr['blPhoto'].'" hspace="5" align="right">
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

// Requ�te SQL
$tri = ($blogs['blTri'] == 0) ? 'ASC' : 'DESC';
$posDebut = $IDPage * $blogs['blNbArticlesPage'];
$nbArticleParPage = $blogs['blNbArticlesPage'];

if ($IDArticle > 0) {
	$queryRecupArticle = queryRecupOneArticle($IDArticle); // XXX Ne fonctionne pas
}
else {
	$queryRecupArticle = queryRecupArticleFromBlog($idBl, $tri , $posDebut, $nbArticleParPage);
}




if ($ArticleFromBlog = mysqli_query($GLOBALS['bd'], $queryRecupArticle)) {
	echo "<div id='blcContenu'>";

	while ($enr = mysqli_fetch_assoc($ArticleFromBlog)) {
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
			<div class="blcLiens">';
			if ($enr['NbComments'] > 0) {
				// Les param�tres du lien sont crypt�s (IDArticle)
				$url = makeURL('commentaire_vu.php',$enr['arID']);
				$url = "javascript:FP.ouvrePopUp('$url')";

				$liensCommentaireVu = '<a href="'.$url.'" class="articleLienCom">'
				.$enr['NbComments']
				.( (fp_protectHTML($enr['NbComments']) == 1) ? ' commentaire</a>':' commentaires</a>');
				echo "$liensCommentaireVu";
			}
			else {
				echo '<a class="articleLienCom">'.$enr['NbComments'].' commentaires</a>';
			}

			// Lien pour la saisie d'un commentaire
			if ($enr['arComment'] == 1) {
				// Les param�tres du lien sont crypt�s (IDArticle)
				$url = makeURL('commentaire_ajout.php', $enr['arID']);
				$url = "javascript:FP.ouvrePopUp('$url')";

				$liensCommentaireAjout = '<a href="'.$url.'" class="articleLienComAjout">ajouter un commentaire</a>';
				echo "$liensCommentaireAjout";
			}

				echo'
				<a class="articleNote">'.((fp_protectHTML($enr['NoteMoyenne'])) === 'NULL' ? '' : $enr['NoteMoyenne']).'</a>';


				$urlNoterArticle = makeURL('article_noter.php', $enr['arID']);
				$urlNoterArticle = "javascript:FP.ouvrePopUp('$urlNoterArticle')";

				$liensNoteArticle = '<a href="'.$urlNoterArticle.'" class="articleLienNoteAjout">noter</a>';
				echo "$liensNoteArticle";


				echo'
			</div>
 		</div>
		<!-- FIN BLOC ARTICLE -->';
	}

	mysqli_free_result($ArticleFromBlog);
}
else {
	bdErreurRequet($queryRecupArticle);
}


$nbArticles = $blogs['NbArticles'];
$nbParPage = $blogs['blNbArticlesPage'];
$articleDebut = ($IDPage * $nbParPage) + 1;
$articleFin = ($IDPage * $nbParPage) + $nbParPage;
if ($articleFin > $nbArticles) {
	$articleFin = $nbArticles;
}

echo '

		<div id="blcPagination">
			Articles '.$articleDebut.' à '.$articleFin.' sur '.$nbArticles.'<br>';
			echo 'Page ';
			for ($i = 0, $page = 0; $i < $nbArticles; $i += $nbParPage, $page ++) {
				if ($page == $IDPage) {  // page en cours, pas de lien
					echo '<span id="pageEnCours">', $page + 1, '</span>';
				}
				else {
					// Les param�tres du lien sont crypt�s (IDBlog|IDArticle|No Page)
					$url = makeUrl('articles_voir.php', $idBl, 0, $page);
					echo '<a href="'.$url.'">', $page + 1, '</a>';
				}
			}
		echo '
		</div>	<!-- FIN BLOC PAGINATION -->

	</div>  <!-- FIN DU BLOC PAGE -->';


/* Fermeture de la connexion */
mysqli_close($bd);

ob_end_flush ();

footerGlobal();

endHtml();



?>
