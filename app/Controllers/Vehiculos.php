<?php

namespace App\Controllers;

use App\Models\VehiculoModel;

class Vehiculos extends BaseController
{
    /**
     * Listado de vehiculos disponibles para alquilar.
     * Visible para cualquier usuario autenticado (admin o cliente).
     */
    public function index()
    {
        $vehiculoModel = new VehiculoModel();

        return view('vehiculos/lista', [
            'vehiculos' => $vehiculoModel->disponibles(),
        ]);
    }

    /**
     * Listado administrativo: todos los vehiculos (activos e inactivos).
     */
    public function adminIndex()
    {
        $vehiculoModel = new VehiculoModel();

        return view('vehiculos/admin_lista', [
            'vehiculos' => $vehiculoModel->listarTodos(),
        ]);
    }

    public function nuevo()
    {
        return view('vehiculos/form', [
            'vehiculo' => null,
            'modo'     => 'crear',
        ]);
    }

    public function crear()
    {
        if (! $this->validate($this->reglas(), $this->mensajes())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new VehiculoModel())->insert($this->datosFormulario());

        return redirect()->to('/admin/vehiculos')->with('success', 'Vehículo registrado correctamente.');
    }

    public function editar(int $id)
    {
        $vehiculoModel = new VehiculoModel();
        $vehiculo      = $vehiculoModel->find($id);

        if (! $vehiculo) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo solicitado no existe.');
        }

        return view('vehiculos/form', [
            'vehiculo' => $vehiculo,
            'modo'     => 'editar',
        ]);
    }

    public function actualizar(int $id)
    {
        $vehiculoModel = new VehiculoModel();
        $vehiculo      = $vehiculoModel->find($id);

        if (! $vehiculo) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo solicitado no existe.');
        }

        if (! $this->validate($this->reglas(), $this->mensajes())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $vehiculoModel->update($id, $this->datosFormulario());

        return redirect()->to('/admin/vehiculos')->with('success', 'Datos del vehículo actualizados correctamente.');
    }

    /**
     * Baja logica: el vehiculo deja de listarse pero conserva su historial.
     */
    public function baja(int $id)
    {
        $vehiculoModel = new VehiculoModel();

        if (! $vehiculoModel->find($id)) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo solicitado no existe.');
        }

        $vehiculoModel->update($id, ['estado' => 0, 'disponible' => 0]);

        return redirect()->to('/admin/vehiculos')->with('success', 'Vehículo dado de baja correctamente.');
    }

    /**
     * Reactiva un vehiculo que estaba dado de baja.
     */
    public function alta(int $id)
    {
        $vehiculoModel = new VehiculoModel();

        if (! $vehiculoModel->find($id)) {
            return redirect()->to('/admin/vehiculos')->with('error', 'El vehículo solicitado no existe.');
        }

        $vehiculoModel->update($id, ['estado' => 1, 'disponible' => 1]);

        return redirect()->to('/admin/vehiculos')->with('success', 'Vehículo reactivado correctamente.');
    }

    private function reglas(): array
    {
        $anioMax = (int) date('Y') + 1;

        return [
            'marca'       => 'required|min_length[2]|max_length[50]',
            'modelo'      => 'required|min_length[1]|max_length[50]',
            'anio'        => "required|is_natural_no_zero|greater_than_equal_to[1980]|less_than_equal_to[{$anioMax}]",
            'plazas'      => 'required|is_natural_no_zero|less_than_equal_to[9]',
            'motor'       => 'required|min_length[2]|max_length[50]',
            'kilometraje' => 'required|numeric|greater_than_equal_to[0]',
            'precio_dia'  => 'required|numeric|greater_than[0]',
        ];
    }

    private function mensajes(): array
    {
        $anioMax = (int) date('Y') + 1;

        return [
            'marca'  => ['required' => 'Ingrese la marca del vehículo.'],
            'modelo' => ['required' => 'Ingrese el modelo del vehículo.'],
            'anio'   => [
                'required'              => 'Ingrese el año del vehículo.',
                'is_natural_no_zero'    => 'El año debe ser un número válido.',
                'greater_than_equal_to' => 'El año no puede ser anterior a 1980.',
                'less_than_equal_to'    => "El año no puede ser mayor a {$anioMax}.",
            ],
            'plazas' => [
                'required'           => 'Ingrese la cantidad de plazas.',
                'is_natural_no_zero' => 'La cantidad de plazas debe ser un número válido.',
                'less_than_equal_to' => 'La cantidad de plazas no puede ser mayor a 9.',
            ],
            'motor' => ['required' => 'Ingrese el tipo de motor.'],
            'kilometraje' => [
                'required' => 'Ingrese el kilometraje.',
                'numeric'  => 'El kilometraje debe ser un valor numérico.',
            ],
            'precio_dia' => [
                'required'    => 'Ingrese el precio de alquiler por día.',
                'numeric'     => 'El precio debe ser un valor numérico.',
                'greater_than' => 'El precio debe ser mayor a 0.',
            ],
        ];
    }

    private function datosFormulario(): array
    {
        return [
            'marca'       => trim((string) $this->request->getPost('marca')),
            'modelo'      => trim((string) $this->request->getPost('modelo')),
            'anio'        => (int) $this->request->getPost('anio'),
            'plazas'      => (int) $this->request->getPost('plazas'),
            'motor'       => trim((string) $this->request->getPost('motor')),
            'kilometraje' => (float) $this->request->getPost('kilometraje'),
            'precio_dia'  => (float) $this->request->getPost('precio_dia'),
        ];
    }
}
