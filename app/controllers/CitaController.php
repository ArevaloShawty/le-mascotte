<?php
require_once APP_PATH . '/models/CitaModel.php';
require_once APP_PATH . '/models/Mailer.php';

class CitaController {
    private CitaModel $model;
    public function __construct() { $this->model = new CitaModel(); }

    public function index(): void { require APP_PATH . '/views/citas.php'; }

    public function crear(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('citas');
        $data = [
            'nombre_dueno'    => sanitize($_POST['nombre_dueno'] ?? ''),
            'email'           => sanitize($_POST['email'] ?? ''),
            'telefono'        => sanitize($_POST['telefono'] ?? ''),
            'nombre_mascota'  => sanitize($_POST['nombre_mascota'] ?? ''),
            'tipo_mascota'    => sanitize($_POST['tipo_mascota'] ?? ''),
            'motivo_consulta' => sanitize($_POST['motivo_consulta'] ?? ''),
            'fecha_preferida' => $_POST['fecha_preferida'] ?? '',
            'hora_preferida'  => $_POST['hora_preferida'] ?? '',
        ];
        foreach (['nombre_dueno','telefono','nombre_mascota','tipo_mascota','motivo_consulta','fecha_preferida','hora_preferida'] as $c) {
            if (empty($data[$c])) {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) jsonResponse(['success'=>false,'message'=>'Completa todos los campos requeridos.'],400);
                $_SESSION['error'] = 'Completa todos los campos requeridos.'; redirect('citas');
            }
        }
        $citaId = $this->model->crear($data);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if ($citaId === false) jsonResponse(['success'=>false,'message'=>'Ese horario ya está ocupado.'],409);
            $cita = $this->model->getById($citaId);
            if ($cita) { if (!empty($cita['email'])) Mailer::confirmacionCita($cita); Mailer::notificarAdminNuevaCita($cita); }
            jsonResponse(['success'=>true,'message'=>'¡Listo! El equipo de Le Mascotte espera a tu compañero. Revisa tu correo.','cita_id'=>$citaId]);
        }
        if ($citaId === false) { $_SESSION['error'] = 'Ese horario ya está ocupado.'; }
        else {
            $cita = $this->model->getById($citaId);
            if ($cita) { if (!empty($cita['email'])) Mailer::confirmacionCita($cita); Mailer::notificarAdminNuevaCita($cita); }
            $_SESSION['success'] = '¡Listo! El equipo de Le Mascotte espera a tu compañero.';
        }
        redirect('citas');
    }

    public function horariosOcupados(): void {
        $fecha = $_GET['fecha'] ?? '';
        if (!$fecha) jsonResponse(['horarios'=>[]]);
        jsonResponse(['horarios'=>$this->model->getHorariosOcupados($fecha)]);
    }
}
