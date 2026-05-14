<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/conexion.php';
require_once __DIR__ . '/../models/reserva.php';

session_start();
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if (!isset($_SESSION['user'])) {
    header('location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
    exit;
}

$reservaModel = new Reserva();
$reservas = $reservaModel->getReservasPorUsuario($_SESSION['user']['id']);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Título principal (fusión A1:E1)
$sheet->mergeCells('A1:E1');
$sheet->setCellValue('A1', 'HOTEL CUMBRE VERDE'); // Cambiar nombre del hotel aquí
$sheet->getStyle('A1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 22, 'color' => ['rgb' => 'FFFFFF']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1B4332']]
]);
// Subtítulo (fusión A2:E2)
$sheet->mergeCells('A2:E2');
$sheet->setCellValue('A2', 'Tus reservas');
$sheet->getStyle('A2')->applyFromArray([
    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2D6A4F']]
]);

// Encabezados de columnas (fila 4)
$sheet->setCellValue('A4', 'Habitación');
$sheet->setCellValue('B4', 'Personas');
$sheet->setCellValue('C4', 'Precio');
$sheet->setCellValue('D4', 'Fecha Inicio');
$sheet->setCellValue('E4', 'Fecha Fin');
$sheet->getStyle('A4:E4')->applyFromArray([
    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '52B788']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
]);

// Cargar datos de reservas (desde fila 5 en adelante) y sumar precios
$row = 5;
$totalPrecio = 0;
while ($reserva = $reservas->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $reserva['room_number']);
    $sheet->setCellValue('B' . $row, $reserva['people']);
    $sheet->setCellValue('C' . $row, $reserva['price']);
    $sheet->setCellValue('D' . $row, $reserva['start_date']);
    $sheet->setCellValue('E' . $row, $reserva['end_date']);
    // Estilo de fila de datos
    $sheet->getStyle("A$row:E$row")->applyFromArray([
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]]
    ]);
    // Formato moneda para la columna Precio (C)
    $sheet->getStyle("C$row")->getNumberFormat()->setFormatCode('$ #,##0');
    $totalPrecio += $reserva['price'];
    $row++;
}

// Fila de resumen con total de precios
$sheet->setCellValue("A$row", "Total:");
$sheet->mergeCells("A$row:B$row");
$sheet->setCellValue("C$row", $totalPrecio);
$sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle("A$row:E$row")->applyFromArray([
    'font' => ['bold' => true],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'A7C957']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
]);
$sheet->getStyle("C$row")->getNumberFormat()->setFormatCode('$ #,##0');

// Autoajustar ancho de columnas y alto de filas
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$sheet->getRowDimension(1)->setRowHeight(30);
$sheet->getRowDimension(2)->setRowHeight(25);
$sheet->getRowDimension(4)->setRowHeight(20);

// Envío del archivo XLSX (limpieza de buffers)
if (ob_get_length()) { ob_end_clean(); }
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Reservas_Cumbre_Verde.xlsx"'); // Cambiar nombre de archivo aquí
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
