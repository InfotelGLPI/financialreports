<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 financialreports plugin for GLPI
 Copyright (C) 2009-2016 by the financialreports Development Team.

 https://github.com/InfotelGLPI/financialreports
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of financialreports.

 financialreports is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 financialreports is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with financialreports. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

if (!defined('FPDF_VERSION')) {
   require_once(GLPI_ROOT . "/plugins/financialreports/fpdf/fpdf.php");
   require_once(GLPI_ROOT . "/plugins/financialreports/fpdf/font/symbol.php");
}

/**
 * Class PluginFinancialreportsPdf
 */
class PluginFinancialreportsPdf extends FPDF
{

   /* Attributs d'un rapport envoy�s par l'utilisateur avant la g�n�ration. */

   var $date = "";        // Date le l'arret�

   /* Constantes pour param�trer certaines donn�es. */
   var $line_height = 5;         // Hauteur d'une ligne simple.
   var $pol_def = 'Arial';       // Police par d�faut;
   var $tail_pol_def = 9;        // Taille par d�faut de la police.
   var $tail_titre = 22;         // Taille du titre.
   var $marge_haut = 5;          // Marge du haut.
   var $marge_gauche = 15;       // Marge de gauche et de droite accessoirement.
   var $largeur_grande_cell = 280;  // Largeur d'une cellule qui prend toute la page.
   var $tail_bas_page = 20;      // Hauteur du bas de page.
   var $nb_carac_ligne = 90;     // Pour le d�tail des travaux;


   /* ************************************* */
   /* Methodes g�n�riques de mise en forme. */
   /* ************************************* */

   /** Fonction permettant de dessiner une ligne blanche s�paratrice. */
   function Separateur()
   {
      $this->Cell($this->largeur_grande_cell, $this->line_height, '', 0, 0, '');
      $this->SetY($this->GetY() + $this->line_height);
   }

   /** Positionne la couleur du texte blanc. */
   function SetTextRouge()
   {
      $this->SetTextColor(255, 0, 0);
   }

   /** Positionne la couleur du texte blanc. */
   function SetTextNoir()
   {
      $this->SetTextColor(0, 0, 0);
   }

   /** Positionne la couleur du texte nbleu. */
   function SetTextBleu()
   {
      $this->SetTextColor(100, 100, 255);
   }

   /** Positionne la couleur de fond blanc. */
   function SetFondBlanc()
   {
      $this->SetFillColor(255, 255, 255);
   }

   /** Positionne la couleur de fond en gris clair. */
   function SetFondClair()
   {
      $this->SetFillColor(205, 205, 205);
   }

   /** Positionne la couleur de fond en gris clair. */
   function SetFondTresClair()
   {
      $this->SetFillColor(245, 245, 245);
   }

   /** Positionne la couleur de fond en gris clair. */
   function SetFondGrisClair()
   {
      $this->SetFillColor(230, 230, 230);
   }

   /** Positionne la couleur de fond en gris fonc�. */
   function SetFondFonce()
   {
      $this->SetFillColor(85, 85, 85);
   }

   /**
    * Positionne la fonte pour un label.
    * @param $italic Vrai si c'est en italique, faux sinon.
    */
   function SetFontLabel($italic)
   {
      if ($italic) {
         $this->SetFont($this->pol_def, 'BI', $this->tail_pol_def);
      } else {
         $this->SetFont($this->pol_def, 'B', $this->tail_pol_def);
      }
   }

   /**
    * Red�finit une fonte normale.
    * @param bool|Vrai $souligne Vrai si le texte sera soulign�, faux sinon �tant la valeur par d�faut.
    */
   function SetFontNormale($souligne = false)
   {
      if ($souligne) {
         $this->SetFont($this->pol_def, 'U', $this->tail_pol_def);
      } else {
         $this->SetFont($this->pol_def, '', $this->tail_pol_def);
      }
   }

   /**
    * Permet de dessiner une cellule definissant un label d'une cellule ou plusieurs cellules valeurs.
    * @param $italic Vrai si le label est en italique, faux sinon.
    * @param $w Largeur de la cellule contenant le label.
    * @param $label Valeur du label.
    * @param int|Multiplicateur $multH Multiplicateur de la hauteur de la cellule, par d�faut vaut 1, par augment� donc.
    * @param D|string $align D�termine l'alignement du texte dans la cellule.
    * @param D|int $bordure D�termine les bordures � positionner, par d�faut, toutes.
    */
   function CellLabel($italic, $w, $label, $multH = 1, $align = '', $bordure = 1)
   {
      $this->SetFondClair();
      $this->SetFontLabel($italic);
      $this->Cell($w, $this->line_height * $multH, $label, $bordure, 0, $align, 1);
   }

   /**
    * Permet de dessiner une cellule definissant une entete de tableau.
    * @param $italic Vrai si le label est en italique, faux sinon.
    * @param $w Largeur de la cellule contenant le label.
    * @param $label Valeur du label.
    * @param int|Multiplicateur $multH Multiplicateur de la hauteur de la cellule, par d�faut vaut 1, par augment� donc.
    * @param D|string $align D�termine l'alignement du texte dans la cellule.
    * @param D|int $bordure D�termine les bordures � positionner, par d�faut, toutes.
    */
   function CellEnTeteTableau($italic, $w, $label, $multH = 1, $align = '', $bordure = 1)
   {
      $this->SetFondGrisClair();
      $this->SetFontLabel($italic);
      $this->Cell($w, $this->line_height * $multH, $label, $bordure, 0, $align, 1);
   }

   /**
    * Permet de dessiner une cellule definissant une ligne de tableau.
    * @param $italic Vrai si le label est en italique, faux sinon.
    * @param $w Largeur de la cellule contenant le label.
    * @param $label Valeur du label.
    * @param int|Multiplicateur $multH Multiplicateur de la hauteur de la cellule, par d�faut vaut 1, par augment� donc.
    * @param D|string $align D�termine l'alignement du texte dans la cellule.
    * @param D|int $bordure D�termine les bordures � positionner, par d�faut, toutes.
    */
   function CellLigneTableau($italic, $w, $label, $multH = 1, $align = '', $bordure = 1)
   {
      //$this->SetFondBlanc();
      $this->SetFontLabel($italic);
      $this->SetFont($this->pol_def, '', $this->tail_pol_def - 2);
      //$this->SetFontSize($this->tail_pol_def - 2);
      $this->Cell($w, $this->line_height * $multH, $label, $bordure, 0, $align, 1);
      //$this->SetFontSize($this->tail_pol_def);
   }

   /**
    * Permet de dessiner une cellule dite normale.
    * @param $w Largeur de la cellule contenant la valeur.
    * @param $valeur Valeur � afficher.
    * @param D|string $align D�termine l'alignement de la cellule.
    * @param int|Multiplicateur $multH Multiplicateur de la hauteur de la cellule, par d�faut vaut 1, par augment� donc.
    * @param D|int $bordure D�termine les bordures � positionner, par d�faut, toutes.
    * @param bool|D $souligne D�termine si le contenu de la cellule est soulign�.
    */
   function CellValeur($w, $valeur, $align = '', $multH = 1, $bordure = 1, $souligne = false)
   {
      $this->SetFontNormale($souligne);
      $this->Cell($w, $this->line_height * $multH, $valeur, $bordure, 0, $align);
   }

   /**
    * Permet de dessinner un cellule vide et gris�e fonc�e.
    * @param $w Largeur de la cellule.
    */
   function CellVideFoncee($w)
   {
      $this->SetFondFonce();
      $this->Cell($w, $this->line_height, '', 1, 0, '', 1);
   }

   /* **************************************** */
   /* Methodes g�n�rant le contenu du rapport. */
   /* **************************************** */

   /**
    * Fonction permettant de dessiner l'ent�te du rapport.
    */
   function Header()
   {

      /* Constantes pour les largeurs de cellules de l'ent�te (doivent �tre = $largeur_grande_cell). */
      $largeur_logo = 40;
      $largeur_titre = 200;
      $largeur_date = 40;
      /* On fixe les marge. */
      $this->SetX($this->marge_gauche);
      $this->SetY($this->marge_haut);

      /* Logo. */
      $this->Image('../pics/logo.jpg', 15, 10, 30, 9); // x, y, w, h
      $this->Cell($largeur_logo, 20, '', 1, 0, 'C');
      /* Titre. */
      $this->SetFont($this->pol_def, 'B', $this->tail_titre);
      $this->Cell($largeur_titre, $this->line_height * 2, Toolbox::decodeFromUtf8(__('Asset situation ended on', 'financialreports')), 'LTR', 0, 'C');
      $this->SetY($this->GetY() + $this->line_height * 2);
      $this->SetX($largeur_logo + 10);
      $this->Cell($largeur_titre, $this->line_height * 2, Html::convDate($this->date), 'LRB', 0, 'C');
      $this->SetY($this->GetY() - $this->line_height * 2);
      $this->SetX($largeur_titre + $largeur_logo + 10);
      /* Date et heure. */
      $this->CellValeur($largeur_date, "", 'C', 1, 'LTR', true); // Libell� pour la date.
      $this->SetY($this->GetY() + $this->line_height);
      $this->SetX($largeur_titre + $largeur_logo + 10);
      $this->CellValeur($largeur_date, "", 'C', 1, 'LR');
      $this->SetY($this->GetY() + $this->line_height);
      $this->SetX($largeur_titre + $largeur_logo + 10);
      $this->CellValeur($largeur_date, "", 'C', 1, 'LR', true); // Libell� pour l'heure.
      $this->SetY($this->GetY() + $this->line_height);
      $this->SetX($largeur_titre + $largeur_logo + 10);
      $this->CellValeur($largeur_date, "", 'C', 1, 'LRB'); // Heure.
      $this->SetY($this->GetY() + $this->line_height + 2);

   }

   /**
    * Fonction permettant de dessiner le tableau des informations g�n�rales.
    * @param $total
    * @param $items
    * @param $deviceType
    * @param int $disposal
    */
   function affiche_tableau($total, $items, $deviceType, $disposal = 0)
   {

      if ($total != 0) {
         /* en-tete */
         $this->CellLabel(false, $this->largeur_grande_cell, Toolbox::decodeFromUtf8($deviceType));
         $this->SetY($this->GetY() + $this->line_height);

         /* En tete tableau. */
         $this->CellEnTeteTableau(false, 45, Toolbox::decodeFromUtf8(__('Name')), 1, 'C', 1);
         $this->CellEnTeteTableau(false, 35, Toolbox::decodeFromUtf8(__('Inventory number')), 1, 'C', 1);
         $this->CellEnTeteTableau(false, 20, Toolbox::decodeFromUtf8(__('Decommission date')), 1, 'C', 1);
         if ($disposal != 1) {
            $this->CellEnTeteTableau(false, 40, Toolbox::decodeFromUtf8(__('User / Group', 'financialreports')), 1, 'C', 1);
            $this->CellEnTeteTableau(false, 40, Toolbox::decodeFromUtf8(__('Location')), 1, 'C', 1);
         }
         $this->CellEnTeteTableau(false, 40, Toolbox::decodeFromUtf8(__('Model')), 1, 'C', 1);
         $this->CellEnTeteTableau(false, 40, Toolbox::decodeFromUtf8(__('Supplier')), 1, 'C', 1);

         if ($disposal == 1) {
            $this->CellEnTeteTableau(false, 20, Toolbox::decodeFromUtf8(__('HT', 'financialreports')), 1, 'C', 1);
            $this->CellEnTeteTableau(false, 25, Toolbox::decodeFromUtf8(__('Decommission date')), 1, 'C', 1);
            $this->CellEnTeteTableau(false, 55, Toolbox::decodeFromUtf8(__('Comments')), 1, 'C', 1);
         } else {
            $this->CellEnTeteTableau(false, 20, Toolbox::decodeFromUtf8(__('HT', 'financialreports')), 1, 'C', 1);
         }
         $this->SetY($this->GetY() + $this->line_height);
         /* ligne. */
         $i = 1;
         foreach ($items as $data) {
            $i++;
            $this->SetFondBlanc();
            if ($i % 2) $this->SetFondTresClair();
            $this->CellLigneTableau(false, 45, $data["ITEM_0"]);
            $this->CellLigneTableau(false, 35, $data["ITEM_2"]);
            $this->CellLigneTableau(false, 20, Html::convDate($data["ITEM_3"]), 1, 'C', 1);
            $this->SetTextBleu();
            $this->CellLigneTableau(false, 40, Toolbox::decodeFromUtf8(formatUserName($data["ITEM_4_3"], $data["ITEM_4"], $data["ITEM_4_2"], $data["ITEM_4_4"])));
            $this->SetTextNoir();
            if ($disposal != 1) {
               $this->CellLigneTableau(false, 40, Toolbox::decodeFromUtf8($data["ITEM_9"]));
               $this->CellLigneTableau(false, 40, Toolbox::decodeFromUtf8($data["ITEM_6"]));
            }

            $this->CellLigneTableau(false, 40, Toolbox::decodeFromUtf8($data["ITEM_7"]));

            if ($disposal == 1) {
               $this->SetTextRouge();
               $this->CellLigneTableau(false, 20, Html::clean(Html::formatNumber($data["ITEM_8"])), 1, 'R', 1);
               $this->SetTextNoir();
               $this->CellLigneTableau(false, 25, Html::convDate($data["ITEM_10"]), 1, 'C', 1);
               $this->CellLigneTableau(false, 55, Toolbox::decodeFromUtf8($data["ITEM_9"]));
            } else {
               $this->SetTextRouge();
               $this->CellLigneTableau(false, 20, Html::clean(Html::formatNumber($data["ITEM_8"])), 1, 'R', 1);
               $this->SetTextNoir();
            }
            $this->SetY($this->GetY() + $this->line_height);
         }
         /* pied */
         if ($total != -1) {
            $this->CellEnTeteTableau(true, $this->largeur_grande_cell - 20, Toolbox::decodeFromUtf8(__('Total')), 1, 'R', 1);
            $this->SetTextRouge();
            $this->CellEnTeteTableau(false, 20, Html::clean(Html::formatNumber($total)), 1, 'R', 1);
            $this->SetTextNoir();
            $this->SetY($this->GetY() + $this->line_height);
         }
      }
   }

   /**
    * Fonction permettant de dessiner le tableau de total.
    * @param $total
    */
   function affiche_tableau_fin($total)
   {

      $this->SetY($this->GetY() + $this->line_height);
      /* en-tete */
      $this->CellLabel(false, $this->largeur_grande_cell, Toolbox::decodeFromUtf8(__('General Total', 'financialreports')));
      $this->SetY($this->GetY() + $this->line_height);

      $this->CellEnTeteTableau(true, $this->largeur_grande_cell - 25, Toolbox::decodeFromUtf8(__('Total')), 1, 'R', 1);
      $this->SetTextRouge();
      $this->CellEnTeteTableau(false, 25, Html::clean(Html::formatNumber($total)), 1, 'R', 1);
      $this->SetTextNoir();
      $this->SetY($this->GetY() + $this->line_height);
   }


   /**
    * Fonction permettant de dessiner le pied de page du rapport.
    */
   function Footer()
   {

      // Positionnement par rapport au bas de la page.
      $this->SetY(-$this->tail_bas_page);
      /* Num�ro de page. */
      $this->SetFont($this->pol_def, '', 9);
      $this->Cell(
         0, $this->tail_bas_page / 2, Toolbox::decodeFromUtf8("") . ' ' . $this->PageNo() . ' ' . Toolbox::decodeFromUtf8("") . ' ', 0, 0, 'C');
      $this->Ln(10);
      /* Infos ODAXYS. */
      $this->SetFont($this->pol_def, 'I', 9);
      $this->Cell(0, $this->tail_bas_page / 4, Toolbox::decodeFromUtf8(""), 0, 0, 'C');
      $this->Ln(5);
      $this->Cell(0, $this->tail_bas_page / 4, Toolbox::decodeFromUtf8(""), 0, 0, 'C');
   }


   /* **************** */
   /* Autres m�thodes. */
   /* **************** */

   /**
    * Retourne une date donn�e format�e dd/mm/yyyy.
    * @param $une_date Date � formater.
    * @return La date donn�e au format dd/mm/yyyy.
    */
   function GetDateFormatee($une_date)
   {

      return $this->CompleterAvec0($une_date['mday'], 2) . "/" . $this->CompleterAvec0($une_date['mon'], 2) . "/" . $une_date['year'];
   }

   /**
    * Retourne une heure donn�e au format hh:mm.
    * @param $une_date Date � formater.
    * @return L'heure donn�e au format hh:mm.
    */
   function GetHeureFormatee($une_date)
   {

      return $this->CompleterAvec0($une_date['hours'], 2) . ":" . $this->CompleterAvec0($une_date['minutes'], 2);
   }

   /**
    * Compl�te une cha�ne donn�e avec des '0' suivant la longueur donn�e et voulue de la cha�ne.
    * @param $une_chaine Cha�ne � compl�ter.
    * @param $lg Longueur finale souhait�e de la cha�ne donn�e.
    * @return La cha�ne compl�t�e.
    */
   function CompleterAvec0($une_chaine, $lg)
   {

      while (strlen($une_chaine) != $lg) {
         $une_chaine = "0" . $une_chaine;
      }

      return $une_chaine;
   }

   /* ********************* */
   /* Getteurs et setteurs. */
   /* ********************* */

   /**
    * @param $date
    */
   function setDate($date)
   {
      $this->date = $date;
   }
}