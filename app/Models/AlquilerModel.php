<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquilerModel extends Model
{
    protected $table            = 'alquileres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'reserva_id',
        'cliente_id',
        'vehiculo_id',
        'fecha_desde',
        'fecha_hasta',
        'devuelto',
        'fecha_devolucion',
    ];

    protected $camposJoin = 'alquileres.*,
        vehiculos.marca, vehiculos.modelo, vehiculos.anio, vehiculos.precio_dia,
        clientes.nombre, clientes.apellido, clientes.telefono,
        usuarios.email';

    /**
     * Listado de vehiculos actualmente alquilados (no devueltos) con los
     * datos del cliente que los alquilo. Punto 2.3 del practico.
     */
    public function actuales(): array
    {
        return $this->select($this->camposJoin)
            ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
            ->join('clientes', 'clientes.id = alquileres.cliente_id')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->where('alquileres.devuelto', 0)
            ->orderBy('alquileres.fecha_desde', 'DESC')
            ->findAll();
    }

    /**
     * Historial completo de alquileres (vigentes y devueltos).
     */
    public function historial(): array
    {
        return $this->select($this->camposJoin)
            ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
            ->join('clientes', 'clientes.id = alquileres.cliente_id')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->orderBy('alquileres.fecha_desde', 'DESC')
            ->findAll();
    }

    /**
     * Dado un vehiculo, todos los clientes que lo han alquilado. Punto 2.1.
     */
    public function porVehiculo(int $vehiculoId): array
    {
        return $this->select($this->camposJoin)
            ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
            ->join('clientes', 'clientes.id = alquileres.cliente_id')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->where('alquileres.vehiculo_id', $vehiculoId)
            ->orderBy('alquileres.fecha_desde', 'DESC')
            ->findAll();
    }

    /**
     * Dado un cliente, todos los vehiculos que ha alquilado. Punto 2.2.
     */
    public function porCliente(int $clienteId): array
    {
        return $this->select($this->camposJoin)
            ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
            ->join('clientes', 'clientes.id = alquileres.cliente_id')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->where('alquileres.cliente_id', $clienteId)
            ->orderBy('alquileres.fecha_desde', 'DESC')
            ->findAll();
    }

    public function deClienteSimple(int $clienteId): array
    {
        return $this->select($this->camposJoin)
            ->join('vehiculos', 'vehiculos.id = alquileres.vehiculo_id')
            ->join('clientes', 'clientes.id = alquileres.cliente_id')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->where('alquileres.cliente_id', $clienteId)
            ->orderBy('alquileres.fecha_desde', 'DESC')
            ->findAll();
    }
}
