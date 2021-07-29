<?php
session_start();

require('inc/function.php');
require('inc/pdo.php');

$itemPerPage=9;
$page=1;
$offset=0;

if(!empty($_GET['page'])){
    $page=$_GET['page'];
    $offset =($page - 1) *$itemPerPage;
}

$sql = "SELECT * FROM vinyl ORDER BY id DESC LIMIT $itemPerPage OFFSET $offset";
$query = $pdo->prepare($sql);
$query->execute();
$vinyls = $query->fetchAll();

$sql = "SELECT COUNT(id) FROM vinyl";
$query = $pdo->prepare($sql);
$query->execute();
$count = $query->fetchColumn();

include('inc/header.php'); ?>
<h1 class="tc">VINYL SHOP</h1>
<div id="mesreves">
    <?php foreach ($vinyls as $vinyl) { ?>
        <div class="one_reve">
            <h3><?= $vinyl['produit']; ?></h3>
            <p>Prix<?= $vinyl['prix']; ?></p>
            <?php echo "<img src='" . $vinyl['affichage'] . "'>";?>
            <p><?php echo substr($vinyl['description'],0,15); ?> ...</p>

        </div>
    <?php } ?>
</div>

<ul class="pagination">
    <li><a href="index.php">1</a></li>
    <li><a href="index.php?page=2">2</a></li>
    <li><a href="index.php?page=3">3</a></li>

</ul>


<?php include('inc/footer.php');
