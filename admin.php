<?php
session_start();
require('inc/pdo.php');
require('inc/function.php');
if(isset($_GET['sort'])){
    $order = "ORDER BY".$_GET['sort'];
} else{
    $order = "";
}

if(!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER"){
// si le rôle est invalid ou si il est égale au rôle user
    header(("Location: ./index.php"));
} 

$query = $pdo->prepare("SELECT * FROM user");
$query->execute();
$allUsers = $query->fetchAll();

$query = $pdo->prepare("SELECT * FROM vinyl");
$query->execute();
$allVinyl = $query->fetchAll();
include("inc/header.php");
echo "Bienvenue";

$i = 0;
?>
<h1>Utilisateur</h1>

<table>
    <thead>
        <th><a href="?sort=id">Id</a></th>
        <th><a href="?sort=name">Name</a></th>
        <th><a href="?sort=email">Email</a></th>
        <th><a href="?sort=role">Rôle</a></th>
        <th><a href="?sort=created_at">Created_at</a></th>
        <th>Show</th>
        <th>Update</th>
        <th>Delete</th>
    </thead>
<?php while ($i < count($allUsers)) : ?>
    <tr>
        <td><?= $allUsers[$i]['id']; ?></td>
        <td><?= $allUsers[$i]['name']; ?></td>
        <td><?= $allUsers[$i]['email']; ?></td>
        <td><?= $allUsers[$i]['role']; ?></td>
        <td><?= $allUsers[$i]['created_at']; ?></td>
        <td><a href="back/show.php?id=<?= $allUsers[$i]['id']; ?>">Show</a></td>
        <td><a href="back/update.php?id=<?= $allUsers[$i]['id']; ?>">Update</a></td>
        <td><a href="back/delete.php?id=<?= $allUsers[$i]['id']; ?>">Delete</a></td>
    </tr>    
<?php 
    $i++; 
endwhile; ?>

</table>

<h1>Vinyl</h1>
<?php $i = 0;
?>

<table id="allVinyl">
    <thead>
        <th><a href="?sort=produit">Produit</a></th>
        <th><a href="?sort=prix">Prix</a></th>
        <!-- <th>show</th> -->
        <th>Update</th>
        <th>Delete</th>
    </thead>
    <?php while ($i < count($allVinyl)) : ?>
        <tr>
            <td><?= $allVinyl[$i]['produit']; ?>
            <td><?= $allVinyl[$i]['prix']; ?>
            <td><a href="./back/update-vinyl.php?id=<?= $allVinyl[$i]['id']; ?>">Update</a>
            <td><a href="./back/delete-vinyl.php?id=<?= $allVinyl[$i]['id']; ?>">Delete</a>
        </tr>
    <?php
        $i++;
    endwhile;

    
?>






