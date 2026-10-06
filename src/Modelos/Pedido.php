<?php
namespace App\Modelos;

class Pedido extends EntidadGeneral implements Procesable {
    private $cliente;
    private $contacto;
    private $tipo_postre;
    private $fecha_entrega;
    private $estado;

    public function __construct($cliente, $contacto, $tipo_postre, $fecha_entrega, $estado = 'Pendiente') {
        parent::__construct(); 
        $this->cliente = $cliente;
        $this->contacto = $contacto;
        $this->tipo_postre = $tipo_postre;
        $this->fecha_entrega = $fecha_entrega;
        $this->estado = $estado;
    }

    public function obtenerDetalles() {
        return "Pedido de {$this->tipo_postre} para {$this->cliente} ({$this->contacto}) - Entrega: {$this->fecha_entrega} - Estado: {$this->estado}";
    }
}