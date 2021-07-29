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
$query = $pdo->prepare("SELECT * FROM user WHERE id = $id");
$query->execute();
$data = $query->fetch();

$errors = [];
if(isset($_GET['errors'])){
    $errors = unserialize($_GET['errors']);
    $data = unserialize($_GET['data']);
}

?>
<link rel="stylesheet" href="../assets/css/style.css">
  <div class="wrapform">
      <form action="./updateData.php?id=<?= $id; ?>" method="POST" novalidate enctype="multipart/form-data">

          <label for="email">Email</label>
          <input type="text" name="email" id="email" value="<?php if(!empty($data['email'])) {echo $data['email']; } ?>">
          <span class="error"><?php viewError($errors,'email'); ?></span>

          <label for="password">Password</label>
          <input type="text" name="password" id="password">
          <span class="error"><?php viewError($errors,'password'); ?></span>

          <label for="name">Nom</label>
          <input type="text" name="name" id="name" value="<?php if(!empty($data['name'])) {echo $data['name']; } ?>">
          <span class="error"><?php viewError($errors,'name'); ?></span>

          <label for="avatar">Avatar</label>
          <input type="file" name="avatar" id="avatar">
          <span class="error"><?php viewError($errors,'avatar'); ?></span>
          <img src=".<?= $data['avatar']; ?>" alt="">

          <input type="submit" name="submitted" value="Update">
      </form>
  </div>
<?php include('../inc/footer.php');