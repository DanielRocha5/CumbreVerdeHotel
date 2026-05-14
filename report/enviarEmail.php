<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo($emailUsuario,$nombreUsuario){
    $mail=new PHPMailer();

    try{
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->SMTPAuth=true;
        $mail->Username=$_ENV['MAIL_USER'];
        $mail->Password=$_ENV['MAIL_PASS'];
        $mail->SMTPSecure='tls';
        $mail->Port=587;

        $mail->setFrom('hotelcumbreverde@gmail.com','Hotel Cumbre Verde');
        $mail->addAddress($emailUsuario);
        $mail->Subject='Reservacion en Hotel Cumbre Verde';
        $mail->isHTML(true);

        $mail->AddEmbeddedImage(__DIR__.'/../img/logo.png','logoimg');

        $mail->Body="
<div style='background:#ffffff;padding:30px;font-family:Arial,sans-serif;'>
<div style='max-width:600px;margin:auto;background:#0a1a0e;border-radius:12px;overflow:hidden;'>

<div style='background:#050d07;padding:36px 32px;text-align:center;border-bottom:1px solid #1a3a1a;'>
<img src='cid:logoimg' width='150' style='display:block;margin:0 auto 14px;'>
<p style='margin:0;color:rgba(196,251,109,0.5);font-size:11px;letter-spacing:3px;'>COLOMBIA · EST. 2026</p>
</div>

<div style='height:2px;background:linear-gradient(to right,#0a1a0e,#b8860b,#c4fb6d,#b8860b,#0a1a0e);'></div>

<div style='padding:36px 40px;'>
<p style='font-size:11px;letter-spacing:3px;color:#b8860b;margin:0 0 12px;font-weight:bold;'>RESERVA CONFIRMADA</p>

<h2 style='margin:0 0 18px;font-size:20px;font-weight:400;color:#e8f5e8;font-family:Georgia,serif;'>¡Hola, {$nombreUsuario}!</h2>

<p style='font-size:14px;color:#a0c8a0;line-height:1.8;margin:0 0 20px;'>
Tu reserva está lista. Nos alegra mucho que hayas elegido <strong style='color:#c4fb6d;'>Hotel Cumbre Verde</strong> para tu próxima estadía. Prepárate para desconectarte del mundo y disfrutar de lo mejor de la naturaleza.
</p>

<p style='background:#0d2010;padding:14px 18px;border-left:3px solid #b8860b;margin:0 0 20px;font-size:13px;color:#d4a940;'>
📅 <b>Fecha de reserva:</b> ".date("d/m/Y")."
</p>

<p style='font-size:14px;color:#a0c8a0;line-height:1.8;margin:0 0 24px;'>
Si tienes alguna duda o quieres ver los detalles de tu reserva, puedes ingresar a tu cuenta cuando quieras. ¡Te esperamos con mucho gusto!
</p>

<hr style='border:none;border-top:1px solid #1a3a1a;margin:0 0 20px;'>

<p style='font-size:12px;color:#4a7a4a;text-align:center;margin:0;'>
Mensaje automático — por favor no responder a este correo.
</p>
</div>

<div style='background:#111111;text-align:center;padding:16px;border-top:1px solid #1a3a1a;'>
<p style='margin:0;font-size:12px;color:#555555;letter-spacing:1px;'>
© ".date("Y")." Hotel Cumbre Verde — Todos los derechos reservados
</p>
</div>

</div>
</div>";

        $mail->send();
        echo "Correo enviado correctamente";
    }catch(Exception $e){
        echo "Error al enviar: {$mail->ErrorInfo}";
    }
}