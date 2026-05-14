<?php
class ReportPdf
{
    public function getReservaConUsuario($reserva_id, $user_id)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $sql = "SELECT r.*, ro.room_number, rt.name AS tipo_hab,
                       u.name AS user_name, u.last_name, u.email, u.document_number
                FROM reservations r
                JOIN rooms ro ON r.room_id = ro.id
                JOIN room_types rt ON ro.room_type_id = rt.id
                JOIN users u ON r.user_id = u.id
                WHERE r.id = '$reserva_id' AND r.user_id = '$user_id'";
        $conexion->query($sql);
        $result = $conexion->getResult()->fetch_assoc();
        $conexion->deconectar();
        return $result;
    }
}