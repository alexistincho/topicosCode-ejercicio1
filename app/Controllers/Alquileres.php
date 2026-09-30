<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\ClienteModel;
use App\Models\VehiculoModel;

class Alquileres extends BaseController
{
    /**
     * Listado de vehiculos actualmente alquilados con los datos del
     * cliente que lo alquilo. Punto 2.3 del practico.
     */
    public function actuales()
    {
        return view('alquileres/actuales', [
            'alquileres' => (new AlquilerModel())->actuales(),
        ]);
    }

    /**
     * Historial completo (vigentes + devueltos).
     */
    public function historial()
    {
        return view('alquileres/historial', [
            'alquileres' => (new AlquilerModel())->historial(),
        ]);
    }

    /**
     * Dado un vehiculo, todos los clientes que lo han alquilado. Punto 2.1.
     */
    public function porVehiculo()
    {
        $vehiculoId = (int) ($this->request->getGet('vehiculo_id') ?? 0);
        $resultados = [];
        $vehiculo   = null;

        if ($vehiculoId > 0) {
            $vehiculo   = (new VehiculoModel())->find($vehiculoId);
            $resultados = (new AlquilerModel())->porVehiculo($vehiculoId);
        }

        return view('alquileres/por_vehiculo', [
            'vehiculos'    => (new VehiculoModel())->listarParaSelect(),
            'vehiculoId'   => $vehiculoId,
            'vehiculo'     => $vehiculo,
            'resultados'   => $resultados,
        ]);
    }

    /**
     * Dado un cliente, los vehiculos que ha alquilado. Punto 2.2.
     */
    public function porCliente()
    {
        $clienteId  = (int) ($this->request->getGet('cliente_id') ?? 0);
        $resultados = [];
        $cliente    = null;

        if ($clienteId > 0) {
            $cliente    = (new ClienteModel())->find($clienteId);
            $resultados = (new AlquilerModel())->porCliente($clienteId);
        }

        return view('alquileres/por_cliente', [
            'clientes'   => (new ClienteModel())->listarParaSelect(),
            'clienteId'  => $clienteId,
            'cliente'    => $cliente,
            'resultados' => $resultados,
        ]);
    }

    /**
     * Registra la devolucion del vehiculo y lo vuelve a poner disponible.
     */
    public function devolver(int $id)
    {
        $alquilerModel = new AlquilerModel();
        $alquiler      = $alquilerModel->find($id);

        if (! $alquiler || $alquiler['devuelto']) {
            return redirect()->back()->with('error', 'El alquiler ya fue devuelto o no existe.');
        }

        $db = db_connect();
        $db->transStart();

        $alquilerModel->update($id, [
            'devuelto'         => 1,
            'fecha_devolucion' => date('Y-m-d'),
        ]);

        (new VehiculoModel())->update($alquiler['vehiculo_id'], ['disponible' => 1]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Ocurrió un error al registrar la devolución.');
        }

        return redirect()->back()->with('success', 'Devolución registrada. El vehículo vuelve a estar disponible.');
    }
}
