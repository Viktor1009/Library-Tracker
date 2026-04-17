<?php include("../templates/header.php");?>
<?php
require("../../conn.php");

$sql = "SELECT 
            book_id,
            edited_at as activity_date
        FROM Activity
        ORDER BY edited_at ASC";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>
<?php include("../templates/footer.php"); ?>