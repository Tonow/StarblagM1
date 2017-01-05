<?php


/////////////////////////////////////////
/////////////////////////////////////////
//                  BDD                //
/////////////////////////////////////////
/////////////////////////////////////////

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



//___________________________________________________________________
/**
 * Gestion d'une erreur de requ�te � la base de donn�es.
 *
 * @param string	$sql	requ�te SQL provoquant l'erreur
 */
function bdErreurRequet($sql) {
	$errNum = mysqli_errno($GLOBALS['bd']);
	$errTxt = mysqli_error($GLOBALS['bd']);

	// Collecte des informations facilitant le debugage
	$msg = '<h4>Erreur de requ&ecirc;te</h4>'
			."<pre><b>Erreur mysql :</b> $errNum"
			."<br> $errTxt"
			."<br><br><b>Requ&ecirc;te :</b><br> $sql"
			.'<br><br><b>Pile des appels de fonction</b>';

	// R�cup�ration de la pile des appels de fonction
	$msg .= '<table border="1" cellspacing="0" cellpadding="2">'
			.'<tr><td>Fonction</td><td>Appel&eacute;e ligne</td>'
			.'<td>Fichier</td></tr>';

	// http://www.php.net/manual/fr/function.debug-backtrace.php
	$appels = debug_backtrace();
	for ($i = 0, $iMax = count($appels); $i < $iMax; $i++) {
		$msg .= '<tr align="center"><td>'
				.$appels[$i]['function'].'</td><td>'
				.$appels[$i]['line'].'</td><td>'
				.$appels[$i]['file'].'</td></tr>';
	}

	$msg .= '</table></pre>';

	fp_bdErreurExit($msg);
}



//___________________________________________________________________
/**
 * Arr�t du script si erreur base de donn�es.
 * La fonction arr�te le script, avec affichage de message d'erreur
 * si on est en phase de d�veloppement.
 *
 * @param string    $msg    Message affich� ou stock�.
 */
function fp_bdErreurExit($msg) {
	ob_end_clean();     // Supression de tout ce qui a pu �tre d�ja g�n�r�

	// Si on est en phase de d�bugage, on affiche le message d'erreur
	// et on arr�te le script.
	if (IS_DEBUG) {
		echo '<!DOCTYPE html><html><head><meta charset="ISO-8859-1"><title>',
			'Erreur base de donn�es</title></head><body>',
			$msg,
			'</body></html>';
		exit();				// Sortie : fin du script
	}

	// Si on est en phase de production on stocke les
	// informations de d�buggage dans un fichier d'erreurs
	// et on affiche un message sibyllin.
	$buffer = date('d/m/Y H:i:s')."\n$msg\n";
	error_log($buffer, 3, 'erreurs_bd.txt');

	// Dans un vrai site, il faudrait faire une page avec
	// la ligne graphique du site. Pas fait ici pour simplifier.
	echo '<!DOCTYPE html><html><head><meta charset="ISO-8859-1"><title>',
			'Starblags</title></head><body>',
			'<h1>Stablags est overbook&eacute;</h1>,
			<h3>Merci de r&eacute;essayez dans un moment</h3>',
			'</body></html>';
	exit();				// Sortie : fin du script
}




/**
 * Protection HTML des chaînes contenues dans un tableau
 * Le tableau est passé par référence.
 *
 * @param array     $tab    Tableau des chaînes à protéger
 */
function htmlProteger(&$tab) {
  //echo "entre htmlProteger";
    foreach ($tab as $cle => $val) {
        $tab[$cle] = htmlentities($val, ENT_COMPAT, 'ISO-8859-1');
        //echo "corps htmlProteger";
    }
}


/**
 * Protection d'une cha�ne de caract�res pour un affichage HTML
 *
 * @param	string	$texte	Texte � prot�ger
 * @param	boolean	$bR		TRUE si remplacement des saut de ligne par le tag <br>
 *
 * @return	string	Code HTML g�n�r�
 */
function fp_protectHTML($texte, $bR = FALSE) {
	return ($bR) ? nl2br(htmlentities($texte, ENT_COMPAT, 'ISO-8859-1'))
				: htmlentities($texte, ENT_COMPAT, 'ISO-8859-1');
}


/////////////////////////////////////////
//                  FIN                //
//                  BDD                //
/////////////////////////////////////////
/////////////////////////////////////////






/////////////////////////////////////////
/////////////////////////////////////////
//                  URL                //
/////////////////////////////////////////
/////////////////////////////////////////

//_____________________________________________________________________________
/**
 * Cryptage / decryptage d'une cha�ne avec l'algorithme RC4
 *
 * @param	string	$texte	Donn�es � crypter
 * @param	string	$cle	Cl� de cryptage
 *
 * @return string	Donn�es crypt�es ou d�crypt�es
 */
 function doRC4($texte, $cle) {
    $cles = array();	// tableau initialis� avec les octets de la cl�
    $etats = array();	// table d'�tats : flux appliqu� sur le texte clair
    $tmp = '';
    $cleLong = strlen($cle);
	$texteLong = strlen($texte);
	$RC4 = '';

	// Premi�re �tape : cr�ation de 2 tableaux de 256 octets en fonction de la cl�
	// Le tableau $cles est initialis� avec les octets de la cl�
	// Le tableau $etats est initialis� avec les nombres de 0 � 255 permut�s
	// pseudo-al�atoirement selon le tableau K.
    for ($i = 0; $i <= 255; $i++) {
        $cles[$i] = ord(substr($cle, ($i % $cleLong), 1));
        $etats[$i] = $i;
    }

    for ($i = $x = 0; $i <= 255; $i++) {
        $x = ($x + $etats[$i] + $cles[$i]) % 256;
        $tmp = $etats[$i];
        $etats[$i] = $etats[$x];
        $etats[$x] = $tmp;
    }

    // Deuxi�me �tape : permutations pour le chiffrement/d�chiffrement.
    // Toutes les additions sont ex�cut�es modulo 256.
	// Le tableau $etats change � chaque it�ration en ayant deux �l�ments permut�s.
    for ($a = $i = $j = 0, $k = ''; $i < $texteLong; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $etats[$a]) % 256;
        $tmp = $etats[$a];
        $etats[$a] = $etats[$j];
        $etats[$j] = $tmp;
        $k = $etats[(($etats[$a] + $etats[$j]) % 256)];
        $tmp = ord(substr($texte, $i, 1)) ^ $k;
        $RC4 .= chr($tmp);
    }

    return $RC4;
}


//_____________________________________________________________________________
/***
* Composition d'une URL avec cryptage des param�tres
*
* Les param�tres de l'URL sont mis les uns � la suite des autres, s�par�s par
* le caract�re | (pipe). On ajoute en d�but de la cha�ne des param�tres la
* signature de cryptage. La cha�ne est ensuite prot�g�e pour les caract�res
* sp�ciaux d'URL. Elle est ajout�e � l'URL avec comme nom x. On obtient ainsi
* par exemple : mapage.php?x=HKVSkS6t
*
* @param	string 	$url		D�but de l'url (ex : mapage.php)
* @param	mixed 	$x		Param�tres de l'url. Ils sont d'un nombre ind�termin�
* @global	string	RC4_SIGNE	Signature de cryptage
* @global	string	RC4_CLE		Cle de cryptage
*
* @return string	URL crypt�e
*/
function makeURL($url, $x) {
	$params = RC4_SIGNE;
	$args = func_get_args();
	for($i = 1, $iMax = count($args); $i < $iMax; $i ++) {
		$params .= '|'.$args[$i];
	}
	$params = doRC4($params, RC4_CLE);

	return $url.'?x='.rawurlencode(base64_encode($params));

}


//_____________________________________________________________________________
/**
 * D�cryptage d'un param�tre GET et renvoi des valeurs contenues
 *
 * Cette fonction est en quelque sorte l'inverse de de fp_makeURL.
 * Elle r�cup�re la vairable $_GET['x'], la d�crypte, v�rifie la signature
 * puis renvoie les diff�rentes valeurs trouv�es sous la forme d'un tableau.
 * Le script est arr�t� si
 * - le param�tre x est absent
 * - la signature n'est pas bonne
 * - il n'y a pas plus de une valeur
 *
 * @global	array	$_GET['x']	Param�tre de la page
 *
 * @return	mixed	Si plusieurs valeurs renvoie un tableau, sinon un scalaire
 */
function getURL() {
	if (!isset($_GET['x'])) {
		exit((IS_DEBUG) ? 'Erreur GET - '.__LINE__ : '');
	}

	$params = rawurldecode(base64_decode($_GET['x']));
	$params = doRC4($params, RC4_CLE);
	$params = explode('|', $params);

	if (count($params) < 2) {
		exit((IS_DEBUG) ? 'Erreur GET - '.__LINE__ : '');
	}
	if ($params[0] != RC4_SIGNE) {
		exit((IS_DEBUG) ? 'Erreur GET - '.__LINE__ : '');
	}

	array_shift($params);

	// Si plusieurs valeurs on renvoie un tableau avec les valeurs
	if (count($params) > 1) {
		return $params;
	}
	// Si une seule valeur on renvoie cette valeur uniquement
	return $params[0];
}


/////////////////////////////////////////
//                  FIN                //
//                  URL                //
/////////////////////////////////////////
/////////////////////////////////////////




/////////////////////////////////////////
/////////////////////////////////////////
//                DIVERS               //
/////////////////////////////////////////
/////////////////////////////////////////



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

/**
 * R�cup�ration de l'adresse IP du visiteur
 *
 * @return	string	Adresse Ip du visiteur ou '' si impossible � d�terminer
 */
function fp_getIP() {
    $iP = '';
    $proxys = array('HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
                    'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED',
                    'HTTP_VIA', 'HTTP_X_COMING_FROM',
                    'HTTP_COMING_FROM', 'REMOTE_ADDR');

    foreach($proxys as $prox) {
        if (isset($_SERVER[$prox])) {
            $iP = $_SERVER[$prox];
            break;
        }
    }

    $ok = preg_match('/^[0-9]{1,3}(.[0-9]{1,3}){3,3}/', $iP, $exps = array());

    if($ok && (count($exps) > 0)) {
    	return $exps[0];
    }

    return '';
}



/////////////////////////////////////////
//                  FIN                //
//                 DIVERS              //
/////////////////////////////////////////
/////////////////////////////////////////


?>
