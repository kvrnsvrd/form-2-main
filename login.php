<?php
session_start();
require('inc/function.php');
require('inc/pdo.php');

$errors = [];

if(isset($_GET['errors']) && isset($_GET['data'])){
    $errors = unserialize($_GET['errors']);
    $data = unserialize($_GET['data']);
}   

include('inc/header.php'); ?>

<div class="wrap">
    <h1>Veuillez vous connecter</h1>
        <form method="POST" action="inc/log.php" novalidate enctype = "multipart/form-data">
            <label for="email">Email</label>
            <p><input type="text" name="email" id="email" value="<?php if(!empty($data['email'])) {
            echo $data['email']; } ?>"/>
            <span class="error"><?php viewError($errors,'email');?></span></p>

            <label for="password">Password</label>
            <p><input type="text" name="password" id="password" value="<?php if(!empty($data['password'])) {
            echo $data['password']; } ?>"/>
            <span class="error"><?php viewError($errors,'password');?></span></p>
            
            <input type="submit" name="submitted" value="Envoyer">
            <span class="error"><?php viewError($errors,'invalid');?></span></p>

        </form>
    </div>

<?php include('inc/footer.php');