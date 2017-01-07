<?php

ob_start();

require ('../bibli_html_fonct.php');
require ('../bibli_php_fonct.php');
require ('../bibli_requets_sql.php');
require ('../setting.php');

$niveauDossier = 2;
$dossier = niveauDossier($niveauDossier);



firstHtml();

headPublique('Mise a jours Blog', $dossier);

blocBandeau($dossier , 1); // page privé donc deuxieme argument autre que 0

ob_end_flush()
?>
