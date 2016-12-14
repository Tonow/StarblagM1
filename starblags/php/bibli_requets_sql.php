<?php

function queryListBlog(){
  $queryListBlog = "SELECT blID , blTitre, blAuteur, blDate , blResume , blNbArticlesPage
  									FROM blogs
  									ORDER BY blTitre";
  return $queryListBlog;
}

function querySingleBlog($id){
  //echo "l'id dans la query  est = $id<br>";
  $querySingleBlog = "SELECT blogs.blTitre, blogs.blResume, blogs.blAuteur  , COUNT(blogs_visites.bvIDBlog) , blogs.blNbArticlesPage ,blogs.blPhoto ,blogs.blDate
                      FROM blogs
                      JOIN blogs_visites ON blogs.blID = blogs_visites.bvIDBlog
                      WHERE blogs.blID = $id";
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
  $queryNoteArticle = "SELECT articles_notes.anIDArticle, SUM(articles_notes.anNote) AS somNoteArticle, articles.arTitre , articles.arIDBlog
  										FROM articles_notes
  										JOIN articles ON articles.arID = articles_notes.anIDArticle
  										GROUP BY articles_notes.anIDArticle
  										ORDER BY somNoteArticle  DESC";
  return $queryNoteArticle;
}


 ?>
