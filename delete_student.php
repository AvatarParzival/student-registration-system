<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD']==='POST'
    && isset($_POST['id'],$_POST['csrf'])
    && $_POST['csrf']===$_SESSION['csrf']) {

    $id = (int)$_POST['id'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
}
header('Location: view_students.php');