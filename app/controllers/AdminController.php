<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Taller.php';

class AdminController
{
    private $solicitudModel;
    private $tallerModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->solicitudModel = new Solicitud($db);
        $this->tallerModel = new Taller($db);
    }

    public function solicitudes()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/admin/solicitudes.php';
    }

    // Aprobar solicitud
    public function aprobar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }

        $solicitudId = $_POST['id_solicitud'] ?? 0;

        try {

            if (empty($solicitudId) || !is_numeric($solicitudId)) {
                throw new Exception('Solicitud inválida');
            }

            $solicitud = $this->solicitudModel->getById($solicitudId);
            if (!$solicitud) {
                throw new Exception('Solicitud no encontrada');
            }
            if ($solicitud['estado'] !== 'pendiente') {
                throw new Exception('Solicitud ya fue procesada');
            }
            $taller = $this->tallerModel->getById($solicitud['taller_id']);
            if (!$taller) {
                throw new Exception('Taller no encontrado');
            }
            if ($taller['cupo_disponible'] <= 0) {
                throw new Exception('No hay cupos disponibles');
            }
            $descontado = $this->tallerModel->descontarCupo($solicitud['taller_id']);
            if (!$descontado) {
                throw new Exception('Error al descontar cupo');
            }
            $aprobado = $this->solicitudModel->aprobar($solicitudId);
            if (!$aprobado) {
                throw new Exception('Error al aprobar solicitud');
            }

            echo json_encode(['success' => true, 'message' => 'Solicitud aprobada correctamente']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    public function rechazar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }
        $solicitudId = $_POST['id_solicitud'] ?? 0;

        if (empty($solicitudId) || !is_numeric($solicitudId)) {
            echo json_encode(['success' => false, 'error' => 'Solicitud inválida']);
            return;
        }

        $solicitud = $this->solicitudModel->getById($solicitudId);
        if (!$solicitud) {
            echo json_encode(['success' => false, 'error' => 'Solicitud no encontrada']);
            return;
        }

        if ($solicitud['estado'] !== 'pendiente') {
            echo json_encode(['success' => false, 'error'=> 'Solicitud ya fue procesada']);
            return;
        }

        $resultado = $this->solicitudModel->rechazar($solicitudId);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'message'=> 'Solicitud rechazada correctamente']);
        } else {
            echo json_encode(['success' => false, 'error'=> 'Error al rechazar la solicitud']);
        }
    }

    public function getSolicitudesJson()
    {
        if(!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin'){
            echo json_encode([]);
            return;
        }
        $solicitudes = $this->solicitudModel->getPendientes();

        echo json_encode($solicitudes);
    }
}
