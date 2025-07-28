<?php
require 'tFPDF/tfpdf.php';
class extend_fpdf extends tFPDF
{
/**
 * Gestion du header du pdf envoyant l'historique des utilisateurs
 */
function Header()
{
    date_default_timezone_set('Europe/Paris');

    $this->SetFont('Arial','B',5);

    $this->Cell(30,10, time(),'C');
    $this->SetFont('Arial','B',15);
    $this->Cell(30);
    $this->Cell(10,10, 'Rapport du '.date("Y-m-d H:i:s"),'C');;

    $this->Ln();
}
}