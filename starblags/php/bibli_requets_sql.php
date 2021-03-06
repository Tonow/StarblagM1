<?php


function queryListBlog(){
  $queryListBlog = "SELECT blID , blTitre, blAuteur, blDate , blResume , blNbArticlesPage
  									FROM blogs
  									ORDER BY blTitre";
  return $queryListBlog;
}

function querySingleBlog($id){
  //echo "l'id dans la query  est = $id<br>";
  $querySingleBlog = "SELECT blTitre, blResume, blAuteur  , COUNT(bvIDBlog) AS Nbvisite , blNbArticlesPage ,blPhoto ,blDate
                      FROM blogs , blogs_visites
                      WHERE blID = bvIDBlog AND blID = $id ";
  return $querySingleBlog;
}


function queryNbVisite(){
  $queryNbVisite = "SELECT COUNT(bvIDBlog) AS Nbvisite, blID, blTitre
  							FROM blogs_visites , blogs
  							WHERE blID = bvIDBlog
  							GROUP BY blID
  							ORDER BY 'Nbvisite'  DESC
                LIMIT 3";
  return $queryNbVisite;
}


function queryNoteArticle(){
  $queryNoteArticle = "SELECT anIDArticle, SUM(anNote) AS somNoteArticle, arTitre , arIDBlog
  										FROM articles_notes, articles
  										WHERE arID = anIDArticle
  										GROUP BY anIDArticle
  										ORDER BY somNoteArticle  DESC
                      LIMIT 3";
  return $queryNoteArticle;
}


function queryRecupArticleFromBlog($idBlog , $tri=ASC , $posDebut , $nb){
  $queryRecupAllArticleFromBlog = "SELECT articles.* ,count(coID) AS NbComments , photos.* , ROUND(AVG(articles_notes.anNote)) AS NoteMoyenne
                            			FROM articles
                            			LEFT OUTER JOIN commentaires ON commentaires.coIDArticle = articles.arID
                                  JOIN photos ON articles.arID = photos.phIDArticle
                                  LEFT OUTER JOIN articles_notes ON articles_notes.anID = articles.arID
                            			WHERE arIDBlog = $idBlog
                            			AND arPublier = 1
                            			GROUP BY 1
                            			ORDER BY arDate $tri, arHeure $tri
                            			LIMIT $posDebut, $nb";
  return $queryRecupAllArticleFromBlog;
}

function queryNomArticle($IDArticle){
  $sql = "SELECT arTitre
          FROM articles
          WHERE arID = $IDArticle";
  return $sql;
}

function queryCommentaireArticle($IDArticle){
  $sql = "SELECT *
		      FROM commentaires
		      WHERE coIDArticle = $IDArticle
		      ORDER BY coDate, coHeure";
  return $sql;
}


function queryRecupOneArticle($IDArticle){
  $sql = "SELECT *
			FROM articles , photos
			WHERE  arID = $IDArticle
        AND phIDArticle = arID
			  AND arPublier = 1
			GROUP BY 1";
  return $sql;
}



// On met � jour le compteur de visites du blog
function majBlogVisiteNow($idBlog , $ip){
  $sql = "INSERT INTO blogs_visites SET
  		bvIDBlog = $idBlog,
  		bvDate = ".date('Ymd').",
  		bvHeure = '".date('H:i:s')."',
  		bvIP = '".$ip."'";
  return $sql;
}


// R�cup�ration des infos sur le blog affich�
function infoBlog($idBlog){
  $sql = "SELECT blogs.*, count( arID ) AS NbArticles, max( arDate ) AS Dernier
  		FROM blogs, articles
  		WHERE blID = $idBlog
  		AND arIDBlog = blID
  		AND arPublier = 1
  		GROUP BY 1";
  return $sql;
}


//_____________________________________________________________________________
/**
 * Mise � jour de la base de donn�es
 *
 * @param	integer	$IDArticle	Cl� de l'article � traiter
 * @global	array	$_POST		Les zones de saisie du formulaire
 */
function fpl_majBaseCommentaire($IDArticle , $Auteur , $Texte) {
	$sql = "INSERT INTO commentaires SET
			coIDArticle = '$IDArticle',
			coAuteur = '$Auteur',
			coTexte = '$Texte',
			coDate = ".date('Ymd').",
			coHeure = '".date('H:i')."'";
	return $sql;
}


//_____________________________________________________________________________
/**
 * Mise � jour de la base de donn�es
 *
 * @param	integer	$IDArticle	Cl� de l'article � traiter
 * @global	array	$_POST		Les zones de saisie du formulaire
 */
function fpl_majNoteArticle($IDArticle , $Auteur , $Note , $ip ) {
	$sql = "INSERT INTO articles_notes SET
			anIDArticle = $IDArticle,
			anDate = ".date('Ymd').",
			anHeure = '".date('H:i')."',
			anIP = '".$ip."',
			anNom = '$Auteur',
			anNote = {$Note}";
	return $sql;
}


 ?>
