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


function queryRecupAllArticleFromBlog($idBlog){
  $queryRecupAllArticleFromBlog = "SELECT *
                                  FROM articles , photos
                                  WHERE arIDBlog = $idBlog AND phIDArticle = arID
                                  ORDER BY arID ASC";
  return $queryRecupAllArticleFromBlog;
}

 ?>
