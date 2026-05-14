<?php
class ReservaController
{
    public function guardarReserva($datos)
    {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);

        $errores = [];

        if (empty($datos['room_id'] ?? '')) {
            $errores['room_id'] = '* Selecciona una habitación.';
        }
        if (empty($datos['fechaInicio'] ?? '')) {
            $errores['fechaInicio'] = '* La fecha de inicio es obligatoria.';
        }
        if (empty($datos['fechaFin'] ?? '')) {
            $errores['fechaFin'] = '* La fecha de fin es obligatoria.';
        }

        if (count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('location: ' . SITE_URL . 'index.php?action=crearReservas');
            exit;
        }

        $datos['user_id'] = $_SESSION['user']['id'];

        $reservaModel = new Reserva();
        $infoRoom = $reservaModel->getPeopleByRoom($datos['room_id']);
        $dias = (strtotime($datos['fechaFin']) - strtotime($datos['fechaInicio'])) / 86400;
        $datos['price'] = $infoRoom['price'] * $datos['people'] * $dias;

        $reserva = new Reserva();
        $resultado = $reserva->guardarReserva($datos);

        if ($resultado > 0) {
            $controllerEmail = new EnviarEmail();
            $controllerEmail->enviarEmail();
            $_SESSION['success'] = "* Reserva creada exitosamente.";
            header('location: ' . SITE_URL . 'index.php?action=verHabitaciones');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => '* Error al guardar la reserva. Intentalo de nuevo.'];
            $_SESSION['old'] = $datos;
            header('location: ' . SITE_URL . 'index.php?action=crearReservas');
            exit;
        }
    }

    public function getRoomsByType()
    {
        header('Content-Type: application/json; charset=utf-8');

        $tipoHabitacionId = isset($_GET['type_room_id']) ? (int) $_GET['type_room_id'] : 0;
        $habitaciones = [];

        try {
            $conexion = new Conexion();
            $conexion->conectar();
            $sql = "SELECT id, room_number FROM rooms WHERE room_type_id = $tipoHabitacionId";
            $conexion->query($sql);
            $resultado = $conexion->getResult();

            if (!$resultado) {
                throw new Exception('Query falló: ' . $tipoHabitacionId);
            }

            while ($fila = $resultado->fetch_assoc()) {
                $habitaciones[] = $fila;
            }
            $conexion->deconectar();

            echo json_encode([
                'ok' => true,
                'data' => $habitaciones
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'ok' => false,
                'message' => 'Error al consultar habitaciones',
                'data' => []
            ]);
        }
    }

    public function getPeopleByRoom()
    {
        if (isset($_GET['room_id'])) {
            $room_id = $_GET['room_id'];

            $reservaModel = new Reserva();
            $data = $reservaModel->getPeopleByRoom($room_id);

            echo json_encode([
                "data" => $data
            ]);
        }
    }

    public function cancelarReserva()
    {
        if (!isset($_SESSION['user'])) {
            header('location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        $reserva_id = $_GET['id'] ?? 0;
        $user_id = $_SESSION['user']['id'];

        $reservaModel = new Reserva();
        $resultado = $reservaModel->cancelarReserva($reserva_id, $user_id);

        if ($resultado > 0) {
            $_SESSION['success'] = "* Reserva cancelada exitosamente.";
        } else {
            $_SESSION['errors']['general'] = "* No se pudo cancelar la reserva.";
        }

        header('location: ' . SITE_URL . 'index.php?action=verHabitaciones');
        exit;
    }
    public function editarReserva()
    {
        if (!isset($_SESSION['user'])) {
            header('location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
            exit;
        }

        $reserva_id = $_GET['id'] ?? 0;
        $user_id = $_SESSION['user']['id'];

        $reservaModel = new Reserva();
        $_SESSION['editando'] = $reservaModel->getReservaById($reserva_id, $user_id);

        if (!$_SESSION['editando']) {
            header('location: ' . SITE_URL . 'index.php?action=verHabitaciones');
            exit;
        }

        include_once 'views/html/dashboard/new_reservation.php';
    }

    public function actualizarReserva($datos)
    {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);

        $errores = [];
        if (empty($datos['room_id'] ?? '')) {
            $errores['room_id'] = '* Selecciona una habitación.';
        }
        if (empty($datos['fechaInicio'] ?? '')) {
            $errores['fechaInicio'] = '* La fecha de inicio es obligatoria.';
        }
        if (empty($datos['fechaFin'] ?? '')) {
            $errores['fechaFin'] = '* La fecha de fin es obligatoria.';
        }

        if (count($errores) > 0) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('location: ' . SITE_URL . 'index.php?action=editarReserva&id=' . $datos['reserva_id']);
            exit;
        }

        $datos['user_id'] = $_SESSION['user']['id'];

        $reservaModel = new Reserva();
        $infoRoom = $reservaModel->getPeopleByRoom($datos['room_id']);
        $dias = (strtotime($datos['fechaFin']) - strtotime($datos['fechaInicio'])) / 86400;
        $datos['price'] = $infoRoom['price'] * $datos['people'] * $dias;

        $resultado = $reservaModel->actualizarReserva($datos);

        if ($resultado > 0) {
            unset($_SESSION['editando']);
            $_SESSION['success'] = "* Reserva actualizada exitosamente.";
            header('location: ' . SITE_URL . 'index.php?action=verHabitaciones');
            exit;
        } else {
            $_SESSION['errors']['general'] = "* Error al actualizar. Intentalo de nuevo.";
            $_SESSION['old'] = $datos;
            header('location: ' . SITE_URL . 'index.php?action=editarReserva&id=' . $datos['reserva_id']);
            exit;
        }
    }
}
