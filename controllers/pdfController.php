<?php
class PdfController
{
    public function pdfReserva()
    {
        if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
            header('location: ' . SITE_URL . 'index.php?action=verHabitaciones');
            exit;
        }

        $reportModel = new ReportPdf();
        $datos = $reportModel->getReservaConUsuario($_GET['id'], $_SESSION['user']['id']);

        if (!$datos) {
            header('location: ' . SITE_URL . 'index.php?action=verHabitaciones');
            exit;
        }

        require_once 'report/enviarPdf.php';
    }
}