<?php include("../templates/header.php"); ?>


<?php
    if($_POST){
        require("../../conn.php");
        if($_POST["posttype"] == "Update"){
            echo "Update";

            $sql = "UPDATE Library SET book_status = ?, book_page = ?, book_notes = ? WHERE book_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sisi", $_POST["update_status"], $_POST["update_page"], $_POST["update_notes"], $_POST["update_id"]);
            $stmt->execute();
            $stmt->close();
        }
    }
    
    $sql = "SELECT * FROM Library
    INNER JOIN Books on Library.book_id = Books.book_id
    WHERE Books.book_id=" . $_GET["id"];

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ 
            var_dump($row);?>
            <form method="post" enctype="multipart/form-data">
                <input 
                    type="text" name="update_id" 
                    value="<?php echo $row["book_id"]?>" 
                    hidden>
                <input 
                    type="text" name="update_name" placeholder="name" 
                    value="<?php echo $row["book_name"];?>"
                    readonly class="read-only">>
                <textarea 
                    type="text" name="update_description" placeholder="description"
                    readonly class="read-only"
                    ><?php echo $row["book_description"];?></textarea>
                <input 
                    type="text" name="update_status" 
                    value="<?php echo $row["book_status"];?>">
                <input 
                    type="text" name="update_page"
                    value="<?php echo $row["book_page"];?>">  
                <!-- Din personliga rating bör vara en slider-->
                <textarea 
                    type="text"name="update_notes"
                    ><?php echo $row["book_notes"];?></textarea>
                <input class="btn btn-primary" type="submit" name="posttype" value="Update">
            </form>
        <?php
        }   
    }
    ?> 
    
<?php include("../templates/footer.php"); ?>