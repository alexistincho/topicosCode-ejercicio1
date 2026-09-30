<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'usuario',
        'email',
        'contra',
        'rol',
        'estado',
    ];

    /**
     * Busca un usuario activo por su nombre de usuario o email.
     */
    public function buscarPorLogin(string $login): ?array
    {
        return $this->where('estado', 1)
            ->groupStart()
                ->where('usuario', $login)
                ->orWhere('email', $login)
            ->groupEnd()
            ->first();
    }

    public function usuarioExiste(string $usuario): bool
    {
        return $this->where('usuario', $usuario)->first() !== null;
    }

    public function emailExiste(string $email): bool
    {
        return $this->where('email', $email)->first() !== null;
    }
}
