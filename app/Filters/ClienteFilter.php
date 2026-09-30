<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ClienteFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if (! $session->get('logueado')) {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión para continuar.');
        }

        if ($session->get('rol') !== 'cliente') {
            return redirect()->to('/home')->with('error', 'Esa sección es exclusiva para clientes.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Sin acciones posteriores
    }
}
