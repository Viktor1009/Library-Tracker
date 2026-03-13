<?php include("../templates/header.php"); ?>






<?php

    $sql = "SELECT Library.book_id, Library.book_your_rating, Library.book_status, Library.book_page, Books.book_name
    from Library
    INNER JOIN Books on Library.book_id = Books.book_id";

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ ?>
        <div class="book">
            <a href="update.php?id=<?php echo $row["book_id"]; ?>">
                <?php echo $row["book_name"]; ?>
            </a>
            <h5>
                <?php echo $row["book_your_rating"]; ?>
            </h5>
            <h5><!-- book status-->
                <?php 
                if($row["book_status"] == 1){
                    echo "Reading";
                }
                elseif($row["book_status"] == 2){
                    echo "On Hold";
                }
                elseif($row["book_status"] == 3){
                    echo "Plan to Read";
                }
                elseif($row["book_status"] == 4){
                    echo "Completed";
                }
                elseif($row["book_status"] == 5){
                    echo "Dropped";
                }
                ?>
            </h5>
            <h5>
                <?php echo $row["book_page"]; ?>
            </h5>
        </div>
            
        <?php
        }
    }
    ?>
<?php include("../templates/footer.php"); ?>