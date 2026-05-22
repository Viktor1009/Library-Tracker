<?php include("../templates/header.php"); ?>

<?php 
if($_POST){
    require("../../conn.php");

    if($_POST["posttype"] === "Submit"){
        $complete = "Complete";
        $sql = "UPDATE Library SET book_status = ?, book_rating = ?, book_review = ? WHERE book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi", $complete, $_POST["complete_rating"], $_POST["complete_review"], $_POST["book_id"]);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit();
    }
}
?>

    <form method="post" class="input">

        <input type="hidden" name="book_id" value="<?php echo $_GET["id"]; ?>">
        
        <label for="html">Rating</label>
        <input type="range" name="complete_rating" id="myRange" value="1" min="0"  max="5">
        
        <label for="html">Review</label>
        <textarea type="text" name="complete_review" id=""></textarea>
        
        <input class="btn btn-primary" type="submit" name="posttype" value="Submit">
    </form>


<?php include("../templates/footer.php"); ?>