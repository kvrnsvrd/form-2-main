<?php
session_start();
require('function.php');
require('pdo.php');
$errors = [];

if(!empty($_POST['submit'])){
    // traitement du formulaire
    
    foreach($_POST as $key => $value){
        $_POST[$key] = xss($value);
    }
    // valider text
    $errors = validText($errors, $_POST['produit'],'produit',5,50);
    $errors = validText($errors, $_POST['description'],'description',5,20);
    
    // valider prix
    if(!empty('prix')){
        $_POST['prix'] = intval($_POST['prix'],10);
        if(!filter_var($_POST['prix'], FILTER_VALIDATE_INT)){
            $errors['prix'] = 'Veuillez renseigner un entier';
        } elseif($_POST['prix'] < 0){
            $errors['prix'] = 'Veuillez renseigner une valeur positif';
        } elseif($_POST['prix'] > 1000000){
            $errors['prix'] = 'error fatale';
        }
    } else{
        $errors['prix'] = 'Veuillez renseigner le prix';
    }
    // vérifier l'affichage
    if($_FILES['affichage']['size'] === 0){
        $errors['affichage'] = "Image obligatoire";
    } else{
        if($_FILES['affichage']['type'] === "image/jpg" || $_FILES['affichage']['type'] === "image/jpeg" || $_FILES['affichage']['type'] === "image/png" || $_FILES['affichage']['type'] === "image/webp"){
            // success
            var_dump("success",getimagesize($_FILES['affichage']['tmp_name']));
        } else {
            $errors['affichage'] = "Le format n'est pas bon";
        }
        if($_FILES['affichage']['size'] >= 2000000){
            $errors['affichage'] = "Le fichier fait plus de 2 mo";
        }
    }
    /* // détection d'un email déjà présent dans une table
    $query = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $query->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $result= $query->fetch();
    if($result){
        $errors['double'] = "Cet email est déjà enregistré";
    } */

    if(count($errors) === 0){
        /* $password = password_hash($_POST['password'],PASSWORD_ARGON2I);
        // password_hash = crée une clé de hachage pour un mot de passe
        // PASSWORD_ARGON2I = algorithme de hachage Argon2i pour créer le hachage
 */
        // traitement pdo
        $sql = 'INSERT INTO vinyl (produit,affichage,prix,description) 
                VALUES (:produit,:affichage,:prix,:description)'; // Autoincrémentation = ajout de 1 automatiquement
        $query = $pdo->prepare($sql); // $query = prépare et exécute une requête sql
        $query->bindValue(':produit',$_POST['produit'], PDO::PARAM_STR); // bindValue = associe une valeur à un paramètre
        $query->bindValue(':description',$_POST['description'], PDO::PARAM_STR);
        $query->bindValue(':prix',$_POST['prix'], PDO::PARAM_INT);
        $query->bindValue(':affichage',"./assets/upload".$_FILES['affichage']['name'],PDO::PARAM_STR);

        $query->execute();

        if(!is_dir("../assets/upload")){ // Indique si le dossier existe
            mkdir("../assets/upload");   // créer un dossier
        }
        move_uploaded_file($_FILES['affichage']['tmp_name'],"../assets/upload".$_FILES['affichage']['name']);
        // tout c'est bien passé
        $_SESSION['produit'] = $_POST['produit'];
        $_SESSION['affichage'] = "../assets/upload".$_FILES['affichage']['name'];
        // $_SESSION['role'] = 'ROLE_USER';
        header("Location: ../index.php");
    } else{
        // tout ne s'est pas bien passé
        header("Location:../registration-vinyl.php?errors=".serialize($errors)."&data=".serialize($_POST));
    }
    /* debug($_FILES);
    debug($errors);
    debug($_POST); */ 
    die;
} else{
    // l'utilisateur n'a pas accès à cette page
    header('Location: index.php');
}