<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel | Cumbre Verde</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
 
    <nav class="top-nav">
        <div class="nav-container">
            <div class="nav-links">
                <a href="#inicio">INICIO</a>
                <a href="#experiencias">EXPERIENCIAS</a>
                <a href="#habitaciones">SUITES</a>
 
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="<?php echo SITE_URL; ?>index.php?action=verHabitaciones" class="auth-room">HABITACIONES</a>
                <?php else: ?>
                    <a href="<?php echo SITE_URL; ?>index.php?action=getFormRegisterUser" class="auth-room">HABITACIONES</a>
                <?php endif; ?>
            </div>
            
            <div class="nav-auth">
                <?php if(isset($_SESSION['user'])): ?>
                    <span class="nav-username">Hola, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
                    <a href="<?php echo SITE_URL; ?>index.php?action=logoutUser" class="auth-logout">CERRAR SESIÓN</a>
                <?php else: ?>
                    <a href="<?php echo SITE_URL; ?>index.php?action=getFormLoginUser" class="auth-login">INICIAR SESIÓN</a>
                    <a href="<?php echo SITE_URL; ?>index.php?action=getFormRegisterUser" class="auth-register">CREAR CUENTA</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
 
    <header class="hero" id="inicio">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="brand-identity">
                <h1 class="brand-name">Hotel Cumbre Verde</h1>
                <p class="brand-tagline">COLOMBIA · EST. 2026</p>
            </div>
 
            <div class="hero-message">
                <p class="message-top">EL ARTE DE NO HACER NADA</p>
                <h2 class="message-main">Disfruta de una <span>profunda relajación</span> en el corazón de la naturaleza.</h2>
                <div class="scroll-indicator">
                    <span class="line"></span>
                    <span class="text">DESCUBRE MÁS</span>
                </div>
            </div>
        </div>
    </header>
 
    <main>
        <section class="intro-section" id="experiencias">
            <div class="container">
                <div class="intro-grid">
                    <div class="intro-text">
                        <span class="gold-label">EXPERIENCIA SENSORIAL</span>
                        <h3>Un refugio para el alma</h3>
                        <p>Hemos diseñado cada rincón de Hotel Verde pensando en tu bienestar. Desde nuestras sábanas de hilo egipcio hasta el murmullo del agua en nuestros jardines interiores, todo está dispuesto para que desconectes del mundo exterior.</p>
                        <a href="#" class="link-explore">EXPLORAR SERVICIOS →</a>
                    </div>
                    <div class="intro-visual">
                        <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1000&auto=format&fit=crop" alt="Spa Relax">
                    </div>
                </div>
            </div>
        </section>
 
        <section class="rooms-section" id="habitaciones">
            <div class="container">
                <div class="section-header">
                    <h2>Nuestras Suites</h2>
                </div>
                <div class="room-grid">
                    <div class="room-card">
                        <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=800" alt="Habitación">
                        <div class="room-info">
                            <h4>Deluxe Garden View</h4>
                            <p>Despierta con la vista de nuestros jardines verticales.</p>
                        </div>
                    </div>
                    <div class="room-card">
                        <img src="https://images.unsplash.com/photo-1591088398332-8a7791972843?q=80&w=800" alt="Habitación">
                        <div class="room-info">
                            <h4>Panoramic Suite</h4>
                            <p>La ciudad a tus pies con total privacidad.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
 
    <footer class="main-footer">
        <p>© 2026 HOTEL VERDE · TODOS LOS DERECHOS RESERVADOS POR ADSOSIOS</p>
    </footer>
 
</body>
</html>
