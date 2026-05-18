<?php include("../templates/header.php"); ?>
<div class="detail-container">
<?php

$date = $_GET["date"] ?? "";

$sql = "SELECT Activity.edited_at, Activity.book_id, Books.book_name, Books.book_id
        From Activity
        Inner Join Books on Activity.book_id = Books.book_id
        WHERE Activity.edited_at LIKE '$date%'";

$result = $conn->query($sql);
$data = [];

while($row = $result->fetch_assoc()){ 
    ?>
    <div class="activity-detail">
        <h4><?php echo $row["edited_at"] ?></h4>
        <div>
            <h5><?php echo $row["book_name"] ?></h5>
            
        </div>
    </div>

<?php
}


?>
</div>

<?php include("../templates/footer.php"); ?>