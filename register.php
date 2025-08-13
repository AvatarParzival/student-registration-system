<?php
session_start();
header('Content-Type: application/json');

$server = 'localhost';
$user   = 'root';
$pass   = '';
$db     = 'internship_db';
$conn   = new mysqli($server, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    exit(json_encode(['success'=>false,'error'=>'DB connection failed']));
}

if (!isset($_POST['csrf'])) {
    exit(json_encode(['success'=>false,'error'=>'Missing CSRF']));
}
if (!isset($_SESSION['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
    exit(json_encode(['success'=>false,'error'=>'Invalid CSRF']));
}

$name   = trim($_POST['name']   ?? '');
$email  = trim($_POST['email']  ?? '');
$roll   = trim($_POST['roll_number'] ?? '');
$dept   = trim($_POST['department'] ?? '');

if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$roll || !$dept) {
    exit(json_encode(['success'=>false,'error'=>'All fields required']));
}

$stmt = $conn->prepare("SELECT id FROM students WHERE email=? OR roll_number=? LIMIT 1");
$stmt->bind_param('ss', $email, $roll);
$stmt->execute();
if ($stmt->get_result()->num_rows) {
    exit(json_encode(['success'=>false,'error'=>'Email or Roll already exists']));
}

$stmt = $conn->prepare("INSERT INTO students(name,email,roll_number,department) VALUES(?,?,?,?)");
$stmt->bind_param('ssss', $name, $email, $roll, $dept);
$ok = $stmt->execute();
echo json_encode(['success'=>$ok, 'error'=>$ok ? '' : $stmt->error]);