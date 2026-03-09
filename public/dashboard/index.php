<?php include("../templates/header.php"); ?>
<?php

    $sql = "SELECT Library.book_id, Library.book_your_rating, Library.book_status, Library.book_page, Books.book_name
    from Library
    INNER JOIN Books on Library.book_id = Books.book_id";

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ ?>
        <div>
            <a href="update.php?id=<?php echo $row["book_id"]; ?>">
                <?php echo $row["book_name"]; ?>
            </a>
            <h4>
                <?php echo $row["book_your_rating"]; ?>
            </h4>
            <h4>
                <?php echo $row["book_status"]; ?>
            </h4>
            <h4>
                <?php echo $row["book_page"]; ?>
            </h4>
        </div>
            
        <?php
        }
    }
    ?>
<?php include("../templates/footer.php"); ?>