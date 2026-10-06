<?php
namespace App\Controladores;

use App\Conexion\Conexion;
use App\Modelos\Pedido;
use PDO;

class PedidoController {
    private $db;

    public function __construct() {
        $conexion = new Conexion();
        $this->db = $conexion->conectar();
    }

    // LISTAR
    public function obtenerPedidos() {
        $query = "SELECT * FROM pedidos ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CREAR
    public function crearPedido(Pedido $pedido, $cliente, $contacto, $tipo_postre, $fecha_entrega) {
        $query = "INSERT INTO pedidos (cliente, contacto, tipo_postre, estado, fecha_entrega) VALUES (:cliente, :contacto, :tipo_postre, :estado, :fecha_entrega)";
        $stmt = $this->db->prepare($query);
        
        $estado = 'Pendiente';
        $stmt->bindParam(':cliente', $cliente);
        $stmt->bindParam(':contacto', $contacto);
        $stmt->bindParam(':tipo_postre', $tipo_postre);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':fecha_entrega', $fecha_entrega);
        return $stmt->execute();
    }

    // EDITAR (Actualizar estado)
    public function actualizarEstado($id, $nuevoEstado) {
        $query = "UPDATE pedidos SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':estado', $nuevoEstado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // ELIMINAR
    public function eliminarPedido($id) {
        $query = "DELETE FROM pedidos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}