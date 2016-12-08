<?php

function niveauDossier($niveauDossier){
  $signeNiveau = str_repeat("../", $niveauDossier);
  $signeNiveau = substr($signeNiveau, 0, -1);;

  return $signeNiveau;
}

function dateBlogToDate($dateBlog){
  $annee = substr($dateBlog, 0, 4);
  $mois = substr($dateBlog, 4, 2);
  $jour = substr($dateBlog, 6, 2);
//echo "$dateBlog";

  $date = "$jour/$mois/$annee";

  return $date;
}


?>
