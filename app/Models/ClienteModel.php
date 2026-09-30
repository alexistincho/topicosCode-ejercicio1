<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'usuario_id',
        'nombre',
        'apellido',
        'direccion',
        'telefono',
        'fecha_alta',
        'estado',
    ];

    /**
     * Clientes activos junto con los datos de su cuenta de usuario.
     */
    public function listarConUsuario(): array
    {
        return $this->select('clientes.*, usuarios.usuario, usuarios.email')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->orderBy('clientes.estado', 'DESC')
            ->orderBy('clientes.apellido', 'ASC')
            ->findAll();
    }

    public function obtenerConUsuario(int $id): ?array
    {
        return $this->select('clientes.*, usuarios.usuario, usuarios.email')
            ->join('usuarios', 'usuarios.id = clientes.usuario_id')
            ->where('clientes.id', $id)
            ->first();
    }

    public function porUsuarioId(int $usuarioId): ?array
    {
        return $this->where('usuario_id', $usuarioId)->first();
    }

    /**
     * Listado simple para combos <select>. Incluye clientes dados de baja
     * porque pueden tener historial de alquileres consultable.
     */
    public function listarParaSelect(): array
    {
        return $this->select('id, nombre, apellido, estado')
            ->orderBy('apellido', 'ASC')
            ->findAll();
    }
}
