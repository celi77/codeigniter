<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SensorModel;

class VistaPrincipal extends Controller
{
    public function __construct()
    {
        if (!session()->get('id_usuario')) {
            header('Location: ' . base_url('login'));
            exit;
        }
    }

    public function index()
    {
        $sensorModel = new SensorModel();
        $sensores = $sensorModel->findAll();

        // API clima
        $apiKey = "TU_API_KEY";
        $ciudad = "Rio Tercero,AR";

        $url = "https://api.openweathermap.org/data/2.5/weather?q=$ciudad&appid=$apiKey&units=metric";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $clima = json_decode($response, true);

        $temperatura = $clima['main']['temp'] ?? 0;
        $descripcion = $clima['weather'][0]['description'] ?? '';

        // ALERTAS Y ESTADO SEGÚN LOS PPM
        $alertas = 0;
        $estado = 'NORMAL';

        foreach ($sensores as $sensor) {

            if ($sensor['valor_ppm'] >= 10) {
                $alertas++;
            }

            if ($sensor['valor_ppm'] >= 50) {
                $estado = 'ALERTA';
            }
        }

        $data = [
            'sensores' => $sensores,
            'totalSensores' => count($sensores),
            'alertas' => $alertas,
            'temperatura' => $temperatura,
            'descripcion' => $descripcion,
            'estado' => $estado
        ];

        return view('vistaprincipal', $data);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to(base_url('login'));
    }
 
}