<?php include("../templates/header.php"); ?>






<?php

    $sql = "SELECT Library.book_id, Library.book_rating, Library.book_status, Library.book_page, Books.book_name
    from Library
    INNER JOIN Books on Library.book_id = Books.book_id";

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ ?>
        <div class="book">
            <div class="book_name">
                <a href="update.php?id=<?php echo $row["book_id"]; ?>">
                    <?php echo $row["book_name"]; ?>
                </a>
            </div>
            <div class="book_rating">
                <img src="../assets/img/star_PNG41449.png" alt="">
                <h5>
                    <?php echo $row["book_rating"]; 
                    if(!$row["book_rating"])echo "0"
                        ?>
                </h5>
            </div>
            <div class="book_status">
                <h5>
                    <?php echo $row["book_status"]; ?>
                </h5>
            </div>
            <div class="book_page">
                <h5>
                    <?php echo $row["book_page"]; ?>
                </h5>
            </div>
        </div>
            
        <?php
        }
    }
    ?>
<?php include("../templates/footer.php"); ?>