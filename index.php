<?php
session_start();

require_once 'config/config.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ReservaController.php';
require_once 'models/conexion.php';
require_once 'models/user.php';
require_once 'models/reserva.php';
require_once 'controllers/pdfController.php';
require_once 'controllers/emailController.php';
require_once 'controllers/excelController.php';
require_once 'models/reportPdf.php';

$controllerBase = new AuthController();
$controllerReserva = new ReservaController();
$controllerPdf   = new PdfController();
$controllerEmail = new EnviarEmail();
$controllerExcel = new EnviarExcel();

if (!isset($_GET['action'])) {
    $controllerBase->verPaginaDeInicio('views/html/home.php');

} elseif ($_GET['action'] == 'getFormRegisterUser') {
    if (!isset($_SESSION['errors']) && !isset($_SESSION['old'])) {
        unset($_SESSION['old']);
        unset($_SESSION['errors']);
    }
    $controllerBase->verPaginaDeInicio('views/html/auth/register.php');

} elseif ($_GET['action'] == 'registerUser') {
    $controllerBase->registerUser($_POST);

} elseif ($_GET['action'] == 'getFormLoginUser') {
    $controllerBase->verPaginaDeInicio('views/html/auth/login.php');

} elseif ($_GET['action'] == 'loginUser') {
    $controllerBase->loginUser($_POST);

} elseif ($_GET['action'] == 'logoutUser') {
    $controllerBase->logoutUser();

} elseif ($_GET['action'] == 'verHabitaciones') {
    $controllerBase->verPaginaDeInicio('views/html/dashboard/room.php');

} elseif ($_GET['action'] == 'crearReservas') {
    $controllerBase->verPaginaDeInicio('views/html/dashboard/new_reservation.php');

} elseif ($_GET['action'] == 'guardarReserva') {
    $controllerReserva->guardarReserva($_POST);

} elseif ($_GET['action'] == 'getRoomsByType') {
    $controllerReserva->getRoomsByType();

} elseif ($_GET['action'] == 'getPeopleByRoom') {
    $controllerReserva->getPeopleByRoom();

} elseif ($_GET['action'] == 'cancelarReserva') {
    $controllerReserva->cancelarReserva();

} elseif ($_GET['action'] == 'editarReserva') {
    $controllerReserva->editarReserva();

} elseif ($_GET['action'] == 'actualizarReserva') {
    $controllerReserva->actualizarReserva($_POST);

} elseif ($_GET['action'] == 'pdfReserva') {
    $controllerPdf->pdfReserva();
} elseif ($_GET['action'] == 'enviarEmail'){
    $controllerEmail->enviarEmail();
}elseif ($_GET['action'] == 'enviarExcel'){
    $controllerExcel->enviarExcel();
}
