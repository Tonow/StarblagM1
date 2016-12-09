<?php

/**
 * Permet de se connecter a la base de donné
 *
 *
 * @return void connection Base de donné
 */
function bdConnection(){
  $bd = mysqli_connect(BD_SERVEUR, BD_USER, BD_PASS, BD_NAME);
}


/**
 * Donne en fonction du niveau dans le quelle se trouve le fichier l'ecriture du chemin qui permet de le retrouver
 * dans la hierachie de dossiers
 *
 * @param int $niveauDossier donne quelle est le niveau du fichier dans la hierachei des dossiers
 *
 * @return string $signeNiveau est la chaine qui caracterise la profondeur du dossier en fonction du nb de repetition de ../
 */
function niveauDossier($niveauDossier){
  $signeNiveau = str_repeat("../", $niveauDossier);
  $signeNiveau = substr($signeNiveau, 0, -1);;

  return $signeNiveau;
}

/**
 * Transforme la date formater par la base de donné AAAAMMJJ en format pour le site JJ/MM/AAAA
 *
 * @param string $dateBlog date recupere de la base de donnée : AAAAMMJJ
 *
 * @return string $date la date formaté pour le site : JJ/MM/AAAA
 */
function dateBlogToDate($dateBlog){
  $annee = substr($dateBlog, 0, 4);
  $mois = substr($dateBlog, 4, 2);
  $jour = substr($dateBlog, 6, 2);
//echo "$dateBlog";

  $date = "$jour/$mois/$annee";

  return $date;
}


?>
