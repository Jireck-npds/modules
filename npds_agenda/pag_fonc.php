<?PHP
/*********************************************/
/* NPDS : Net Portal Dynamic System          */
/* ==========================                */
/* Fichier : modules/agenda/pag_fonc.php     */
/*                                           */
/* Module Agenda                             */
/* Version 1.2                               */
/* Auteur Oim                                */
/*********************************************/
/*$adjacentes = nombre de pages a afficher de chaque cote de la page courante apres 7 //
$css = vide style.css sinon ajout pour css module (_mod pour le module et _admin pour la partie admin*/
function ag_pag($total,$courante,$adjacentes,$ThisFile,$css)
{
	/* Variables */
	$prec = $courante - 1; // numero de la page precedente
	$suiv = $courante + 1; // numero de la page suivante
	$avder = $total - 1; // avant derniere page
	$pagination = "";
	if($total > 1)
	{
		$pagination .= '<div class="pagination'.$css.'" align="right">';
		if ($courante == 2)
			$pagination.= '<a href="'.$ThisFile.'">&laquo; pr&eacute;c</a>';
		elseif ($courante > 2)
			$pagination.= '<a href="'.$ThisFile.'&amp;page='.$prec.'">&laquo; pr&eacute;c</a>';
		else
			$pagination.= '<span class="desactive'.$css.'">&laquo; pr&eacute;c</span>';
		if ($total < 7 + ($adjacentes * 2))
		{
			$pagination.= ($courante == 1) ? '<span class="courante'.$css.'">1</span>' : '<a href="'.$ThisFile.'">1</a>';
			for ($compteur = 2; $compteur <= $total; $compteur++)
			{
				if ($compteur == $courante)
					$pagination.= '<span class="courante'.$css.'">'.$compteur.'</span>';
				else
					$pagination.= '<a href="'.$ThisFile.'&amp;page='.$compteur.'">'.$compteur.'</a>';
			}
		}
		elseif($total > 5 + ($adjacentes * 2))
		{
			if($courante < 1 + ($adjacentes * 2))
			{
				$pagination.= ($courante == 1) ? '<span class="courante'.$css.'">1</span>' : '<a href="'.$ThisFile.'">1</a>';
				for ($compteur = 2; $compteur < 4 + ($adjacentes * 2); $compteur++)
				{
					if ($compteur == $courante)
						$pagination.= '<span class="courante'.$css.'">'.$compteur.'</span>';
					else
						$pagination.= '<a href="'.$ThisFile.'&amp;page='.$compteur.'">'.$compteur.'</a>';
				}
				$pagination.= ' ... ';
				$pagination.= '<a href="'.$ThisFile.'&amp;page='.$avder.'">'.$avder.'</a>';
				$pagination.= '<a href="'.$ThisFile.'&amp;page='.$total.'">'.$total.'</a>';
			}
			elseif($total - ($adjacentes * 2) > $courante && $courante > ($adjacentes * 2))
			{
				$pagination.= '<a href="'.$ThisFile.'">1</a>';
				$pagination.= '<a href="'.$ThisFile.'&amp;page=2">2</a>';
				$pagination.= ' ... ';
				for ($compteur = $courante - $adjacentes; $compteur <= $courante + $adjacentes; $compteur++)
				{
					if ($compteur == $courante)
						$pagination.= '<span class="courante'.$css.'">'.$compteur.'</span>';
					else
						$pagination.= '<a href="'.$ThisFile.'&page='.$compteur.'">'.$compteur.'</a>';
				}
				$pagination.= ' ... ';
				$pagination.= '<a href="'.$ThisFile.'&amp;page='.$avder.'">'.$avder.'</a>';
				$pagination.= '<a href="'.$ThisFile.'&amp;page='.$total.'">'.$total.'</a>';
			}
			else
			{
				$pagination.= '<a href="'.$ThisFile.'">1</a>';
				$pagination.= '<a href="'.$ThisFile.'&amp;page=2">2</a>';
				$pagination.= ' ... ';
				for ($compteur = $total - (2 + ($adjacentes * 2)); $compteur <= $total; $compteur++)
				{
					if ($compteur == $courante)
						$pagination.= '<span class="courante'.$css.'">'.$compteur.'</span>';
					else
						$pagination.= '<a href="'.$ThisFile.'&amp;page='.$compteur.'">'.$compteur.'</a>';
				}
			}
		}
		if ($courante < $compteur - 1)
			$pagination.= '<a href="'.$ThisFile.'&amp;page='.$suiv.'">suiv &raquo;</a>';
		else
			$pagination.= '<span class="desactive'.$css.'">suiv &raquo;</span>';
			$pagination.= '</div>';
	}
	return ($pagination);
}
?>