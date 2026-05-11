<?php include("../templates/header.php"); ?>

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
    <div>
        <h4><?php echo $row["edited_at"] ?></h4>
        <div>
            <h5><?php echo $row["book_name"] ?></h5>
            
        </div>
    </div>

<?php
}


?>

<script>

    async function getData() {
        let res = await fetch("http://library-tracker.local:8080/fetch/activity.php");
        let data = await res.json();

        data.forEach(item => {
            let book_id = item.book_id;
            let [activity_day, activity_time] = item.activity_date.split(" ");

            //console.log("Book ID:", book_id);
            console.log("Day:", activity_day);
            //console.log("Time:", activity_time);

        });
    }

    getData();
</script>

<?php include("../templates/footer.php"); ?>