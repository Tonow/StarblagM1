<?php
//_____________________________________________________________________________
/**
 * V�rification du login
 *
 * On recoit les donn�es du formulaire se trouvant dans le bandeau des
 * pages publics (pseudo, mot de passe et bouton de soumission).
 *
 * Les boutons que l'on re�oit (soit btnNouveau, soit bntLogin) vont nous
 * permettre de savoir quel traitement effectuer.
 *
 * Dans le cas o� on re�oit btnNouveau, on initilise une session 'vide' et
 * on redirige sur la page de mise � jour d'un blog.
 *
 * Dans le cas o� on re�oit btnLogin, on v�rifie l'existence d'un blog
 * avec le pseudo et le mot de passe.
 * - Si le blog existe on initialise une session avec l'identifiant du blog
 * et on redirige sur la page de mise � jour d'un blog.
 * - Si le blog n'existe pas on affiche une page d'erreur.
 *
 * @param	string	$_POST['txtPseudo']		Pseudo de l'utilisateur
 * @param	string	$_POST['txtPasse']		Mot de passe de l'utilisateur
 * @param	string	$_POST['btnLogin']		Bouton si acc�s � un blog existant
 * @param	string	$_POST['btnNouveau']	Bouton si cr�ation d'un blog
 */
//_____________________________________________________________________________
ob_start();		// Buff�risation des sorties


require ('bibli_html_fonct.php');
require ('bibli_php_fonct.php');
require ('bibli_requets_sql.php');
require ('setting.php');

$niveauDossier = 1;
$dossier = niveauDossier($niveauDossier);

// Initialisation de la session
// Toutes les variables de session doivent �tre initialis�es ici
// pour que l'on sache quelles sont ces variables.
// Si l'initialisation n'est pas centralis�e, on se retrouve
// rapidement avec des variables d�clar�es un peu partout
// dans l'application, avec des difficult�s pour savoir � quoi elles servent.
// On peut aussi utiliser une fonction. L'important est de faire
// une intialisation de toutes les variables � un seul endroit

// Pour �viter une sorte de piratage par "vol de session" on d�marre
// une session, on la d�truit et on en d�marre une nouvelle.
session_start();
$_SESSION = array();	// Supprime toutes les variables de session.
session_destroy();    // Destruction de la session
session_start();

$_SESSION['IDBlog'] = 0;		// Identifiant du blog trait�
$_SESSION['IDArticle'] = 0;		// Identifiant de l'article trait�
$_SESSION['UploadFrom'] = '';	// permet � la page de t�l�chargement de savoir
								// quelle page l'appel�e et le traiement � faire
$_SESSION['UploadNum'] = 0;		// Compteur pour les t�l�chargements

// Cr�ation d'un nouveau blog : on redirige sur la page de mise � jour du blog
if (isset($_POST['btnNouveau'])) {
	header('Location: blog/blog_maj.php');
	exit();  // fin PHP
}
//_____________________________________________________________________________
//
// V�rification de l'existence d'un blog avec les �l�ments saisis
//_____________________________________________________________________________

bdConnection();	// Ouverture base de donn�es

$pseudo = fp_protectSQL($_POST['txtPseudo']);
$passe = md5($_POST['txtPasse']);

$sql = "SELECT *
		FROM blogs
		WHERE blPseudo = '$pseudo'
		AND blPasse = '$passe'";

$R = mysqli_query($GLOBALS['bd'], $sql) or fp_bdErreur($sql);  // Ex�cution requ�te

// Si le blog existe, on stocke l'identifiant dans une variable de session
// puis on redirige sur la page de d�finiation du blog.
if (mysqli_num_rows($R) == 1) {
	$enr = mysqli_fetch_assoc($R);
	$_SESSION['IDBlog'] = $enr['blID'];
	header('Location: blog_maj.php');
	exit();  // fin PHP
}

//_____________________________________________________________________________
//
// Affichage d'une page d'erreur
// Si on passe ici c'est que le blog n'existe pas.
// On affiche une page avec une message d'erreur.
// L'utilisateur peut se r�identifier ou revenir � l'acceuil.
//_____________________________________________________________________________
$remplace = array();
$remplace['@_TITLE_@'] = 'StarBlags - Login';
$remplace['@_RSS_@'] = '';
$remplace['@_REP_@'] = '..';

// Lecture du modele debut.html, remplacement motifs et affichage
fp_modeleTraite('debut_public', $remplace);

echo '<h1>Erreur d\'identification</h1>',
	'<div style="align: center; padding: 10px; height: 200px;">',
		'<p>',
			'Le pseudo et le mot de passe fourni ne correspondent pas � un blog.',
		'</p>',
		'<p>',
			'Merci de r�essayer avec les identifiants corrects.',
		'</p>',
	'</div>';

include('../modeles/fin.html');  // Fin de la page

ob_end_flush();  // Fermeture du buffer => envoi du contenu au navigateur
?>
