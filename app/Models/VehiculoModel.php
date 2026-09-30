<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculoModel extends Model
{
    protected $table            = 'vehiculos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'marca',
        'modelo',
        'anio',
        'plazas',
        'motor',
        'kilometraje',
        'precio_dia',
        'disponible',
        'estado',
    ];

    /**
     * Vehiculos activos (de alta) y actualmente disponibles para alquilar.
     */
    public function disponibles(): array
    {
        return $this->where('estado', 1)
            ->where('disponible', 1)
            ->orderBy('marca', 'ASC')
            ->findAll();
    }

    /**
     * Todos los vehiculos activos (para combos / selects de admin).
     */
    public function activos(): array
    {
        return $this->where('estado', 1)->orderBy('marca', 'ASC')->findAll();
    }

    public function listarTodos(): array
    {
        return $this->orderBy('estado', 'DESC')->orderBy('marca', 'ASC')->findAll();
    }

    /**
     * Listado simple para combos <select>. Incluye vehiculos dados de baja
     * porque pueden tener historial de alquileres consultable.
     */
    public function listarParaSelect(): array
    {
        return $this->select('id, marca, modelo, anio, estado')
            ->orderBy('marca', 'ASC')
            ->findAll();
    }
}
