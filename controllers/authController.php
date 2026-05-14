<?php
class AuthController{
    public function verPaginaDeInicio($pagina){
        include_once $pagina;
    }
 
    public function logoutUser(){
        session_destroy();
        header('location: '.SITE_URL.'index.php');
        exit;
    }
 
    public function registerUser($datos){
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);
 
        $errores = $this->validateData($datos);
        if(count($errores) > 0){
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('location: '.SITE_URL.'index.php?action=getFormRegisterUser');
            exit;
        }
 
        $user = new User();
 
        $existeEmail = $user->validateUser($datos);
        if($existeEmail > 0){
            $_SESSION['errors'] = ['general' => '* El correo ya está registrado.'];
            $_SESSION['old'] = $datos;
            header('location: '.SITE_URL.'index.php?action=getFormRegisterUser');
            exit;
        }
 
        $existeDoc = $user->validateDocumentNumber($datos);
        if($existeDoc > 0){
            $_SESSION['errors'] = ['general' => '* El número de documento ya está registrado.'];
            $_SESSION['old'] = $datos;
            header('location: '.SITE_URL.'index.php?action=getFormRegisterUser');
            exit;
        }
 
        $password = password_hash($datos['password'], PASSWORD_DEFAULT);
        $datos['password'] = $password;
 
        $resultado = $user->registerUser($datos);
        if($resultado > 0){
            $_SESSION['success'] = "* Usuario Registrado Exitosamente";
            unset($_SESSION['old']);
            header('location: '.SITE_URL.'index.php?action=getFormLoginUser');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => '* Error al registrar el usuario. Intentalo de nuevo.'];
            $_SESSION['old'] = $datos;
            header('location: '.SITE_URL.'index.php?action=getFormRegisterUser');
            exit;
        }
    }
 
    public function loginUser($datos){
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);
 
        $errores = [];
 
        if(empty(trim($datos['email'] ?? ''))){
            $errores['email'] = '* El correo es obligatorio.';
        } elseif(!strpos($datos['email'], '@')){
            $errores['email'] = '* El correo debe contener @.';
        } elseif(!strpos($datos['email'], '.')){
            $errores['email'] = '* El correo debe contener un punto.';
        }
 
        if(empty($datos['password'] ?? '')){
            $errores['password'] = '* La contraseña es requerida.';
        }
 
        if(count($errores) > 0){
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            header('location: '.SITE_URL.'index.php?action=getFormLoginUser');
            exit;
        }
 
        $user = new User();
        $resultado = $user->loginUser($datos);
 
        if($resultado){
            $_SESSION['user'] = $resultado;
            header('location: '.SITE_URL.'index.php');
            exit;
        } else {
            $_SESSION['errors'] = ['general' => '* El correo o la contraseña son incorrectos.'];
            $_SESSION['old'] = $datos;
            header('location: '.SITE_URL.'index.php?action=getFormLoginUser');
            exit;
        }
    }
 
    public function validateData($datos){
        $errores = [];
 
        if(empty($datos['document_type_id'] ?? '')){
            $errores['document_type_id'] = '* Selecciona un tipo de documento.';
        }
 
        if(empty(trim($datos['document_number'] ?? ''))){
            $errores['document_number'] = '* El número de documento es obligatorio.';
        } elseif(!ctype_digit($datos['document_number'])){
            $errores['document_number'] = '* El número de documento solo debe contener dígitos.';
        }
 
        if(empty(trim($datos['name'] ?? ''))){
            $errores['name'] = '* El nombre es obligatorio.';
        }
 
        if(empty(trim($datos['last_name'] ?? ''))){
            $errores['last_name'] = '* El apellido es obligatorio.';
        }
 
        if(empty(trim($datos['email'] ?? ''))){
            $errores['email'] = '* El correo es obligatorio.';
        } elseif(!strpos($datos['email'], '@')){
            $errores['email'] = '* El correo debe contener @.';
        } elseif(!strpos($datos['email'], '.')){
            $errores['email'] = '* El correo debe contener un punto.';
        }
 
        if(empty($datos['password'] ?? '')){
            $errores['password'] = '* La contraseña es obligatoria.';
        } else {
            $pass = $datos['password'];
            if(strlen($pass) < 6){
                $errores['password'] = '* La contraseña debe tener al menos 6 caracteres.';
            } elseif(!preg_match('/[a-z]/', $pass)){
                $errores['password'] = '* La contraseña debe tener al menos una letra minúscula.';
            } elseif(!preg_match('/[A-Z]/', $pass)){
                $errores['password'] = '* La contraseña debe tener al menos una letra mayúscula.';
            } elseif(!preg_match('/[^a-zA-Z0-9]/', $pass)){
                $errores['password'] = '* La contraseña debe tener al menos un carácter especial.';
            }
        }
 
        if(empty($datos['password_verify'] ?? '')){
            $errores['password_verify'] = '* Debes verificar la contraseña.';
        } elseif(($datos['password'] ?? '') !== ($datos['password_verify'] ?? '')){
            $errores['password_verify'] = '* Las contraseñas no coinciden.';
        }
 
        return $errores;
    }
}
?>
