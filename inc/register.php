<?php
session_start();
require('function.php');
require('pdo.php');
$errors = [];

if(!empty($_POST['submitted'])){
    // traitement du formulaire
    foreach($_POST as $key => $value){
        $_POST[$key] = xss($value);
    }
    // valider text
    $errors = validText($errors, $_POST['password'],'password',5,8);
    $errors = validText($errors, $_POST['name'],'name',5,8);
    
    // valider age
    if(!empty($_POST['age'])){
        if(!filter_var($age, FILTER_VALIDATE_INT)){
            $errors['age'] = 'Veuillez renseigner un entier';
        } elseif($age < 0){
            $errors['age'] = 'Veuillez renseigner une valeur positif';
        } elseif($age > 130){
            $errors['age'] = 'error fatale';
        }
    } else{
        $errors['age'] = 'Veuillez renseigner votre âge';
    }
    // valider email
    $errors = validEmail($errors, $_POST['email']);
    // valider checkbox
    if(empty($_POST['mentions'])){
        $errors['mentions'] = "Conditions obligatoires";
    }
    //  vérifier l'image
    if($_FILES['avatar']['size'] === 0){
        $errors['avatar'] = "Image obligatoire";
    } else{
        if($_FILES['avatar']['type'] === "image/jpg" || $_FILES['avatar']['type'] === "image/png" || $_FILES['avatar']['type'] === "image/webp"){
            // success
            var_dump("success",getimagesize($_FILES['avatar']['tmp_name']));
        } else {
            $errors['avatar'] = "Le format n'est pas bon";
        }
        if($_FILES['avatar']['size'] >= 200000){
            $errors['avatar'] = "Le fichier fait plus de 2 mo";
        }
    }
    // détection d'un email déjà présent dans une table
    $query = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $query->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $result= $query->fetch();
    if($result){
        $errors['double'] = "Cet email est déjà enregistré";
    }

    if(count($errors) === 0){
        $password = password_hash($_POST['password'],PASSWORD_ARGON2I);
        // password_hash = crée une clé de hachage pour un mot de passe
        // PASSWORD_ARGON2I = algorithme de hachage Argon2i pour créer le hachage

        // traitement pdo
        $sql = 'INSERT INTO user (name,email,password,avatar,created_at,role) 
                VALUES (:name,:email,:password,:avatar,NOW(),"ROLE_USER")'; // Autoincrémentation = ajout de 1 automatiquement
        $query = $pdo->prepare($sql); // $query = prépare et exécute une requête sql
        $query->bindValue(':name',$_POST['name'], PDO::PARAM_STR); // bindValue = associe une valeur à un paramètre
        $query->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
        $query->bindValue(':password',$password, PDO::PARAM_STR);
        $query->bindValue(':avatar',"./assets/upload".$_FILES['avatar']['name'],PDO::PARAM_STR);

        $query->execute();

        if(!is_dir("../assets/upload")){ // Indique si le dossier existe
            mkdir("../assets/upload");   // créer un dossier
        }
        move_uploaded_file($_FILES['avatar']['tmp_name'],"../assets/upload".$_FILES['avatar']['name']);
        // tout c'est bien passé
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['avatar'] = "../assets/upload".$_FILES['avatar']['name'];
        $_SESSION['role'] = 'ROLE_USER';
        header("Location: ../index.php");
    } else{
        // tout ne s'est pas bien passé
        header("Location:../registration.php?errors=".serialize($errors)."&data=".serialize($_POST));
    }
    /* debug($_FILES);
    debug($errors);
    debug($_POST); */ 
    die;
} else{
    // l'utilisateur n'a pas accès à cette page
    header('Location: index.php');
}