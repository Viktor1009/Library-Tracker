<?php include("../templates/header.php"); 
var_dump($_POST);

?>



<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="name" value="<?php echo $_GET['name']?>">
    <input class="btn btn-primary" type="submit" value="books_info" name="posttype">
</form>

<?php

?>
<?php include("../templates/footer.php"); ?>