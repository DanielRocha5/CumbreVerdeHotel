<?php
class User{
    public function validateUser($data){
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT * FROM users WHERE email = '$data[email]'";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->deconectar();
        if($result->num_rows > 0){
            return 1;
        }
        return 0;
    }
 
    public function validateDocumentNumber($data){
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT * FROM users WHERE document_number = '$data[document_number]'";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->deconectar();
        if($result->num_rows > 0){
            return 1;
        }
        return 0;
    }
 
    public function registerUser($data){
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "INSERT INTO users (document_type_id, document_number, name, last_name, email, password)
        VALUES ('$data[document_type_id]', '$data[document_number]', '$data[name]', '$data[last_name]', '$data[email]', '$data[password]')";
        $conexion->query($sql);
        $filas = $conexion->getFilasAfectadas();
        $conexion->deconectar();
        return $filas;
    }
 
    public function loginUser($data){
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT * FROM users WHERE email = '$data[email]'";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->deconectar();
        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            if(password_verify($data['password'], $user['password'])){
                return $user;
            }
        }
        return false;
    }
}
?>
