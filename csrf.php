<?php
session_start();
if (!isset($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
echo json_encode(['token' => $_SESSION['csrf']]);