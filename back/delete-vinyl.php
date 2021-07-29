<?php
session_start();
require("../inc/pdo.php");
require("../inc/function.php");
include('../inc/header.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
    die;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    header("Location: ../admin.php");
}
// get user
$query = $pdo->prepare("DELETE FROM vinyl WHERE id = $id");
$query->execute();
$data = $query->fetch();
header('Location: ../admin.php');

include('../inc/footer.php');