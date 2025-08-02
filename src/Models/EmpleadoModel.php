<?php
namespace App\Models;

use PDO;

class EmpleadoModel {
    public function __construct(private PDO $db) {}

    public function getAll(): array {
        $sql = <<<SQL
        SELECT e.*, a.nombre AS area
        FROM empleados e
        LEFT JOIN areas a ON e.area_id = a.id
        ORDER BY e.id DESC
        SQL;
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM empleados WHERE id = ?');
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        return $item ?: null;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare('INSERT INTO empleados (nombre, email, sexo, area_id, boletin, descripcion) VALUES (:nombre, :email, :sexo, :area_id, :boletin, :descripcion)');
        $stmt->execute([
            ':nombre'      => $data['nombre'],
            ':email'       => $data['email'],
            ':sexo'        => $data['sexo'],
            ':area_id'     => $data['area_id'],
            ':boletin'     => $data['boletin'],
            ':descripcion' => $data['descripcion'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare('UPDATE empleados SET nombre = :nombre, email = :email, sexo = :sexo, area_id = :area_id, boletin = :boletin, descripcion = :descripcion WHERE id = :id');
        return $stmt->execute([
            ':nombre'      => $data['nombre'],
            ':email'       => $data['email'],
            ':sexo'        => $data['sexo'],
            ':area_id'     => $data['area_id'],
            ':boletin'     => $data['boletin'],
            ':descripcion' => $data['descripcion'],
            ':id'          => $id,
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM empleados WHERE id = ?');
        return $stmt->execute([$id]);
    }
}