<?php include("../templates/header.php"); ?>



<a href="index.php">Dashboard</a>
<main id="add">
    <form method="POST" enctype="multipart/form-data">
        <p>Add New Book</p>
        <input type="text" name="name" placeholder="name">
        <input class="btn btn-primary" type="submit" value="add_book" name="posttype">
    </form>
</main>

<?php

require("../../conn.php");
if($_POST){
    if($_POST["posttype"] == "add_book"){
        echo "add_book";

        $sql = "SELECT * FROM Books WHERE book_name LIKE '%".$_POST["name"]."%'";
        $result = $conn->query($sql);
        
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '<button>'.$row["book_name"].'</button>';
            }
        } 
        else {
        echo '<button>Lägg till denna bok</button>';
        }
    }
}
$conn->close();

?>

<?php include("../templates/footer.php"); ?>