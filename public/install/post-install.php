<?php include("../templates/header.php"); ?>
<main id="install">
    <?php 
    if(isset($_POST["install"])){
        require_once("../../installScript.php");
    }
    ?>
</main>

<?php include("../templates/footer.php"); ?>

