<?php
session_start();
require("../inc/pdo.php");
require("../inc/function.php");
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
    die;
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    header("Location: ../admin.php");
}
$query = $pdo->prepare("SELECT * FROM user WHERE id = $id");
$query->execute();
$user = $query->fetch();

// afficher les données d'un utilisateur
include_once("../inc/header.php");
?>

<div class="card">
    <div class="headerImg">
        <img src=".<?= $user['avatar']; ?>" alt="">
    </div>
    <div class="cardTitle">
        <?= $user['avatar']; ?>
    </div>
    <div class="cardText">
        <?= $user['name']; ?>
    </div>
    <div class="cardText">
        <?= $user['email']; ?>
    </div>
    <div class="cardText">
        <?= $user['role']; ?>
    </div>
    <div class="cardText">
        <?= $user['created_at']; ?>
    </div>
</div>

<?php
include_once("../inc/footer.php");