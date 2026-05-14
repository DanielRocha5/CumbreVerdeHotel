<?php
if (!isset($_SESSION['user'])) {
    header('location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
    exit;
}

$reserva = $_SESSION['editando'] ?? null;
$editando = $reserva !== null;

if (isset($_SESSION['old']['fechaInicio'])) {
    $valorInicio = $_SESSION['old']['fechaInicio'];
} elseif ($editando) {
    $valorInicio = $reserva['start_date'];
} else {
    $valorInicio = '';
}

if (isset($_SESSION['old']['fechaFin'])) {
    $valorFin = $_SESSION['old']['fechaFin'];
} elseif ($editando) {
    $valorFin = $reserva['end_date'];
} else {
    $valorFin = '';
}

$hoy    = date('Y-m-d');
$manana = date('Y-m-d', time() + 86400);

$reservaModel = new Reserva();
$tiposHab = $reservaModel->getTiposHabitacion();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Verde | Nueva Reserva</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styleHab.css">
</head>

<body>

    <nav class="top-nav">
        <div class="nav-container">
            <div class="nav-links">
                <a href="index.php#inicio">INICIO</a>
                <a href="index.php?action=verHabitaciones">MIS RESERVAS</a>
            </div>
            <div class="nav-auth">
                <a href="index.php?action=logoutUser" class="auth-logout">CERRAR SESIÓN</a>
            </div>
        </div>
    </nav>

    <div class="rooms-container">

        <h1><?php echo $editando ? 'Editar reserva' : 'Nueva reserva'; ?></h1>
        <p>Selecciona tu habitacion y fecha de estadia</p>
        <br>
        <hr class="divider">
        <br><br>

        <?php if (isset($_SESSION['errors']['general'])) { ?>
            <p class="error-msg-general"><?php echo $_SESSION['errors']['general']; ?></p>
        <?php } ?>

        <form action="index.php?action=<?php echo $editando ? 'actualizarReserva' : 'guardarReserva'; ?>" method="post">

            <?php if ($editando) { ?>
                <input type="hidden" name="reserva_id" value="<?php echo $reserva['id']; ?>">
            <?php } ?>

            <h3>Selecciona el tipo de habitacion:</h3>
            <select class="option_room" name="room_type_id" id="tipo_habitacion">

                <option class="xdo" disabled <?php echo !$editando ? 'selected' : ''; ?>>
                    Seleccionar...
                </option>

                <?php if ($tiposHab && $tiposHab->num_rows > 0) { ?>
                    <?php while ($tipo = $tiposHab->fetch_assoc()) { ?>

                        <?php
                        $seleccionado = '';

                        if (isset($_SESSION['old']['room_type_id']) && $_SESSION['old']['room_type_id'] == $tipo['id']) {
                            $seleccionado = 'selected';
                        } elseif ($editando && $reserva['room_type_id'] == $tipo['id']) {
                            $seleccionado = 'selected';
                        }
                        ?>

                        <option class="xdo" value="<?php echo $tipo['id']; ?>" <?php echo $seleccionado; ?>>
                            <?php echo htmlspecialchars($tipo['name']); ?>
                        </option>

                    <?php } ?>
                <?php } ?>

            </select>

            <?php if (isset($_SESSION['errors']['room_type_id'])) { ?>
                <span class="error-msg"><?php echo $_SESSION['errors']['room_type_id']; ?></span>
            <?php } ?>

            <h3>Selecciona la habitacion:</h3>
            <select class="rooms" name="room_id" id="numero_habitacion">

                <?php if ($editando) { ?>
                    <option class="xdo" value="<?php echo $reserva['room_id']; ?>" selected>
                        Habitacion <?php echo $reserva['room_number']; ?>
                    </option>
                <?php } else { ?>
                    <option class="xdo">Seleccionar...</option>
                <?php } ?>

            </select>

            <?php if (isset($_SESSION['errors']['room_id'])) { ?>
                <span class="error-msg"><?php echo $_SESSION['errors']['room_id']; ?></span>
            <?php } ?>

            <h3>Selecciona la cantidad de personas:</h3>
            <select class="rooms" name="people" id="personas">
                <option class="xdo" disabled selected>Seleccionar...</option>
            </select>

            <br><br>
            <h3>Selecciona La fecha de tu estadia:</h3>
            <br>

            <p>Fecha inicio:</p>
            <input type="date" name="fechaInicio" min="<?php echo $hoy; ?>" value="<?php echo $valorInicio; ?>">

            <?php if (isset($_SESSION['errors']['fechaInicio'])) { ?>
                <span class="error-msg"><?php echo $_SESSION['errors']['fechaInicio']; ?></span>
            <?php } ?>

            <p>Fecha Fin:</p>
            <input type="date" name="fechaFin" min="<?php echo $manana; ?>" value="<?php echo $valorFin; ?>">

            <?php if (isset($_SESSION['errors']['fechaFin'])) { ?>
                <span class="error-msg"><?php echo $_SESSION['errors']['fechaFin']; ?></span>
            <?php } ?>

            <h3>Precio por noche:</h3>
            <p id="precio_texto">$0</p>

            <h3>Precio Total:</h3>
            <p id="precio_total">$0</p>

            <br>
            <input type="submit" class="reservar" value="<?php echo $editando ? 'Actualizar' : 'Reservar'; ?>">

        </form>
    </div>

    <script>
        let tipo_habitacion = document.getElementById("tipo_habitacion");
        let numero_habitacion = document.getElementById("numero_habitacion");

        tipo_habitacion.addEventListener("change", async () => {
            try {
                const response = await fetch(`index.php?action=getRoomsByType&type_room_id=${tipo_habitacion.value}`);
                const result = await response.json();
                const habitaciones = result.data;

                numero_habitacion.innerHTML = '<option value="" selected disabled>Seleccione una habitacion</option>';

                habitaciones.forEach((habitacion) => {
                    numero_habitacion.innerHTML += `<option style="background:#1a1a1a; color:#ffffff;" value="${habitacion.id}">Habitacion ${habitacion.room_number}</option>`;
                });
            } catch (error) {
                console.log("fallo");
            }
        });
    </script>

    <script>
        let personas = document.getElementById("personas");
        let precioTexto = document.getElementById("precio_texto");
        let precioBase = 0;

        document.addEventListener("change", async (e) => {

            if (e.target.id === "numero_habitacion") {
                const roomId = e.target.value;
                const response = await fetch(`index.php?action=getPeopleByRoom&room_id=${roomId}`);
                const result = await response.json();
                const maxPersonas = result.data.max_people;
                precioBase = parseInt(result.data.price);

                personas.innerHTML = '<option style="background:#1a1a1a; color:#ffffff;" disabled selected>Seleccionar...</option>';

                for (let i = 1; i <= maxPersonas; i++) {
                    let sel = <?php echo $editando ? 'i === ' . $reserva['people'] . ' ? "selected" : ""' : '""'; ?>;
                    personas.innerHTML += `<option style="background:#1a1a1a; color:#ffffff;" value="${i}" ${sel}>${i} personas</option>`;
                }

                precioTexto.innerHTML = `$${precioBase}`;
                calcular();
            }

            if (e.target.id === "personas") {
                const cantidad = parseInt(e.target.value);

                if (!isNaN(cantidad)) {
                    precioTexto.innerHTML = `$${precioBase * cantidad}`;
                    calcular();
                }
            }
        });

        <?php if ($editando) { ?>
                (async () => {
                    const response = await fetch(`index.php?action=getPeopleByRoom&room_id=<?php echo $reserva['room_id']; ?>`);
                    const result = await response.json();
                    precioBase = parseInt(result.data.price);
                    const maxPersonas = result.data.max_people;

                    personas.innerHTML += `<option style="background:#1a1a1a; color:#ffffff;" value="${i}" ${sel}>${i} personas</option>`;

                    for (let i = 1; i <= maxPersonas; i++) {
                        let sel = i === <?php echo $reserva['people']; ?> ? 'selected' : '';
                        personas.innerHTML += `<option style="background:#1a1a1a; color:#ffffff;" value="${i}" ${sel}>${i} personas</option>`;
                    }

                    precioTexto.innerHTML = `$${precioBase * <?php echo $reserva['people']; ?>}`;
                    calcular();
                })();
        <?php } ?>
    </script>

    <script>
        let inicio = document.querySelector('input[name="fechaInicio"]');
        let fin = document.querySelector('input[name="fechaFin"]');
        let totalTexto = document.getElementById("precio_total");

        function calcular() {
            if (!inicio.value) return;
            if (!fin.value) return;
            if (precioBase === 0) return;

            let dias = (new Date(fin.value) - new Date(inicio.value)) / 86400000;
            let cantPersonas = parseInt(personas.value) || 1;

            if (dias > 0) {
                totalTexto.innerHTML = "$" + (dias * precioBase * cantPersonas);
            } else {
                totalTexto.innerHTML = "$0";
            }
        }

        inicio.addEventListener("change", calcular);
        fin.addEventListener("change", calcular);
        personas.addEventListener("change", calcular);

        <?php if ($editando) { ?>
            window.addEventListener("load", calcular);
        <?php } ?>
    </script>

</body>

</html>