<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Models\EmpleadoModel;

// Carga de configuración y conexión a la base de datos
$config = require __DIR__ . '/../config/config.php';
$db     = (new Database($config))->getPdo();
$model  = new EmpleadoModel($db);

// === Creación de nueva Área desde el listado ===
if (isset($_GET['action']) && $_GET['action'] === 'store_area') {
    try {
        $nombreArea = trim($_POST['nombre_area'] ?? '');
        if ($nombreArea === '') {
            throw new \Exception('El nombre del área es obligatorio.');
        }
        $stmt = $db->prepare('INSERT INTO areas (nombre) VALUES (:nombre)');
        $stmt->execute([':nombre' => $nombreArea]);
        $_SESSION['success'] = 'Área creada exitosamente.';
    } catch (\Exception $e) {
        $_SESSION['error'] = 'Error al crear área: ' . $e->getMessage();
    }
    header('Location: index.php');
    exit;
}

// Flash-messages
$success = $_SESSION['success'] ?? null;
$error   = $_SESSION['error']   ?? null;
unset($_SESSION['success'], $_SESSION['error']);

// Determinar acción
$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        // Datos para el formulario
        $areas      = $db->query('SELECT id, nombre FROM areas')->fetchAll(\PDO::FETCH_ASSOC);
        $roles      = $db->query('SELECT id, nombre FROM roles')->fetchAll(\PDO::FETCH_ASSOC);
        $item_roles = [];
        include __DIR__ . '/../views/form.php';
        break;

    case 'store':
        try {
            // Recopilar datos del formulario
            $data = [
                'nombre'      => trim($_POST['nombre'] ?? ''),
                'email'       => trim($_POST['email'] ?? ''),
                'sexo'        => $_POST['sexo'] ?? '',
                'area_id'     => (int) ($_POST['area_id'] ?? 0),
                'boletin'     => isset($_POST['boletin']) ? 1 : 0,
                'descripcion' => trim($_POST['descripcion'] ?? ''),
            ];
            // Crear empleado
            $id = $model->create($data);
            // Guardar roles
            $selected = $_POST['roles'] ?? [];
            foreach ($selected as $rolId) {
                $insert = $db->prepare('INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (?,?)');
                $insert->execute([$id, (int)$rolId]);
            }
            $_SESSION['success'] = 'Empleado creado exitosamente.';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error al crear empleado: ' . $e->getMessage();
        }
        header('Location: index.php');
        exit;

    case 'edit':
        // 1) ID y datos del empleado
        $id   = (int) ($_GET['id'] ?? 0);
        $item = $model->getById($id);
        
        // 2) Carga áreas y roles para los selects/checkboxes
        $areas = $db
            ->query('SELECT id, nombre FROM areas')
            ->fetchAll(\PDO::FETCH_ASSOC);
        $roles = $db
            ->query('SELECT id, nombre FROM roles')
            ->fetchAll(\PDO::FETCH_ASSOC);
        
        // 3) Carga los roles asignados a este empleado
        $stmt = $db->prepare('SELECT rol_id FROM empleado_rol WHERE empleado_id = :id');
        $stmt->execute([':id' => $id]);
        // IMPORTANTE: FETCH_COLUMN para que te devuelva un array [3,5,7...] con los rol_id
        $item_roles = $stmt->fetchAll(\PDO::FETCH_COLUMN, 0);
        
        include __DIR__ . '/../views/form.php';
        break;

    case 'update':
        try {
            $id = (int) ($_POST['id'] ?? 0);
            // Datos actualizados
            $data = [
                'nombre'      => trim($_POST['nombre'] ?? ''),
                'email'       => trim($_POST['email'] ?? ''),
                'sexo'        => $_POST['sexo'] ?? '',
                'area_id'     => (int) ($_POST['area_id'] ?? 0),
                'boletin'     => isset($_POST['boletin']) ? 1 : 0,
                'descripcion' => trim($_POST['descripcion'] ?? ''),
            ];
            $model->update($id, $data);

            // Sincronizar roles: primero eliminamos todos, luego reinsertamos
            $db->prepare('DELETE FROM empleado_rol WHERE empleado_id = ?')->execute([$id]);
            $selected = $_POST['roles'] ?? [];
            foreach ($selected as $rolId) {
                $insert = $db->prepare('INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (?,?)');
                $insert->execute([$id, (int)$rolId]);
            }

            $_SESSION['success'] = 'Empleado actualizado correctamente.';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error al actualizar empleado: ' . $e->getMessage();
        }
        header('Location: index.php');
        exit;

    case 'delete':
        try {
            $id = (int) ($_GET['id'] ?? 0);
            $model->delete($id);
            // Las relaciones en empleado_rol se eliminan por ON DELETE CASCADE si lo configuraste así
            $_SESSION['success'] = 'Empleado eliminado.';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error al eliminar empleado: ' . $e->getMessage();
        }
        header('Location: index.php');
        exit;

    case 'list':
    default:
        $items = $model->getAll();
        include __DIR__ . '/../views/list.php';
        break;
}
