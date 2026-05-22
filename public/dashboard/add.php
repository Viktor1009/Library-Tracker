<?php include("../templates/header.php"); ?>



<a href="index.php">Dashboard</a>
<main id="add">
    <form method="POST">
        <p>Add New Book</p>
        <input type="text" name="name" placeholder="name">
        <input class="btn btn-primary" type="submit" value="add_book" name="posttype">
    </form>


<?php

require("../../conn.php");


if($_SERVER["REQUEST_METHOD"] == "POST"){

    if($_POST["posttype"] == "add_book"){

        $stmt = $conn->prepare("SELECT * FROM Books WHERE book_name LIKE ?");
        $search = "%" . $_POST["name"] . "%";
        $stmt->bind_param("s", $search);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            echo "<p>Similar books:</p>";

            while($row = $result->fetch_assoc()){
                echo '
                <a href="private_input.php?name='.$row["book_name"].'">
                    '.$row["book_name"].'
                </a><br>';
            }
        }
        if('name' !== 'book_name'){
             echo '
            <br>
            <p>Add new:</p>
            <a href="public_input.php?name='.$_POST["name"].'">
                '.$_POST["name"].'
            </a>';
        }
    }
}
$conn->close();

?>
</main>
<?php include("../templates/footer.php"); ?>