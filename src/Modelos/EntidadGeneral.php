<?php
namespace App\Modelos;

abstract class EntidadGeneral {
    protected $id;
    protected $fechaCreacion;

    public function __construct() {
        $this->fechaCreacion = date('Y-m-d H:i:s');
    }

    public function getId() {
        return $this->id;
    }
}