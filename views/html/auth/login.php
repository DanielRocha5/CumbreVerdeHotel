<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Verde | Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>css/styleUser.css">
</head>
<body>
    <div class="Contenedor">
        <h1>Bienvenido</h1>

        <?php if(isset($_SESSION['errors']['general'])){ ?>
            <span class="error-msg"><?php echo $_SESSION['errors']['general']; ?></span>
        <?php } ?>

        <?php if(isset($_SESSION['success'])){ ?>
            <span class="success-msg"><?php echo $_SESSION['success']; ?></span>
        <?php } ?>

        <form action="<?php echo SITE_URL; ?>index.php?action=loginUser" method="post">
            <label>Correo Electrónico</label>
            <input type="text" name="email" value="<?php echo isset($_SESSION['old']['email']) ? $_SESSION['old']['email'] : ''; ?>" placeholder="ejemplo@hotel.com">
            <?php if(isset($_SESSION['errors']['email'])){ ?>
                <span><?php echo $_SESSION['errors']['email']; ?></span>
            <?php } ?>

            <label>Contraseña</label>
            <input type="password" name="password" placeholder="••••••••">
            <?php if(isset($_SESSION['errors']['password'])){ ?>
                <span><?php echo $_SESSION['errors']['password']; ?></span>
            <?php } ?>

            <button type="submit" name="submit">Ingresar</button>
        </form>

        <p class="auth-footer">
            ¿No tienes cuenta? 
            <a href="<?php echo SITE_URL; ?>index.php?action=getFormRegisterUser">Regístrate</a>
        </p>
    </div>
</body>
</html>
