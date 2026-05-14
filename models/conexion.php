<?php

class conexion {
    private $mySQLI; //Objeto de la conexion a la base de datos.
    private $sql; // query a la base de datos 
    private $result; // Resultado de la query 
    private $filasAfectadas; // Numero de filas afectadas por la query 
    
    public function conectar(){
        $host = 'localhost';
        $db = 'paginaweb';
        $user = 'root';
        $password = '';
        $this->mySQLI=new mysqli($host,$user,$password,$db);
            if(mysqli_connect_error()){
                //Manejo simple de error de conexion, sin imprimir en vistas 
                throw new Exception('Error de conexion de la base de datos');
            }
    }

    public function deconectar(){
        $this->mySQLI->close();
    }

    public function query($sql){
        $this->sql = $sql;
        $this->result = $this->mySQLI->query($sql);
        $this->filasAfectadas = $this->mySQLI->affected_rows;
    }

    public function getResult(){
        return $this->result;
    }

    public function getFilasAfectadas(){
        return $this->filasAfectadas;
    }
}
?>
