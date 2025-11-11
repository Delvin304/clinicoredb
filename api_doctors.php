<?php
// api_doctors.php
require_once '../includes/config.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query('SELECT id, full_name FROM doctors ORDER BY full_name');
    $doctors = $stmt->fetchAll();
    echo json_encode(['success' => true, 'data' => $doctors]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to fetch doctors']);
}
