<?php
// api_check_login.php
require_once __DIR__ . '/../includes/config.php';
header('Content-Type: application/json');

echo json_encode([
  'logged_in' => isset($_SESSION['user_id'])
]);
