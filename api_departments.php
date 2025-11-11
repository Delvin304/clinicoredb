<?php
// api_departments.php
require_once '../includes/config.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query('SELECT id, name FROM departments ORDER BY name');
    $departments = $stmt->fetchAll();
    echo json_encode(['success' => true, 'data' => $departments]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to fetch departments']);
}
