<?php
session_start();
require('../inc/function.php');
require('../inc/pdo.php');
include('../inc/header.php');
// check admin
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
    die;
}
// get id
if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    header("Location: ../admin.php");
}
// get user
$query = $pdo->prepare("SELECT * FROM vinyl WHERE id = $id");
$query->execute();
$data = $query->fetch();

$errors = [];
if(isset($_GET['errors'])){
    $errors = unserialize($_GET['errors']);
    $data = unserialize($_GET['data']);
}

?>
<link rel="stylesheet" href="../assets/css/style.css">
  
  <div class="wrap">
        <form method="POST" action="updateData-vinyl.php" novalidate enctype = "multipart/form-data">
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
<?php include('../inc/footer.php');