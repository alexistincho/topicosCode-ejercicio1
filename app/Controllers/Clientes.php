<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class Clientes extends BaseController
{
    public function index()
    {
        return view('clientes/lista', [
            'clientes' => (new ClienteModel())->listarConUsuario(),
        ]);
    }

    public function editar(int $id)
    {
        $cliente = (new ClienteModel())->obtenerConUsuario($id);

        if (! $cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'El cliente solicitado no existe.');
        }

        return view('clientes/form', ['cliente' => $cliente]);
    }

    public function actualizar(int $id)
    {
        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->find($id);

        if (! $cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'El cliente solicitado no existe.');
        }

        $rules = [
            'nombre'    => 'required|min_length[2]|max_length[50]',
            'apellido'  => 'required|min_length[2]|max_length[50]',
            'direccion' => 'required|min_length[5]|max_length[100]',
            'telefono'  => 'required|min_length[6]|max_length[30]',
        ];

        $messages = [
            'nombre'    => ['required' => 'Ingrese el nombre.'],
            'apellido'  => ['required' => 'Ingrese el apellido.'],
            'direccion' => ['required' => 'Ingrese la dirección.'],
            'telefono'  => ['required' => 'Ingrese el teléfono.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $clienteModel->update($id, [
            'nombre'    => trim((string) $this->request->getPost('nombre')),
            'apellido'  => trim((string) $this->request->getPost('apellido')),
            'direccion' => trim((string) $this->request->getPost('direccion')),
            'telefono'  => trim((string) $this->request->getPost('telefono')),
        ]);

        return redirect()->to('/admin/clientes')->with('success', 'Datos del cliente actualizados correctamente.');
    }

    /**
     * Baja logica del cliente: tambien deshabilita su cuenta de acceso,
     * pero conserva el historial de alquileres.
     */
    public function baja(int $id)
    {
        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->find($id);

        if (! $cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'El cliente solicitado no existe.');
        }

        $clienteModel->update($id, ['estado' => 0]);
        (new UsuarioModel())->update($cliente['usuario_id'], ['estado' => 0]);

        return redirect()->to('/admin/clientes')->with('success', 'Cliente dado de baja correctamente.');
    }

    public function alta(int $id)
    {
        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->find($id);

        if (! $cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'El cliente solicitado no existe.');
        }

        $clienteModel->update($id, ['estado' => 1]);
        (new UsuarioModel())->update($cliente['usuario_id'], ['estado' => 1]);

        return redirect()->to('/admin/clientes')->with('success', 'Cliente reactivado correctamente.');
    }
}
