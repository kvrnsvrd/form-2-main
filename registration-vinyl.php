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
<h1>Ajoutez un nouveau vinyl</h1>

    <div class="wrap">
        <form method="POST" action="admin.php" novalidate enctype = "multipart/form-data">
            <!-- enctype = télécharger des données--> 
            <label for="produit">Produit</label>
            <p><input type="text" name="produit" id="produit" value="<?php if(!empty($data['produit'])) {
            echo $data['produit']; } ?>"/>
            <span class="error"><?php viewError($errors,'produit');?></span></p>

            <label for="affichage">Affichage</label>
            <p><input type="file" name="affichage" id="affichage"/>
            <span class="error"><?php viewError($errors,'affichage');?></span></p>

            <label for="prix">Prix</label>
            <p><input type="number" name="prix" id="prix" value="<?php if(!empty($data['prix'])) {
            echo $data['prix']; } ?>"/>
            <span class="error"><?php viewError($errors,'prix');?></span></p>

            <label for="description">Description</label>
            <p><input type="text" name="description" id="description" value="<?php if(!empty($data['description'])) {
            echo $data['description']; } ?>"/>
            <span class="error"><?php viewError($errors,'description');?></span></p>
            
            <span class="error"><?php viewError($errors,'double');?></span></p>

            <input type="submit" name="submit" value="Ajouter">
        </form>
    </div>

<?php include('inc/footer.php');