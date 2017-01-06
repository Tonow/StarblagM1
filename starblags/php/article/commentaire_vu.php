<?php

ob_start();

require ('../bibli_html_fonct.php');
require ('../bibli_php_fonct.php');
require ('../bibli_requets_sql.php');
require ('../setting.php');

$niveauDossier = 2;
$dossier = niveauDossier($niveauDossier);


$IDArticle = (int) getURL();	// R�cup�ration des param�tres URL

//-- Connexion base de donnée --------------------------------------
bdConnection();

//Requet SQL
$queryNomArticle = queryNomArticle($IDArticle);
$queryCommentaireArticle = queryCommentaireArticle($IDArticle);
//Fin Requet SQL

// Sous Titre de la fenetre pop-up
$bdTitreAr = mysqli_query($GLOBALS['bd'], $queryNomArticle ) or bdErreurRequet($queryNomArticle);

$arN = mysqli_fetch_assoc($bdTitreAr);

firstPop($dossier , 'Commentaire' ,  fp_protectHTML($arN['arTitre']));

mysqli_free_result($bdTitreAr);
//Fin Sous Titre de la fenetre pop-up


// Commentaire de la fenetre pop-up
$commentaireArticle = mysqli_query($GLOBALS['bd'], $queryCommentaireArticle ) or bdErreurRequet($queryCommentaireArticle);

while ($com = mysqli_fetch_assoc($commentaireArticle)) {
    echo '<h4>',
	        fp_protectHTML($com['coAuteur']), ' - ',
	        dateBlogToDate($com['coDate']), ' - ',
	        $com['coHeure'],
        '</h4>',
        '<div class="commentTexte">',
			fp_protectHTML($com['coTexte'], TRUE),
		'</div>';
}

mysqli_free_result($commentaireArticle);
//Fin Commentaire de la fenetre pop-up

// On fait un formulaire pour avoir un bouton
echo '<form name="form1" method="post" action="">';

fp_htmlBoutons(-1, 'B|btnFermer|Fermer|self.close();opener.focus()');

echo '</form>',
	'</div>',	// fin du bloc blcPopPage
	'</body></html>';


ob_end_flush();

?>
