<?php
session_start();
require('function.php');
require('pdo.php');

if(!empty($_POST['submitted'])){
    $errors = [];
    $errors = validText($errors, $_POST['password'],'password',5,8);
    $errors = validEmail($errors, $_POST['email']);

    $query = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $query->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $result= $query->fetch();
    if($result){
        $user = $result;

        if (!password_verify($_POST['password'], $user['password'])){
            // password_verify = vérifie qu'un mot de passe correspond à un hachage
            $errors['invalid'] = 'Le mot de passe est invalid !';
        }
    }   else{
        $errors['invalid'] = "Votre email et votre password sont incorrects";
    }

    if(count($errors) === 0){
        // success
        echo "Success !";
        $_SESSION['name'] = $user['name'];
        $_SESSION['avatar'] = $user['avatar'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../index.php");
    } else{
        // tout ne s'est pas bien passé
        header("Location:../login.php?errors=".serialize($errors)."&data=".serialize($_POST));
    }

} else{
    header("Location: ../index.php");
}