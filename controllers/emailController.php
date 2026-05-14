<?php
class EnviarEmail
{
    public function enviarEmail()
    {
        require_once 'report/enviarEmail.php';
        enviarCorreo($_SESSION['user']['email'], $_SESSION['user']['name']);
    }
}