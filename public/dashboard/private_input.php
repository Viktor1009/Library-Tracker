<?php include("../templates/header.php"); ?>


<?php 
$name = $_GET['name'] ?? '';

$sql = "SELECT book_description, book_id FROM Books WHERE book_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$description = $row['book_description'] ?? '';
$book_id = $row['book_id'];
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
    <input 
        type="text" name="status" placeholder="status">
    <input 
        type="text" name="page" placeholder="page">
    <textarea
        type="text" name="notes" placeholder="notes"></textarea>
    <input  class="btn btn-primary" type="submit" value="library_add" name="posttype">
</form>

<?php 
if ($_POST) {
    if($_POST["posttype"] = "library_add") {    
        $user_id = 1; // ändra senare till riktig user
        $sql = "INSERT INTO Library (user_id, book_id, book_status, book_page, book_notes) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $user_id, $book_id, $_POST['status'], $_POST['page'], $_POST['notes']);
        $stmt->execute();
    }
}
?>

<?php include("../templates/footer.php"); ?>
