<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class Auth extends BaseController
{
    /**
     * Punto de entrada del sitio.
     */
    public function index()
    {
        if ($this->session->get('logueado')) {
            return redirect()->to('/home');
        }

        return redirect()->to('/login');
    }

    public function login()
    {
        if ($this->session->get('logueado')) {
            return redirect()->to('/home');
        }

        return view('login/login');
    }

    public function autenticar()
    {
        $rules = [
            'login'  => 'required|min_length[3]',
            'contra' => 'required',
        ];

        $messages = [
            'login'  => ['required' => 'Ingrese su usuario o email.'],
            'contra' => ['required' => 'Ingrese su contraseña.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usuarioModel = new UsuarioModel();
        $login        = trim((string) $this->request->getPost('login'));
        $contra       = (string) $this->request->getPost('contra');

        $usuario = $usuarioModel->buscarPorLogin($login);

        if (! $usuario || ! password_verify($contra, $usuario['contra'])) {
            return redirect()->back()->withInput()->with('error', 'Usuario/email o contraseña incorrectos.');
        }

        $datosSesion = [
            'logueado'       => true,
            'usuario_id'     => (int) $usuario['id'],
            'usuario_nombre' => $usuario['usuario'],
            'rol'            => $usuario['rol'],
        ];

        if ($usuario['rol'] === 'cliente') {
            $cliente = (new ClienteModel())->porUsuarioId((int) $usuario['id']);

            if ($cliente) {
                $datosSesion['cliente_id']     = (int) $cliente['id'];
                $datosSesion['cliente_nombre'] = $cliente['nombre'] . ' ' . $cliente['apellido'];
            }
        }

        $this->session->set($datosSesion);

        return redirect()->to('/home')->with('success', 'Bienvenido/a, ' . $usuario['usuario'] . '.');
    }

    public function registro()
    {
        if ($this->session->get('logueado')) {
            return redirect()->to('/home');
        }

        return view('login/registro');
    }

    public function registrar()
    {
        $rules = [
            'usuario'        => 'required|min_length[4]|max_length[50]|alpha_numeric|is_unique[usuarios.usuario]',
            'email'          => 'required|valid_email|max_length[100]|is_unique[usuarios.email]',
            'contra'         => 'required|min_length[6]',
            'contra_confirm' => 'required|matches[contra]',
            'nombre'         => 'required|min_length[2]|max_length[50]',
            'apellido'       => 'required|min_length[2]|max_length[50]',
            'direccion'      => 'required|min_length[5]|max_length[100]',
            'telefono'       => 'required|min_length[6]|max_length[30]',
        ];

        $messages = [
            'usuario' => [
                'required'      => 'Ingrese un nombre de usuario.',
                'min_length'    => 'El usuario debe tener al menos 4 caracteres.',
                'alpha_numeric' => 'El usuario solo puede contener letras y números, sin espacios.',
                'is_unique'     => 'Ese nombre de usuario ya está en uso.',
            ],
            'email' => [
                'required'    => 'Ingrese su email.',
                'valid_email' => 'Ingrese un email válido.',
                'is_unique'   => 'Ese email ya está registrado.',
            ],
            'contra' => [
                'required'   => 'Ingrese una contraseña.',
                'min_length' => 'La contraseña debe tener al menos 6 caracteres.',
            ],
            'contra_confirm' => [
                'required' => 'Confirme la contraseña.',
                'matches'  => 'Las contraseñas no coinciden.',
            ],
            'nombre'    => ['required' => 'Ingrese su nombre.'],
            'apellido'  => ['required' => 'Ingrese su apellido.'],
            'direccion' => ['required' => 'Ingrese su dirección.'],
            'telefono'  => ['required' => 'Ingrese su teléfono.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usuarioModel = new UsuarioModel();
        $clienteModel = new ClienteModel();

        $db = db_connect();
        $db->transStart();

        $usuarioId = $usuarioModel->insert([
            'usuario' => trim((string) $this->request->getPost('usuario')),
            'email'   => trim((string) $this->request->getPost('email')),
            'contra'  => password_hash((string) $this->request->getPost('contra'), PASSWORD_DEFAULT),
            'rol'     => 'cliente',
            'estado'  => 1,
        ]);

        $clienteModel->insert([
            'usuario_id' => $usuarioId,
            'nombre'     => trim((string) $this->request->getPost('nombre')),
            'apellido'   => trim((string) $this->request->getPost('apellido')),
            'direccion'  => trim((string) $this->request->getPost('direccion')),
            'telefono'   => trim((string) $this->request->getPost('telefono')),
            'fecha_alta' => date('Y-m-d'),
            'estado'     => 1,
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al registrar la cuenta. Intente nuevamente.');
        }

        return redirect()->to('/login')->with('success', 'Cuenta creada correctamente. Ya puede iniciar sesión.');
    }

    public function logout()
    {
        $this->session->destroy();

        return redirect()->to('/login')->with('success', 'Sesión finalizada correctamente.');
    }
}
