<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservaModel extends Model
{
    protected $table            = 'reservas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'cliente_id',
        'vehiculo_id',
        'fecha_desde',
        'cantidad_dias',
        'estado',
    ];

    protected $camposJoin = 'reservas.*,
        vehiculos.marca, vehiculos.modelo, vehiculos.precio_dia,
        clientes.nombre, clientes.apellido,
        usuarios.email';

    /**
     * Reservas pendientes de revision por el administrador.
     */
    public function pendientes(): array
    {
        return $this->select($this->camposJoin)
            ->join('vehiculos', 'vehiculos.id = reservas.vehiculo_id')
            ->join('clientes', 'clientes.id = reservas.cliente_id')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->where('reservas.estado', 'pendiente')
            ->orderBy('reservas.creado_en', 'ASC')
            ->findAll();
    }

    /**
     * Todas las reservas de un cliente (cualquier estado), mas recientes primero.
     */
    public function deCliente(int $clienteId): array
    {
        return $this->select($this->camposJoin)
            ->join('vehiculos', 'vehiculos.id = reservas.vehiculo_id')
            ->join('clientes', 'clientes.id = reservas.cliente_id')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->where('reservas.cliente_id', $clienteId)
            ->orderBy('reservas.creado_en', 'DESC')
            ->findAll();
    }

    public function obtenerConDetalle(int $id): ?array
    {
        return $this->select($this->camposJoin)
            ->join('vehiculos', 'vehiculos.id = reservas.vehiculo_id')
            ->join('clientes', 'clientes.id = reservas.cliente_id')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->where('reservas.id', $id)
            ->first();
    }
}
