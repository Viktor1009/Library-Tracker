<?php include("../templates/header.php"); ?>


<?php 
$name = $_GET['name'] ?? '';

$sql = "SELECT book_description FROM Books WHERE book_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$description = $row['book_description'] ?? '';
?>
<form action="" method="POST" enctype="multipart/form-data" class="input">
    <input 
        type="text" name="name" placeholder="name" 
        value="<?php echo isset($name) ? $name : ''; ?>" 
        readonly class="read-only">
    <textarea 
        type="text" name="description" placeholder="description"
        readonly class="read-only">
        <?php echo htmlspecialchars($description); ?>
    </textarea>
    <!-- status bör vara en dropdown meny-->
    <input 
        type="text" name="status" placeholder="status">
    <input 
        type="text" name="page" placeholder="page">
    <textarea
        type="text" name="description" placeholder="description"></textarea>
    <input  class="btn btn-primary" type="submit" value="library_add" name="posttype">
</form>

<?php include("../templates/footer.php"); ?>
