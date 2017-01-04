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


/* Fermeture de la connexion */
mysqli_close($bd);


echo <<<ARTICLE1
	<div id="blcContenu">

		<!-- BLOC ARTICLE -->
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
 		<div class="blcArticle">
 			<h2>
 				<span class="articleDate">07/08/2006 - 16:10</span>
				Le premier jour
 			</h2>
 			<!--  BLOC PHOTO HAUT -->
			<div class="articlePhotoH">
				<div class="articlePhoto">
					<img src="../../upload/1_1.gif">
					<br>L&eacute;gende
				</div>
			</div>
			<!-- TABLE PHOTO GAUCHE / TEXTE / PHOTO DROITE -->
			<table>
				<tr>
					<td>
						<div class="articlePhoto">
							<img src="../../upload/1_1.gif">
							<br>L&eacute;gende
						</div>
					</td>
					<td valign="top">
						<p>Je travaille dans l'informatique depuis <strong>1983</strong>. </p>
						<p>Jusqu'en <strong>1993</strong>, j'ai &eacute;t&eacute; <strong>chef
						de projets</strong> dans une <strong>SSII</strong> : <br>
						- <strong>analyse</strong> et r&eacute;daction des <strong>dossiers de
						d&eacute;veloppement</strong> et de sp&eacute;cifications techniques
						&agrave; destination des clients et des autres d&eacute;veloppeurs de
						l&rsquo;&eacute;quipe, <br>
						- <strong>d&eacute;veloppement d&rsquo;applications</strong> commerciales
						en Basic, Cobol, C, L4G divers, bases de donn&eacute;es relationnelles
						(Oracle, Informix), langages SQL, pour des PME-PMI, <br>
						- <strong>installation </strong>du mat&eacute;riel chez les clients, <br>
						- <strong>formation</strong> aux logiciels d&eacute;velopp&eacute;s
						</p>
					</td>
					<td>
						<div class="articlePhoto">
							<img src="../../upload/1_1.gif">
							<br>L&eacute;gende
						</div>
					</td>
				</tr>
			</table>
			<!-- BLOC PHOTO BAS -->
			<div class="articlePhotoH">
				<div class="articlePhoto">
					<img src="../../upload/1_1.gif">
					<br>L&eacute;gende
				</div>
			</div>
			<!-- BLOC LIENS -->
			<div class="blcLiens">
				<a href="comment_voir.php" class="articleLienCom">2 commentaires</a>
				<a href="comment_ajout.php" class="articleLienComAjout">ajouter un commentaire</a>
				<a class="articleNote">10</a>
				<a href="article_noter.php" class="articleLienNoteAjout">noter</a>
			</div>
 		</div>
		<!-- FIN BLOC ARTICLE -->

		<div id="blcPagination">
			Articles 1 � 2 sur 6<br>
			Page <span id="pageEnCours">1</span><a href="articles_voir.php">2</a>
			<a href="articles_voir.php">3</a>
		</div>	<!-- FIN BLOC PAGINATION -->

	</div>  <!-- FIN DU BLOC PAGE -->
ARTICLE1;

footerGlobal();

endHtml();



?>
