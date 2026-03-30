<?php include("../templates/header.php"); ?>

<?php
$name = $_GET['name'] ?? '';
?>



<form action="" method="POST" enctype="multipart/form-data" class="input">
    <input 
        type="text" name="name" placeholder="name" 
        value="<?php echo htmlspecialchars($name); ?>">
    <textarea 
        type="text" name="description" placeholder="description"></textarea>
    <input class="btn btn-primary" type="submit" value="book_add" name="posttype">
</form>

<?php
if ($_POST) {
    $sql = "Select * From Books Order By book_id Desc LIMIT 1";
    $res = $conn->query($sql);
    $data = $res->fetch_assoc();
    var_dump($data);
    if($_POST["posttype"] == "book_add" && $data["book_name"] != $_POST["name"]){
        $name = $_POST["name"];
        $description = $_POST["description"];

        $sql = "INSERT INTO Books (book_name, book_description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $description);
        $stmt->execute();

        echo 
            '<a href="private_input.php?name='.$name.'">
                <button>Add "'.$name.'" to your Library</button>
            </a>';
        echo
            '<a href="add.php">
                <button>Add another book to the Database </button>
            </a>';
    }
}
?>
<?php include("../templates/footer.php"); ?>