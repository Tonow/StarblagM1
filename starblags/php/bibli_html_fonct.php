<?php


/**
 * Permet de generer le html pour le footer de tout les page
 *
 * @return void --> le footer html
 */
function footerGlobal(){
  echo <<<FOOTER
  <div id="blcPied">
		StarBlagS est une marque déposée appartenant à la société PTICON(PiaT International Corporation Original Network)
		<br>&nbsp;
		<br>
		<a href="#" onclick="alert('Faux lien !'); return false;">Contactez-nous</a> -
		<a href="#" onclick="alert('Faux lien !'); return false;">Informations l égales</a> -
		<a href="#" onclick="alert('Faux lien !'); return false;">Conditions d utilisation</a>
	</div>
	<!-- FIN DU BLOC PIED -->
FOOTER;
}


/**
 * Permet de generer le html pour le bandeau de tout les page
 *
 * @param string $dossier niveau dans le quelle se trouve le dossier
 * @param int $priver valeur 0 => page publique sinon page privé
 *
 * @return void --> le beadeau html
 */
function blocBandeau($dossier , $priver = 0){
	echo '
	<div id="blcBandeau">';

		if ($priver == 0) {
			echo '<form method="post" action="'.$dossier.'/php/login.php">
					<label for="txtPseudo">Pseudo</label>
					<input type="text" name="txtPseudo" id="txtPseudo" value="">
					<label for="txtPasse">Passe</label>
					<input type="password" name="txtPasse" id="txtPasse" value="">
					<input type="submit" name="btnLogin" value="Mon blog" class="bouton">
					<input type="submit" name="btnNouveau" value="Créer un blog" class="bouton">
				</form>';
		}

		echo '
		<a href="'.$dossier.'/php/">
			<img src="'.$dossier.'/images/logo.gif" title="Accueil StarBlagS" width="104" height="67">
		</a>
	</div> <!-- FIN DU BLOC BANDEAU -->';
}

/**
 * Permet de generer le html pour le head de tout les page en personalisant le titre
 *
 * @param string $titre titre de la page
 * @param string $dossier niveau dans le quelle se trouve le dossier
 *
 * @return void --> le head html
 */
function headPublique($titre , $dossier){
	echo <<<HEAD1
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
HEAD1;

  echo "<title>StarBlags - $titre</title>";

		echo <<<HEAD2
		<link rel="stylesheet" href="$dossier/css/modele_1.css" type="text/css">
		<script type="text/javascript" src="$dossier/js/bibli.js"></script>
	</head>
HEAD2;
}


/**
 * Permet de generer le html pour le debut de tout les pages
 *
 * @return void --> le debut html de tout les pages
 */
function firstHtml(){
	echo '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>';
}


/**
 * Permet de generer le html pour la fin de tout les pages
 *
 * @return void --> la fin html de tout les pages
 */
function endHtml(){
	echo "
	</body>
	</html>
	";
}




/**
 * Permet de generer le html pour tout les debut des pop-up tout les page en personalisant le titre
 * et le sousTitre de chaqu'un d'entre eu
 *
 * @param string $dossier niveau dans le quelle se trouve le dossier
 * @param string $titre titre de la page
 * @param string $sousTitre sous-titre de la page
 *
 * @return void --> le debut html des pop-up
 */
function firstPop($dossier, $titre= 'titreAchanger' , $sousTitre = 'sousTitreAchanger' ){

	echo '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>@_TITLE_@</title>
		<script type="text/javascript">
		if (window.opener == null) {
			document.location.replace("index.php");
		}
		</script>
		<link rel="icon" type="image/gif" href="'.$dossier.'/images/favicon.gif">
		<link rel="stylesheet" href="'.$dossier.'/css/modele_1.css" type="text/css">
		<script type="text/javascript" src="'.$dossier.'/js/bibli.js"></script>
	</head>
	<body>
		<div id="blcPopPage">
			<div id="blcPopBandeau">
				<div id="blcPopTitre">'.$titre.'</div>
				</div>
			<h2>'.$sousTitre.'</h2>';
}






//_____________________________________________________________________________
/**
 * Affiche le code html d'une ligne de boutons de formulaire.
 *
 * Cette fonction accepte un nombre variable de param�tres.
 * Seul le premier est d�fini dans la d�finition de la fonction.
 * Les param�tres suivants d�finissent les boutons.
 * La d�finition d'un bouton se fait dans une zone alpha de la forme :
 *  Type|Nom|Valeur|JavaScript
 * 	Type	type du bouton
 * 		S : submit
 * 		R : reset
 * 		B : button
 * 	Nom		nom du bouton  (attribut name)
 * 	Valeur	valeur du bouton (attribut value)
 * 	JavaScript	fonction JavaScript pour �v�n�ment onclick
 *
 * Exemple : fp_htmlBoutons(2, 'B|btnRetour|Liste des sujets|history.back()', 'S|btnValider|Valider'
 *
 * @param	integer	$colspan	Nombre de colonnes de tableau � joindre. Si -1 pas dans un tableau
 * @param	string	Ind�fini	D�finition d'un bouton. Il peut y avoir
 * 								autant de d�finitions que d�sir�.
 */
function fp_htmlBoutons($colspan) {
	if ($colspan == -1) {
		echo '<p align="right">';
	} else {
		echo '<tr>',
				'<td colspan="', $colspan, '">&nbsp;</td>',
			'</tr>',
			'<tr>',
				'<td colspan="'.$colspan.'" align="right">';
	}

	$nbArg = func_num_args();

	for ($i = 1; $i < $nbArg; $i++) {
		$bouton = func_get_arg($i);
		$description = explode('|', $bouton);

		if ($description[0] == 'S') {
			$description[0] = 'submit';
		} elseif ($description[0] == 'R') {
			$description[0] = 'reset';
		} elseif ($description[0] == 'B') {
			$description[0] = 'button';
		} else {
			continue;
		}

		if (!isset($description[3])) {
			$description[3] = '';
		}

		echo '&nbsp;&nbsp;',
				'<input type="', $description[0], '" ',
				'name="', $description[1], '" ',
				'value="', $description[2], '" ',
				'class="bouton" ',
				( ($description[3] == '') ? '>' : 'onclick="'.$description[3].'">');
	}

	echo ($colspan == -1) ? '</p>' : '</td></tr>';
}


//_____________________________________________________________________________
/**
 * Affiche le code html d'une ligne de tableau �cran de saisie.
 *
 * Le code html g�n�r� est de la forme
 * <tr><td> libelle </td><td> zone de saisie </td></tr>
 *
 * Seuls les 3 premiers param�tres sont obligatoires. Les autres d�pendent
 * du type de la zone.
 * Le libell� de la zone est prot�g� pour un affichage HTML
 * Si la valeur de la zone est du texte, il est prot�g� pour un affichage HTML
 *
 * @param	string	$type	type de la zone
 * 							A : textarea
 * 							AN : textarea uniquement en affichage
 * 							C : case � cocher
 * 							H : hidden
 * 							P : password
 * 							R : bouton radio
 * 							S : select (liste)
 * 							T : text
 * 							TN : text  uniquement en affichage
 * @param	string	$nom	nom de la zone (attribut name)
 * @param	mixed	$valeur	valeur de la zone (attribut value)
 * 							Pour le type S, c'est l'�l�ment s�lectionn�
 * @param	string	$lib	libell� de la zone
 * @param	integer	$size	si type T ou P : longueur (attribut size)
 * 							si type A : longeur (attribut cols)
 * 							si type S : nombre de lignes affich�es (attribut size)
 * 							si type R : 1 = boutons c�te � c�te / 2 = boutons superpos�s
 * 							si type C : 1 = cases c�te � c�te / 2 = cases superpos�s
 * @param	mixed	$max	si type T ou P : longueur maximum (attribut maxlength)
 * 							si type A : nombre de ligne (attribut rows)
 * 							si type R : tableau des boutons radios (valeur => libell�)
 * 							si type C : tableau des case � cocher (valeur => libell�)
 * 							si type S : tableau des lignes de la liste (valeur => libell�)
 * @param	string	$plus	Suppl�ment (ex : fonction JavaScript gestionnaire d'�v�nement)
 */
function fp_htmlSaisie($type, $nom, $valeur, $lib = '', $size = 80, $max = 255, $plus = '') {
	if (is_string($valeur) && $valeur != '') {
		$valeur = fp_protectHTML($valeur);
	}

	// Zone de type Hidden
	if ($type == 'H') {
		echo '<input type="hidden" name="', $nom, '" value="', $valeur, '">';
		return;
	}

	$lib = fp_protectHTML($lib);

	switch ($type) {
	//--------------- Zone de type Texte
	case 'T':
	case 'TN':
		echo '<tr>',
				'<td align="right">', $lib, '&nbsp;</td>',
				'<td>',
					'<input type="text" name="', $nom, '" ', $plus,
					'size="', $size, '" maxlength="', $max, '" value="', $valeur, '" ',
					(($type == 'T') ? 'class="saisie">' : 'class="saisie_non" readonly>'),
				'</td>',
			'</tr>';
		return;

	//--------------- Zone de type Textarea
	case 'A':
	case 'AN':
		echo '<tr>',
				'<td align="right" valign="top">', $lib, '&nbsp;</td>',
				'<td>',
					'<textarea name="', $nom, '" cols="', $size, '" rows="'.$max.'" ', $plus,
					(($type == 'A') ? 'class="saisie">' : 'class="saisie_non" readonly>'),
					$valeur, '</textarea>',
				'</td>',
			'</tr>';
		return;

	//--------------- Zone de type Password
	case 'P':
		echo '<tr>',
				'<td align="right">', $lib, '&nbsp;</td>',
				'<td>',
					'<input type="password" name="', $nom, '" ', $plus,
					'size="', $size, '" maxlength="', $max, '" value="', $valeur, '" ',
					'class="saisie">',
				'</td>',
			'</tr>';
		return;

	//--------------- Zone de type bouton radio
	//--------------- Zone de type case � cocher
	case 'R':
	case 'C':
		if ($type == 'R') {
			$typeAttr = 'radio';
			$nameAttr = $nom;
		} else {
			$typeAttr = 'checkbox';
			$nameAttr = $nom.'[]';
		}

		echo '<tr>',
				'<td align="right" ', (($size == 2) ? 'valign="top">' : '>'),
					$lib, '&nbsp;',
				'</td>',
				'<td>';

		$nb = 0;
		foreach ($max as $val => $txt) {
			if ($size == 2) {
				$nb ++;
				if ($nb > 1) {
					echo '<br>';
				}
			}
			echo '<input type="', $typeAttr, '" name="', $nameAttr, '" value="', $val, '"',
				( ($valeur == $val) ? ' checked="true">' : '>' ),
				fp_protectHTML($txt), '&nbsp;&nbsp;&nbsp;';
		}
		echo '</td>',
			'</tr>';
		return;

	//--------------- Zone de type Select (liste)
	case 'S':
		echo '<tr>',
				'<td align="right"', ( ($size > 1) ? ' valign="top">' : '>'),
					$lib, '&nbsp;',
				'</td>',
				'<td>',
					'<select name="', $nom, '" size="', $size, '" ', $plus, ' class="saisie">';

		foreach($max as $cle => $val) {
			echo '<option value="', $cle, '"', ( ($cle == $valeur) ? ' selected="yes">' : '>' ),
					$val,
				'</option>';
		}

		echo 		'</select>',
				'</td>',
			'</tr>';
		return;
	}
}


//_____________________________________________________________________________
/**
 * Affichage des messages d'erreur d'un formulaire
 *
 * @param	array	$erreurs	Tableau associatif des erreurs
 */
function fp_htmlErreurs($erreurs) {
	echo '<div id="blcErreurs">';
	if (count($erreurs) == 1) {
		echo 'L\'erreur suivante a été détectée ';
	} else {
		echo 'Les erreurs suivantes ont été détectées ';
	}
	echo 'dans le formulaire de saisie :';

	foreach($erreurs as $texte) {
		echo '<p class="erreurTexte">',
				fp_protectHTML($texte),
			'</p>';
	}

	echo '</div>';
}


?>
