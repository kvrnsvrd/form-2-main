<?php
session_start();
require_once("../inc/pdo.php");
require_once("../inc/function.php");
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    // header("Location: ../index.php");
}

if (!empty($_POST['submit'])) {
    // création du tableau d'erreur
    $errors = [];
    // existence d'une nouvelle image
    $boolImg = false;
    // get id
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // header("Location: ../admin.php");
    }
    // traitement du formulaire xss
    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }
    // valid text
    $errors = validText($errors, $_POST['produit'],'produit',5,50);
    $errors = validText($errors, $_POST['description'],'description',5,20);

    // verif image

    if ($_FILES['affichage']['size'] > 0) {
        $tabTypImg = ["image/jpg", "image/jpeg", "image/png", "image/webp"];

        for ($i = 0; $i < count($tabTypImg); $i++) {
            if ($_FILES['affichage']['type'] === $tabTypImg[$i]) {
                $boolImg = true;
            }
        }
        $boolImg ?: $errors['affichage'] = "Le format n'est pas bon";

        /* if ($_FILES['avatar']['type'] === "image/jpg" || $_FILES['avatar']['type'] === "image/jpeg" || $_FILES['avatar']['type'] === "image/png" || $_FILES['avatar']['type'] === "image/webp") {
            //success
            var_dump("success",getimagesize($_FILES['avatar']['tmp_name']));
            // commit        
        } else {
            $errors['avatar'] = "Le format n'est pas bon";
        } */


        if ($_FILES['affichage']['size'] >= 2000000) {
            $errors['affichage'] = "Le fichier fait plus de 2 Mo";
        }
    }
    var_dump($errors);

    if (count($errors) === 0) {

        // récup des anciennes données utilisateur
        $query = $pdo->prepare("SELECT * FROM vinyl WHERE id = :id");
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();
        /* // verification d'un changement de mot de pass
        if ($_POST['password'] === "") {
            $password = $result['password'];
        } else {
            //hash password
            $password = password_hash($_POST['password'], PASSWORD_ARGON2I);
        } */
        // verification du changement d'image
        if ($boolImg) {
            $affichageUrl = "./assets/upload/" . $_FILES['affichage']['name'];
        } else {
            $affichageUrl = $result['affichage'];
        }

        // traitement pdo update
        $sql = "UPDATE vinyl SET produit = :produit, prix = :prix WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':produit', $_POST['produit'], PDO::PARAM_STR);
        $query->bindValue(':prix', $_POST['prix'], PDO::PARAM_INT);
        $query->bindValue(':id', $_POST['id'], PDO::PARAM_INT);

        $query->execute();

        if($boolImg){
            if (!is_dir("../assets/upload")) {
            mkdir("../assets/upload");
            }
            move_uploaded_file($_FILES['affichage']['tmp_name'], "../assets/upload/" . $_FILES['affichage']['name']);
        }// tout c'est bien passé

        // header("Location: ../admin.php");
    } else {
        // tout ne s'est pas bien passé
        // header("Location: ./update-vinyl.php?errors=" . serialize($errors) . "&data=" . serialize($_POST));
    }
    die;
} else {
    // n'a pas acces à cette page
    // header("Location: ../index.php");
}