<?php
if (!isset($_SESSION['user'])) {
    header('location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
    exit;
}

$nombreUsuario   = htmlspecialchars($_SESSION['user']['name']);
$apellidoUsuario = htmlspecialchars($_SESSION['user']['last_name']);

$reservaModel = new Reserva();
$reservas = $reservaModel->getReservasPorUsuario($_SESSION['user']['id']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Verde | Habitaciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>css/styleHab.css">
</head>

<body>

    <nav class="top-nav">
        <div class="nav-container">
            <div class="nav-links">
                <a href="<?php echo SITE_URL; ?>index.php#inicio">INICIO</a>
                <a href="<?php echo SITE_URL; ?>index.php#experiencias">EXPERIENCIAS</a>
                <a href="<?php echo SITE_URL; ?>index.php#habitaciones">SUITES</a>
                <a href="<?php echo SITE_URL; ?>index.php?action=verHabitaciones">HABITACIONES</a>
            </div>
            <div class="nav-auth">
                <a href="<?php echo SITE_URL; ?>index.php?action=logoutUser" class="auth-logout">CERRAR SESIÓN</a>
            </div>
        </div>
    </nav>

    <div class="rooms-container">

        <p class="bienvenida-user">Bienvenido, <span><?php echo $nombreUsuario . ' ' . $apellidoUsuario; ?></span></p>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success-msg"><?php echo $_SESSION['success'];
                                    unset($_SESSION['success']); ?></p>
        <?php } ?>

        <div class="header-reservas">
            <span class="section-title">Tus reservas</span>
            <a href="<?php echo SITE_URL; ?>index.php?action=enviarExcel" class="btn_excel">
                <img src="<?php echo SITE_URL; ?>img/excel.png" alt="Excel" width="30">
            </a>
        </div>

        <?php if ($reservas && $reservas->num_rows > 0) { ?>
            <table class="tabla_reservas">
                <thead>
                    <tr>
                        <th>Habitacion</th>
                        <th>Personas</th>
                        <th>Precio</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($reserva = $reservas->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reserva['room_number']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['people']); ?></td>
                            <td>$<?php echo number_format($reserva['price'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($reserva['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['end_date']); ?></td>
                            <td class="acciones">
                                <a href="index.php?action=editarReserva&id=<?php echo $reserva['id']; ?>" class="btn-editar" title="Editar">✏️</a>
                                <a href="<?php echo SITE_URL; ?>index.php?action=cancelarReserva&id=<?php echo $reserva['id']; ?>" class="btn-eliminar" title="Cancelar reserva" onclick="return confirm('¿Seguro que deseas cancelar esta reserva?')">🗑️</a>
                                <a href="<?php echo SITE_URL; ?>index.php?action=pdfReserva&id=<?php echo $reserva['id']; ?>" class="pdfReservas">
                                    <img src="<?php echo SITE_URL; ?>img/pdf.png" alt="PDF" width="30">
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="index.php?action=crearReservas" class="btn_reserva">+ Nueva Reserva</a>
        <?php } else { ?>
            <div class="no_reservas_container">
                <p class="no_reservas">No tienes reservas.</p>
                <a href="index.php?action=crearReservas" class="btn_reserva">+ Crear Reserva</a>
            </div>
        <?php } ?>

    </div>

</body>

</html>