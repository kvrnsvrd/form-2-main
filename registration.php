<?php
session_start();
require('inc/function.php');
$errors = [];

if(isset($_GET['errors']) && isset($_GET['data'])){
    $errors = unserialize($_GET['errors']);
    $data = unserialize($_GET['data']);
}   // ISSET = vérifie qu'une variable est déclarée et est non de null
    // SERIALIZE = Retourne une chaine de caractère.
    // UNSERIALIZE = convertit une valeur en variable php


include('inc/header.php'); ?>
<h1>Ajoutez un nouvel utilisateur</h1>
    <div class="wrap">
        <form method="POST" action="inc/register.php" novalidate enctype = "multipart/form-data">
            <!-- enctype = télécharger des données--> 
            <label for="name">Name</label>
            <p><input type="text" name="name" id="name" value="<?php if(!empty($data['name'])) {
            echo $data['name']; } ?>"/>
            <span class="error"><?php viewError($errors,'name');?></span></p>

            <label for="email">Email</label>
            <p><input type="text" name="email" id="email" value="<?php if(!empty($data['email'])) {
            echo $data['email']; } ?>"/>
            <span class="error"><?php viewError($errors,'email');?></span></p>

            <label for="password">Password</label>
            <p><input type="text" name="password" id="password" value="<?php if(!empty($data['password'])) {
            echo $data['password']; } ?>"/>
            <span class="error"><?php viewError($errors,'password');?></span></p>

            <label for="avatar">Avatar</label>
            <p><input type="file" name="avatar" id="avatar"/>
            <span class="error"><?php viewError($errors,'avatar');?></span></p>

            <label for="mentions">Mention légales</label>
            <p><input type="checkbox" name="mentions" id="mentions"/>
            <span class="error"><?php viewError($errors,'mentions');?></span></p>
            
            <span class="error"><?php viewError($errors,'double');?></span></p>

            <input type="submit" name="submitted" value="Envoyer">
        </form>
    </div>

<?php include('inc/footer.php');