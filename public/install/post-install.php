<?php include("../templates/header.php"); ?>
<main id="install">
    <?php 
    if(isset($_POST["install"])){
        require_once("../../installScript.php");
    }
    ?>
    <a href="../dashboard/index.php">Dashboard</a>
</main>

<?php include("../templates/footer.php"); ?>

