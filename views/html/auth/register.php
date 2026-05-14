<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Verde | Registrarse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>css/styleUser.css">
</head>
<body>
    <div class="Contenedor">
        <h1>Crear Cuenta</h1>
 
        <?php if(isset($_SESSION['errors']['general'])){ ?>
            <span class="error-msg"><?php echo $_SESSION['errors']['general']; ?></span>
        <?php } ?>
 
        <form action="<?php echo SITE_URL; ?>index.php?action=registerUser" method="post">
 
            <div class="row-grid mt-12">
                <div class="col-field">
                    <label>Tipo de Documento</label>
                    <select class="input-warp" name="document_type_id">
                        <option class="xd" value="">Seleccionar...</option>
                        <?php
                        $conexionReg = new Conexion();
                        $conexionReg->conectar();
                        $conexionReg->query("SELECT id, name FROM document_types ORDER BY id ASC");
                        $tiposDoc = $conexionReg->getResult();
                        $conexionReg->deconectar();
 
                        if($tiposDoc && $tiposDoc->num_rows > 0):
                            while($tipo = $tiposDoc->fetch_assoc()):
                                $selected = (isset($_SESSION['old']['document_type_id']) && $_SESSION['old']['document_type_id'] == $tipo['id']) ? 'selected' : '';
                        ?>
                            <option class="xd" value="<?php echo $tipo['id']; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($tipo['name']); ?>
                            </option>
                        <?php
                            endwhile;
                        endif;
                        ?>
                    </select>
                    <?php if(isset($_SESSION['errors']['document_type_id'])){ ?>
                        <span><?php echo $_SESSION['errors']['document_type_id']; ?></span>
                    <?php } ?>
                </div>
 
                <div class="col-field">
                    <label>Número de Documento</label>
                    <input type="text" name="document_number"
                        value="<?php echo isset($_SESSION['old']['document_number']) ? $_SESSION['old']['document_number'] : ''; ?>"
                        placeholder="Ej: 1110501182">
                    <?php if(isset($_SESSION['errors']['document_number'])){ ?>
                        <span><?php echo $_SESSION['errors']['document_number']; ?></span>
                    <?php } ?>
                </div>
            </div>
 
            <div class="row-grid mt-12">
                <div class="col-field">
                    <label>Nombre</label>
                    <input type="text" name="name"
                        value="<?php echo isset($_SESSION['old']['name']) ? $_SESSION['old']['name'] : ''; ?>"
                        placeholder="Tu nombre">
                    <?php if(isset($_SESSION['errors']['name'])){ ?>
                        <span><?php echo $_SESSION['errors']['name']; ?></span>
                    <?php } ?>
                </div>
 
                <div class="col-field">
                    <label>Apellido</label>
                    <input type="text" name="last_name"
                        value="<?php echo isset($_SESSION['old']['last_name']) ? $_SESSION['old']['last_name'] : ''; ?>"
                        placeholder="Tu apellido">
                    <?php if(isset($_SESSION['errors']['last_name'])){ ?>
                        <span><?php echo $_SESSION['errors']['last_name']; ?></span>
                    <?php } ?>
                </div>
            </div>
 
            <label>Correo Electrónico</label>
            <input type="text" name="email"
                value="<?php echo isset($_SESSION['old']['email']) ? $_SESSION['old']['email'] : ''; ?>"
                placeholder="correo@ejemplo.com">
            <?php if(isset($_SESSION['errors']['email'])){ ?>
                <span><?php echo $_SESSION['errors']['email']; ?></span>
            <?php } ?>
 
            <div class="row-grid mt-12">
                <div class="col-field">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••">
                    <?php if(isset($_SESSION['errors']['password'])){ ?>
                        <span><?php echo $_SESSION['errors']['password']; ?></span>
                    <?php } ?>
                </div>
 
                <div class="col-field">
                    <label>Verificar Contraseña</label>
                    <input type="password" name="password_verify" placeholder="••••••••">
                    <?php if(isset($_SESSION['errors']['password_verify'])){ ?>
                        <span><?php echo $_SESSION['errors']['password_verify']; ?></span>
                    <?php } ?>
                </div>
            </div>
 
            <button type="submit" name="submit">Registrar</button>
        </form>
 
        <p class="auth-footer">
            ¿Ya tienes cuenta?
            <a href="<?php echo SITE_URL; ?>index.php?action=getFormLoginUser">Inicia Sesión</a>
        </p>
    </div>
</body>
</html>
