<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\ClienteModel;
use App\Models\ReservaModel;
use App\Models\VehiculoModel;

class Home extends BaseController
{
    /**
     * Menu principal. Muestra un panel distinto segun el rol logueado.
     */
    public function index()
    {
        if ($this->session->get('rol') === 'admin') {
            $vehiculoModel = new VehiculoModel();
            $clienteModel  = new ClienteModel();
            $reservaModel  = new ReservaModel();
            $alquilerModel = new AlquilerModel();

            $datos = [
                'totalVehiculos'       => count($vehiculoModel->where('estado', 1)->findAll()),
                'vehiculosDisponibles' => count($vehiculoModel->disponibles()),
                'totalClientes'        => count($clienteModel->where('estado', 1)->findAll()),
                'reservasPendientes'   => count($reservaModel->where('estado', 'pendiente')->findAll()),
                'alquileresActivos'    => count($alquilerModel->where('devuelto', 0)->findAll()),
            ];

            return view('admin/dashboard', $datos);
        }

        return view('insider/dashboard_cliente');
    }
}
