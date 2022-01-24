<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 financialreports plugin for GLPI
 Copyright (C) 2009-2022 by the financialreports Development Team.

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

/**
 * Class PluginFinancialreportsPdf
 */
class PluginFinancialreportsPdf extends TCPDF {

   /* Attributes of a report sent by the user before generation. */

   var $date = "";        // Date of arrears

   /* Constantes pour paramétrer certaines données. */
   var $line_height       = 5;         // Height of a single line.
   var $pol_def           = 'helvetica';       // Default font;
   var $tail_pol_def      = 9;        // Default font size.
   var $tail_titre        = 22;         // Size of the title.
   var $top_margin        = 5;          // Top margin.
   var $left_right_margin = 15;       // Left and right margin.
   var $large_cell_width  = 280;  // The width of a cell that takes up the entire page.
   var $tail_bas_page     = 20;      // Height of the foot of the page.
   var $number_line_char  = 90;     // For details of the work;


   /* ************************************* */
   /* Generic formatting methods. */
   /* ************************************* */

   /** Position the color of the white text. */
   function SetTextRed() {
      $this->SetTextColor(255, 0, 0);
   }

   /** Position the color of the black text. */
   function SetTextBlack() {
      $this->SetTextColor(0, 0, 0);
   }

   /** Position the color of the text in blue. */
   function SetTextBlue() {
      $this->SetTextColor(100, 100, 255);
   }

   /** Position the white background color. */
   function SetFondWhite() {
      $this->SetFillColor(255, 255, 255);
   }

   /** Position the light gray background color. */
   function SetLightBackground() {
      $this->SetFillColor(205, 205, 205);
   }

   /** Position the light gray background color. */
   function SetVeryLightBackgroung() {
      $this->SetFillColor(245, 245, 245);
   }

   /** Position the light gray background color. */
   function SetBackgroundGreyLight() {
      $this->SetFillColor(230, 230, 230);
   }

   /** Sets the background color to dark gray. */
   function SetBackgroundDark() {
      $this->SetFillColor(85, 85, 85);
   }

   /**
    * Position the font for a label.
    *
    * @param $italic True if it's in italics, false otherwise.
    */
   function SetFontLabel($italic) {
      if ($italic) {
         $this->SetFont($this->pol_def, 'BI', $this->tail_pol_def);
      } else {
         $this->SetFont($this->pol_def, 'B', $this->tail_pol_def);
      }
   }

   /**
    * Redefines a normal font.
    *
    * @param bool|True $souligne True if the text will be underlined, false otherwise being the default.
    */
   function SetFontNormal($souligne = false) {
      if ($souligne) {
         $this->SetFont($this->pol_def, 'U', $this->tail_pol_def);
      } else {
         $this->SetFont($this->pol_def, '', $this->tail_pol_def);
      }
   }

   /**
    * Allows you to draw a cell defining a label of a cell or several cell values.
    *
    * @param                    $italic True if the label is italic, false otherwise.
    * @param                    $w Width of the cell containing the label.
    * @param                    $label Value of the label.
    * @param int|Multiplicateur $multH Multiplier of the height of the cell, default is equal to 1, thus increased.
    * @param D|string           $align Determine the alignment of the text in the cell.
    * @param D|int              $bordure Determines which borders to position, by default, all.
    */
   function CellLabel($italic, $w, $label, $multH = 1, $align = '', $bordure = 1) {
      $this->SetLightBackground();
      $this->SetFontLabel($italic);
      $this->Cell($w, $this->line_height * $multH, $label, $bordure, 0, $align, 1);
   }

   /**
    * Allows you to draw a cell defining a table header.
    *
    * @param                    $italic True if the label is italic, false otherwise.
    * @param                    $w The width of the cell containing the label.
    * @param                    $label Value of the label.
    * @param int|Multiplicateur $multH Multiplier of the height of the cell, default is equal to 1, thus increased.
    * @param D|string           $align Determine the alignment of the text in the cell.
    * @param D|int              $bordure Determines which borders to position, by default, all.
    */
   function CellHeadTable($italic, $w, $label, $multH = 1, $align = '', $bordure = 1) {
      $this->SetBackgroundGreyLight();
      $this->SetFontLabel($italic);
      $this->Cell($w, $this->line_height * $multH, $label, $bordure, 0, $align, 1);
   }

   /**
    * Allows you to draw a cell defining a table row.
    *
    * @param                    $italic True if the label is italic, false otherwise.
    * @param                    $w The width of the cell containing the label.
    * @param                    $label Value of the label.
    * @param int|Multiplicateur $multH Multiplier of the height of the cell, default is equal to 1, thus increased.
    * @param D|string           $align Determine the alignment of the text in the cell.
    * @param D|int              $bordure Determines which borders to position, by default, all.
    */
   function CellLineTable($italic, $w, $label, $multH = 1, $align = '', $bordure = 1) {
      $this->SetFontLabel($italic);
      $this->SetFont($this->pol_def, '', $this->tail_pol_def - 2);
      $this->Cell($w, $this->line_height * $multH, $label, $bordure, 0, $align, 1);
   }

   /**
    * Allows to draw a cell called normal.
    *
    * @param                    $w The width of the cell containing the label.
    * @param                    $value Value to displayr.
    * @param D|string           $align Determines the alignment of the cell.
    * @param int|Multiplicateur $multH Multiplier of the height of the cell, default is equal to 1, thus increased.
    * @param D|int              $bordure Determines which borders to position, by default, all.
    * @param bool|D             $souligne Determines whether the contents of the cell are underlined.
    */
   function CellValue($w, $value, $align = '', $multH = 1, $bordure = 1, $souligne = false) {
      $this->SetFontNormal($souligne);
      $this->Cell($w, $this->line_height * $multH, $value, $bordure, 0, $align);
   }

   /* **************************************** */
   /* Methods generating report content. */
   /* **************************************** */

   /**
    * Function to draw the report header.
    */
   function Header() {

      /* Constants for the cell widths of the header (must be = $ large_cell_width). */
      $logo_width  = 40;
      $title_width = 200;
      $date_width  = 40;
      /* margins. */
      $this->SetX($this->left_right_margin);
      $this->SetY($this->top_margin);

      /* Logo. */
      $this->Image('../pics/logo.jpg', 15, 10, 30, 9); // x, y, w, h
      $this->Cell($logo_width, $this->line_height * 4, '', 1, 0, 'C');
      /* Title. */
      $this->SetFont($this->pol_def, 'B', $this->tail_titre);
      $this->Cell($title_width, $this->line_height * 2, __('Financial report ended on', 'financialreports'),
                  'LTR', 0, 'C');
      $this->SetY($this->GetY() + $this->line_height * 2);
      $this->SetX($logo_width + 10);
      $this->Cell($title_width, $this->line_height * 2, Html::convDate($this->date), 'LRB', 0, 'C');
      $this->SetY($this->GetY() - $this->line_height * 2);
      $this->SetX($title_width + $logo_width + 10);
      /* Date & hour. */
      $this->CellValue($date_width, "", 'C', 1, 'LTR', true); // Label for the date.
      $this->SetY($this->GetY() + $this->line_height);
      $this->SetX($title_width + $logo_width + 10);
      $this->CellValue($date_width, "", 'C', 1, 'LR');
      $this->SetY($this->GetY() + $this->line_height);
      $this->SetX($title_width + $logo_width + 10);
      $this->CellValue($date_width, "", 'C', 1, 'LR', true); // Label for the hour.
      $this->SetY($this->GetY() + $this->line_height);
      $this->SetX($title_width + $logo_width + 10);
      $this->CellValue($date_width, "", 'C', 1, 'LRB'); // Hour.

      $this->SetMargins(PDF_MARGIN_LEFT, $this->GetY() + $this->line_height * 2, PDF_MARGIN_RIGHT);
   }

   /**
    * Function to draw the table of general information.
    *
    * @param     $total
    * @param     $items
    * @param     $deviceType
    * @param int $disposal
    */
   function display_table($total, $items, $deviceType, $disposal = 0) {

      if ($total != 0) {
         /* en-tete */
         $this->CellLabel(false, $this->large_cell_width, $deviceType);
         $this->SetY($this->GetY() + $this->line_height);

         /* En tete tableau. */
         $this->CellHeadTable(false, 45, __('Name'), 1, 'C', 1);
         $this->CellHeadTable(false, 35, __('Inventory number'), 1, 'C', 1);
         $this->CellHeadTable(false, 20, __('Decommission date'), 1, 'C', 1);
         if ($disposal != 1) {
            $this->CellHeadTable(false, 40, __('User / Group', 'financialreports'), 1, 'C', 1);
            $this->CellHeadTable(false, 40, __('Location'), 1, 'C', 1);
         }
         $this->CellHeadTable(false, 40, __('Model'), 1, 'C', 1);
         $this->CellHeadTable(false, 40, __('Supplier'), 1, 'C', 1);

         if ($disposal == 1) {
            $this->CellHeadTable(false, 20, __('HT', 'financialreports'), 1, 'C', 1);
            $this->CellHeadTable(false, 25, __('Decommission date'), 1, 'C', 1);
            $this->CellHeadTable(false, 55, __('Comments'), 1, 'C', 1);
         } else {
            $this->CellHeadTable(false, 20, __('HT', 'financialreports'), 1, 'C', 1);
         }
         $this->SetY($this->GetY() + $this->line_height);
         /* ligne. */
         $i = 1;

         $dbu = new DbUtils();

         foreach ($items as $data) {
            $i++;
            $this->SetFondWhite();
            if ($i % 2) $this->SetVeryLightBackgroung();
            $this->CellLineTable(false, 45, $data["ITEM_0"]);
            $this->CellLineTable(false, 35, $data["ITEM_2"]);
            $this->CellLineTable(false, 20, Html::convDate($data["ITEM_3"]), 1, 'C', 1);
            $this->SetTextBlue();
            $this->CellLineTable(false, 40,$dbu->formatUserName($data["ITEM_4_3"], $data["ITEM_4"], $data["ITEM_4_2"], $data["ITEM_4_4"], 0));
            $this->SetTextBlack();
            if ($disposal != 1) {
               $this->CellLineTable(false, 40, $data["ITEM_9"]);
               $this->CellLineTable(false, 40, $data["ITEM_6"]);
            }

            $this->CellLineTable(false, 40, $data["ITEM_7"]);

            if ($disposal == 1) {
               $this->SetTextRed();
               $this->CellLineTable(false, 20, Glpi\RichText\RichText::getTextFromHtml(Html::formatNumber($data["ITEM_8"])), 1, 'R', 1);
               $this->SetTextBlack();
               $this->CellLineTable(false, 25, Html::convDate($data["ITEM_10"]), 1, 'C', 1);
               $this->CellLineTable(false, 55, $data["ITEM_9"]);
            } else {
               $this->SetTextRed();
               $this->CellLineTable(false, 20, Glpi\RichText\RichText::getTextFromHtml(Html::formatNumber($data["ITEM_8"])), 1, 'R', 1);
               $this->SetTextBlack();
            }
            $this->SetY($this->GetY() + $this->line_height);
         }
         /* pied */
         if ($total != -1) {
            $this->CellHeadTable(true, $this->large_cell_width - 20, __('Total'), 1, 'R', 1);
            $this->SetTextRed();
            $this->CellHeadTable(false, 20, Glpi\RichText\RichText::getTextFromHtml(Html::formatNumber($total)), 1, 'R', 1);
            $this->SetTextBlack();
            $this->SetY($this->GetY() + $this->line_height);
         }
      }
   }

   /**
    * Function to draw the total table.
    *
    * @param $total
    */
   function display_table_fin($total) {

      $this->SetY($this->GetY() + $this->line_height);
      /* en-tete */
      $this->CellLabel(false, $this->large_cell_width, __('General Total', 'financialreports'));
      $this->SetY($this->GetY() + $this->line_height);

      $this->CellHeadTable(true, $this->large_cell_width - 25, __('Total'), 1, 'R', 1);
      $this->SetTextRed();
      $this->CellHeadTable(false, 25, Glpi\RichText\RichText::getTextFromHtml(Html::formatNumber($total)), 1, 'R', 1);
      $this->SetTextBlack();
      $this->SetY($this->GetY() + $this->line_height);
   }

   /**
    * Function to draw the footer of the report.
    */
   function Footer() {

      // Positioning relative to the bottom of the page.
      $this->SetY(-$this->tail_bas_page);
      /* Page number. */
      $this->SetFont($this->pol_def, '', 9);
      $this->Cell(
         0, $this->tail_bas_page / 2, Toolbox::decodeFromUtf8("") . ' ' . $this->PageNo() . ' ' . Toolbox::decodeFromUtf8("") . ' ', 0, 0, 'C');
      $this->Ln(10);
      /* Infos . */
      $this->SetFont($this->pol_def, 'I', 9);
      $this->Cell(0, $this->tail_bas_page / 4, Toolbox::decodeFromUtf8(""), 0, 0, 'C');
      $this->Ln(5);
      $this->Cell(0, $this->tail_bas_page / 4, Toolbox::decodeFromUtf8(""), 0, 0, 'C');
   }



   /* ********************* */
   /* Getteurs et setteurs. */
   /* ********************* */

   /**
    * @param $date
    */
   function setDate($date) {
      $this->date = $date;
   }
}
