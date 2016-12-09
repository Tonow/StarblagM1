<?php



/**
 * Permet de se connecter a la base de donné
 *
 * Le connecteur obtenu par la connexion est stocké dans une
 * variable global : $GLOBALS['bd']. Celà permet une réutilisation
 * facile de l'identifiant de connexion dans les fonctions.
 *
 * En cas d'erreur de connexion le script est arrêté.
 *
 * @return void connection Base de donné
 */
function bdConnection(){
  $bd = mysqli_connect(BD_SERVEUR, BD_USER, BD_PASS, BD_NAME);

  if ($bd !== false){
    $GLOBALS['bd'] = $bd;
    return;  // connexion ok
  }

  else {
    $msg = '<div> <h4>Ereur de la connection a la base de donnee</h4'
            .'BD_SERVEUR : '.BD_SERVEUR
            .'<br>BD_USER : '.BD_USER
            .'<br>BD_PASS : '.BD_PASS
            .'<br>BD_NAME : '.BD_NAME
            .'<br>Erreur MySQL numero :'.mysqli_connect_errno($bd)
            .'<br>'.mysqli_connect_error($bd)
            .'</div>';

    bdConnexionErreurExit($msg);
  }
}


/**
 * Arrêt du script si erreur base de données.
 * La fonction arrête le script, avec affichage de message d'erreur
 * si on est en phase de développement.
 *
 * @param string    $msg    Message affiché ou stocké.
 */

function bdConnexionErreurExit($msg){
  ob_end_clean(); // vidage du buffer

  //en phase de debug message complet et arret
  if (IS_DEBUG){
    echo "<!DOCTYPE html>
            <html>
              <head>
              <meta charset='ISO-8859-1'>
              <title>'Erreure base de donnee</title>
              </head>
                <body>'
                $msg,
                </body>
            </html>";
    exit();
  }
  //en production stockage des donner dans un fichier d'erreur + message utilisateur
  else {
    $buffer = date('d/m/Y H:i:s'). "\n$msg\n";
    error_log($buffer, 3 , 'erreurs_bd.txt');

    echo "<DOCTYPE html>
          <html>
            <head>
              <meta charset='ISO-8859-1'>
              <title>'Strablags'</title>
            </head>
            <body>
              <h1>Starblag est trop solicité</h1>
              <h3>Merci de re-essayer plus tard</h3>
            </body>
          </html>";

    exit();
  }
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
