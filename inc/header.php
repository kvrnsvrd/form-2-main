<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Vinyl shop</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if(!isset($_SESSION['name'])){ ?>

                <li><a href="login.php">Se connecter</a></li>

                <?php } else{ ?>

                <li><a href="logout.php">Se déconnecter</a></li>
                <?php } 
                if(isset($_SESSION['role']) && $_SESSION['role'] === "ROLE_ADMIN"){
                ?>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="registration.php">Ajouter un nouvel utilisateur</a></li>
                <li><a href="registration-vinyl.php">Ajouter un nouveau vinyl</a></li>
                <?php } ?>
            </ul>
            <div id="bnjr">
            <?php
                if(isset($_SESSION['name'])){
                    echo "<div>Bonjour ".$_SESSION['name'].'</div>';
                    echo "<img src='".$_SESSION['avatar']."'";
                }
            ?>
            </div>
        </nav>
    </header> 