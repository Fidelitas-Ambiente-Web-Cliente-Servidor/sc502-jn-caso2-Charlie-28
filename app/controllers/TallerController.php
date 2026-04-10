<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Taller.php';
require_once __DIR__ . '/../models/Solicitud.php';

class TallerController
{
    private $tallerModel;
    private $solicitudModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->tallerModel = new Taller($db);
        $this->solicitudModel = new Solicitud($db);
    }

    public function index()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/taller/listado.php';
    }
    
    public function getTalleresJson()
    {
        if (!isset($_SESSION['id'])) {
            echo json_encode([]);
            return;
        }
        
        $talleres = $this->tallerModel->getAllDisponibles();
        header('Content-Type: application/json');
        echo json_encode($talleres);
    }
    
    public function solicitar()
    {
        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión']);
            return;
        }
        
        $tallerId = $_POST['taller_id'] ?? 0;
        $usuarioId = $_SESSION['id'];

        if (empty($tallerId) || !is_numeric($tallerId)){
            echo json_encode(['success' => false, 'error' => 'Taller inválido']);
            return;
        }

        $taller = $this->tallerModel->getById($tallerId);

        if(!$taller){
            echo json_encode(['success' => false, 'error' => 'Taller no encontrado']);
            return;
        }

        if ($taller['cupo_disponible'] <= 0) {
            echo json_encode(['success' => false, 'error' => 'No hay cupos disponibles']);
            return;
        }

        if($this->solicitudModel->solicitudActiva($tallerId, $usuarioId)){
            echo json_encode(['success' => false, 'error' => 'Ya tienes una solicitud pendiente']);
            return;
        }

        $result = $this->solicitudModel->create($usuarioId, $tallerId);

        if ($result) {
            echo json_encode(['success' => true ,'message' => 'Solicitud enviada correctamente']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al solicitar']);
        }

    }
}