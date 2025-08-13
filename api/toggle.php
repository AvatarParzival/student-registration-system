<?php
session_start();
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD']==='POST'
    && isset($_POST['id'],$_POST['csrf'])
    && $_POST['csrf']===$_SESSION['csrf']) {

    $id = (int)$_POST['id'];
    $stmt = $conn->prepare("UPDATE students SET completed = NOT completed WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
}