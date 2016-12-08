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
  $queryNbVisite = "SELECT blogs_visites.bvIDBlog, COUNT(blogs_visites.bvIDBlog) AS Nbvisite, blogs.blID, blogs.blTitre
  							FROM blogs_visites
  							JOIN blogs ON blogs.blID = blogs_visites.bvIDBlog
  							GROUP BY blogs_visites.bvIDBlog
  							ORDER BY `Nbvisite`  DESC";
  return $queryNbVisite;
}


function queryNoteArticle(){
  $queryNoteArticle = "SELECT articles_notes.anIDArticle, SUM(articles_notes.anNote) AS somNoteArticle, articles.arTitre
  										FROM articles_notes
  										JOIN articles ON articles.arID = articles_notes.anIDArticle
  										GROUP BY articles_notes.anIDArticle
  										ORDER BY somNoteArticle  DESC";
  return $queryNoteArticle;
}


 ?>
