<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\ReservaModel;
use App\Models\VehiculoModel;

class Reservas extends BaseController
{
    /**
     * Formulario de reserva para un vehiculo puntual (rol Cliente).
     */
    public function nueva(int $vehiculoId)
    {
        $vehiculo = (new VehiculoModel())->find($vehiculoId);

        if (! $vehiculo || ! $vehiculo['disponible'] || ! $vehiculo['estado']) {
            return redirect()->to('/vehiculos')->with('error', 'Ese vehículo ya no está disponible.');
        }

        return view('reservas/nueva', ['vehiculo' => $vehiculo]);
    }

    /**
     * Registra la reserva enviada por el cliente. Queda pendiente de
     * aprobacion por parte del administrador.
     */
    public function crear()
    {
        $rules = [
            'vehiculo_id'   => 'required|is_natural_no_zero',
            'fecha_desde'   => 'required|valid_date[Y-m-d]',
            'cantidad_dias' => 'required|is_natural_no_zero|less_than_equal_to[60]',
        ];

        $messages = [
            'vehiculo_id' => ['required' => 'Vehículo inválido.'],
            'fecha_desde' => [
                'required'   => 'Indique la fecha desde.',
                'valid_date' => 'La fecha indicada no es válida.',
            ],
            'cantidad_dias' => [
                'required'           => 'Indique la cantidad de días.',
                'is_natural_no_zero' => 'La cantidad de días debe ser un número mayor a 0.',
                'less_than_equal_to' => 'La cantidad de días no puede superar los 60.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $clienteId  = $this->session->get('cliente_id');
        $vehiculoId = (int) $this->request->getPost('vehiculo_id');
        $fechaDesde = (string) $this->request->getPost('fecha_desde');

        if (! $clienteId) {
            return redirect()->to('/home')->with('error', 'No se encontró su perfil de cliente.');
        }

        if ($fechaDesde < date('Y-m-d')) {
            return redirect()->back()->withInput()->with('error', 'La fecha desde no puede ser anterior a hoy.');
        }

        $vehiculo = (new VehiculoModel())->find($vehiculoId);

        if (! $vehiculo || ! $vehiculo['disponible'] || ! $vehiculo['estado']) {
            return redirect()->to('/vehiculos')->with('error', 'Ese vehículo ya no está disponible.');
        }

        (new ReservaModel())->insert([
            'cliente_id'    => $clienteId,
            'vehiculo_id'   => $vehiculoId,
            'fecha_desde'   => $fechaDesde,
            'cantidad_dias' => (int) $this->request->getPost('cantidad_dias'),
            'estado'        => 'pendiente',
        ]);

        return redirect()->to('/mis-reservas')->with('success', 'Reserva enviada. Quedará pendiente de aprobación por el administrador.');
    }

    /**
     * Reservas y alquileres del cliente logueado.
     */
    public function misReservas()
    {
        $clienteId = $this->session->get('cliente_id');

        if (! $clienteId) {
            return redirect()->to('/home')->with('error', 'No se encontró su perfil de cliente.');
        }

        $reservaModel  = new ReservaModel();
        $alquilerModel = new AlquilerModel();

        return view('reservas/mis_reservas', [
            'reservas'   => $reservaModel->deCliente($clienteId),
            'alquileres' => $alquilerModel->deClienteSimple($clienteId),
        ]);
    }

    /**
     * Bandeja de reservas pendientes (rol Administrador).
     */
    public function pendientes()
    {
        return view('reservas/pendientes', [
            'reservas' => (new ReservaModel())->pendientes(),
        ]);
    }

    /**
     * Aprueba una reserva y la transforma en un alquiler. Punto "Alta"
     * del practico: "por cada reserva ... el administrador podrá
     * registrarla como alquiler".
     */
    public function aprobar(int $id)
    {
        $reservaModel  = new ReservaModel();
        $vehiculoModel = new VehiculoModel();
        $alquilerModel = new AlquilerModel();

        $reserva = $reservaModel->find($id);

        if (! $reserva || $reserva['estado'] !== 'pendiente') {
            return redirect()->to('/admin/reservas')->with('error', 'La reserva ya fue procesada o no existe.');
        }

        $vehiculo = $vehiculoModel->find($reserva['vehiculo_id']);

        if (! $vehiculo || ! $vehiculo['disponible'] || ! $vehiculo['estado']) {
            return redirect()->to('/admin/reservas')->with('error', 'El vehículo de esta reserva ya no está disponible. Puede rechazarla.');
        }

        $db = db_connect();
        $db->transStart();

        $fechaHasta = date('Y-m-d', strtotime($reserva['fecha_desde'] . " +{$reserva['cantidad_dias']} days"));

        $alquilerModel->insert([
            'reserva_id'  => $reserva['id'],
            'cliente_id'  => $reserva['cliente_id'],
            'vehiculo_id' => $reserva['vehiculo_id'],
            'fecha_desde' => $reserva['fecha_desde'],
            'fecha_hasta' => $fechaHasta,
            'devuelto'    => 0,
        ]);

        $reservaModel->update($id, ['estado' => 'aprobada']);
        $vehiculoModel->update($reserva['vehiculo_id'], ['disponible' => 0]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/admin/reservas')->with('error', 'Ocurrió un error al registrar el alquiler.');
        }

        return redirect()->to('/admin/reservas')->with('success', 'Reserva aprobada y registrada como alquiler.');
    }

    public function rechazar(int $id)
    {
        $reservaModel = new ReservaModel();
        $reserva      = $reservaModel->find($id);

        if (! $reserva || $reserva['estado'] !== 'pendiente') {
            return redirect()->to('/admin/reservas')->with('error', 'La reserva ya fue procesada o no existe.');
        }

        $reservaModel->update($id, ['estado' => 'rechazada']);

        return redirect()->to('/admin/reservas')->with('success', 'Reserva rechazada.');
    }
}
