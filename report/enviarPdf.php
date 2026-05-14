<?php
ob_start();
require_once __DIR__ . '/../Lib/fpdf.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFillColor(27, 67, 50);
        $this->Rect(0, 0, $this->GetPageWidth(), 35, 'F');

        $this->SetFillColor(181, 146, 76);
        $this->Rect(0, 35, $this->GetPageWidth(), 2, 'F');

        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 18);
        $this->SetXY(10, 8);
        $this->Cell(0, 10, 'HOTEL VERDE', 0, 1, 'C');

        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(196, 251, 109);
        $this->SetX(10);
        $this->Cell(0, 6, 'Naturaleza  *  Confort  *  Experiencia', 0, 1, 'C');

        $this->SetY(45);
    }

    function Footer()
    {
        $this->SetY(-20);
        $this->SetDrawColor(181, 146, 76);
        $this->SetLineWidth(0.8);
        $this->Line(10, $this->GetY(), $this->GetPageWidth() - 10, $this->GetY());
        $this->Ln(3);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 5, 'Documento valido como comprobante de reserva. Presentar al momento del check-in.', 0, 1, 'C');
        $this->Cell(0, 5, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

$r = $datos;
$w_util = 180;

$pdf = new PDF('P', 'mm', 'Letter');
$pdf->SetMargins(15, 10, 15);
$pdf->SetAutoPageBreak(true, 25);
$pdf->AddPage();

// ── Título ────────────────────────────────────────────────
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetTextColor(27, 67, 50);
$pdf->Cell($w_util, 8, 'CONFIRMACION DE RESERVA', 0, 1, 'C');
$pdf->SetDrawColor(181, 146, 76);
$pdf->SetLineWidth(0.8);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(4);

// ── Datos del huésped ─────────────────────────────────────
$pdf->SetFillColor(27, 67, 50);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($w_util, 7, '  DATOS DEL HUESPED', 0, 1, 'L', true);
$pdf->Ln(2);

$pdf->SetFillColor(245, 245, 240);
$pdf->Rect(15, $pdf->GetY(), $w_util, 30, 'F');
$yB = $pdf->GetY() + 3;

$campos_huesped = [
    ['Nombre:',    utf8_decode($r['user_name'] . ' ' . $r['last_name'])],
    ['Documento:', $r['document_number']],
    ['Correo:',    $r['email']],
];
foreach ($campos_huesped as $i => $campo) {
    $pdf->SetXY(18, $yB + ($i * 10));
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(45, 6, $campo[0], 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetTextColor(26, 26, 26);
    $pdf->Cell(0, 6, $campo[1], 0, 1);
}

$pdf->SetY($yB + 33);
$pdf->Ln(4);

// ── Detalles de la reserva ────────────────────────────────
$pdf->SetFillColor(27, 67, 50);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($w_util, 7, '  DETALLES DE LA RESERVA', 0, 1, 'L', true);
$pdf->Ln(2);

$pdf->SetFillColor(245, 245, 240);
$pdf->Rect(15, $pdf->GetY(), $w_util, 30, 'F');
$yB2 = $pdf->GetY() + 3;

$campos_reserva = [
    ['Tipo habitacion:', utf8_decode($r['tipo_hab'])],
    ['N habitacion:',   'Habitacion ' . $r['room_number']],
    ['Personas:',        $r['people']],
];
foreach ($campos_reserva as $i => $campo) {
    $pdf->SetXY(18, $yB2 + ($i * 10));
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(45, 6, $campo[0], 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetTextColor(26, 26, 26);
    $pdf->Cell(0, 6, $campo[1], 0, 1);
}

$pdf->SetY($yB2 + 33);
$pdf->Ln(4);

// ── Fechas ────────────────────────────────────────────────
$pdf->SetFillColor(27, 67, 50);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($w_util, 7, '  FECHAS DE ESTADIA', 0, 1, 'L', true);
$pdf->Ln(2);

$pdf->SetFillColor(245, 245, 240);
$pdf->Rect(15, $pdf->GetY(), $w_util, 20, 'F');
$yB3 = $pdf->GetY() + 3;

$campos_fechas = [
    ['Check-in:',  $r['start_date']],
    ['Check-out:', $r['end_date']],
];
foreach ($campos_fechas as $i => $campo) {
    $pdf->SetXY(18, $yB3 + ($i * 10));
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->Cell(45, 6, $campo[0], 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetTextColor(26, 26, 26);
    $pdf->Cell(0, 6, $campo[1], 0, 1);
}

$pdf->SetY($yB3 + 24);
$pdf->Ln(4);

// ── Total ─────────────────────────────────────────────────
$pdf->SetFillColor(27, 67, 50);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($w_util, 7, '  RESUMEN DE PAGO', 0, 1, 'L', true);
$pdf->Ln(2);

$pdf->SetFillColor(245, 245, 240);
$pdf->Rect(15, $pdf->GetY(), $w_util, 12, 'F');
$yB4 = $pdf->GetY() + 3;

$pdf->SetXY(18, $yB4);
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(27, 67, 50);
$pdf->Cell(45, 6, 'TOTAL:', 0, 0);
$pdf->Cell(0, 6, '$ ' . number_format($r['price'], 0, ',', '.'), 0, 1, 'R');

ob_end_clean();
$pdf->Output('I', 'reserva_HV' . str_pad($r['id'], 6, '0', STR_PAD_LEFT) . '.pdf');
?>