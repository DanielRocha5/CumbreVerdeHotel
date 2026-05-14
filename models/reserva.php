<?php
class Reserva
{
    public function getReservasPorUsuario($user_id)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT r.*, ro.room_number 
        FROM reservations r JOIN rooms ro ON r.room_id = ro.id WHERE r.user_id = '$user_id' AND r.status_id != 7";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->deconectar();
        return $result;
    }

    public function getTiposHabitacion()
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT id, name FROM room_types ORDER BY id ASC";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->deconectar();
        return $result;
    }

    public function getHabitaciones()
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT id, room_number FROM rooms ORDER BY id ASC";
        $conexion->query($sql);
        $result = $conexion->getResult();
        $conexion->deconectar();
        return $result;
    }

    public function guardarReserva($data)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "INSERT INTO reservations (user_id, room_id, start_date, end_date, people, price, status_id)
        VALUES ('$data[user_id]', '$data[room_id]', '$data[fechaInicio]', '$data[fechaFin]', '$data[people]', '$data[price]', 6)";
        $conexion->query($sql);
        $filas = $conexion->getFilasAfectadas();
        $conexion->deconectar();
        return $filas;
    }

    public function getPeopleByRoom($room_id)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT max_people, price FROM rooms WHERE id = '$room_id'";
        $conexion->query($sql);
        $result = $conexion->getResult()->fetch_assoc();
        $conexion->deconectar();
        return $result;
    }

    public function cancelarReserva($reserva_id, $user_id)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "UPDATE reservations SET status_id = 7 WHERE id = '$reserva_id' AND user_id = '$user_id'";
        $conexion->query($sql);
        $filas = $conexion->getFilasAfectadas();
        $conexion->deconectar();
        return $filas;
    }

    public function getReservaById($reserva_id, $user_id)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT r.*, ro.room_number, ro.room_type_id 
            FROM reservations r 
            JOIN rooms ro ON r.room_id = ro.id 
            WHERE r.id = '$reserva_id' AND r.user_id = '$user_id'";
        $conexion->query($sql);
        $result = $conexion->getResult()->fetch_assoc();
        $conexion->deconectar();
        return $result;
    }

    public function actualizarReserva($data)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "UPDATE reservations 
            SET room_id = '$data[room_id]', 
                start_date = '$data[fechaInicio]', 
                end_date = '$data[fechaFin]', 
                people = '$data[people]', 
                price = '$data[price]'
            WHERE id = '$data[reserva_id]' AND user_id = '$data[user_id]'";
        $conexion->query($sql);
        $filas = $conexion->getFilasAfectadas();
        $conexion->deconectar();
        return $filas;
    }
}
