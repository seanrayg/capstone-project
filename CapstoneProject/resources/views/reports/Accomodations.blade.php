<?php

    session_start();

    require('C:\xampp\htdocs\sewd\adminside\plugins\mysql_table.php');

    class PDF extends PDF_MySQL_Table{

        // Page Header
        function Header(){

            //logo
            $this->Image('C:\xampp\htdocs\latest\adminside\images\IMG_1454.png', 70, 10, 40, 30);
            // Arial bold 15
            $this->SetFont('Arial','B',20);
            // Line break00
            $this->Ln(5);
            // Move to the right
            $this->Cell(125);
            // Title
            $this->Cell(30,10,'Il Sogno Beach Resort',0,1,'C');
            $this->SetFont('Arial', '', 10);
            $this->Cell(125);
            $this->Cell(30,10,'Nangkaan Locloc Bauan, Batangas',0,1,'C');
            $this->Cell(125);
            $this->Cell(30,0,'090909090909',0,0,'C');
            // Line break00
            $this->Ln(20);

        }

        // Page footer
        function Footer(){

            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Page number
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

        }

    }

    $conn = mysqli_connect('localhost','root','');
    mysqli_select_db($conn, 'dbilsognobeachresort');

    $dtmNow = date("mdY");

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L', 'Letter');
    $pdf->SetFont('Arial','U',15);
    $pdf->Cell(8);
    $pdf->Cell(30,0,'CUSTOMER LIST',0,0);
    $pdf->Cell(195);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(30,0,"{$dtmNow}",0,0);
    $pdf->Ln(10);

?>