<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if (! $session->get('logueado')) {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión para continuar.');
        }

        if ($session->get('rol') !== 'admin') {
            return redirect()->to('/home')->with('error', 'No tiene permisos para acceder a esa sección.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Sin acciones posteriores
    }
}
